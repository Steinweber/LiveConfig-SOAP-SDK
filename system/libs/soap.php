<?php

 class LcSoap
 {

 	private $client;
 	private $requestConfig = array('wsdlConfig' => array('style' => SOAP_DOCUMENT, 'use' => SOAP_LITERAL));
 	private $registry;

 	public function __construct($registry)
 	{
 		$this->registry = $registry;
 	}

 	public function newClient()
 	{
 		$this->wsdl();
 		
        try
 		{
 			$this->client = new SoapClient($this->requestConfig['wsdlUrl'], $this->requestConfig['wsdlConfig']);
 		}
 		catch (SoapFault $soapFault)
 		{
 		    $this->registry->get('log')->write($soapFault->faultstring);
 			DIE($soapFault->faultstring);
            exit();
 		}
        catch(Exception $exception) {
            $this->registry->get('log')->write($exception->getMessage());
            DIE($exception->getMessage());
            exit();
        }
 	}

 	private function wsdl()
 	{
 		$wsdl = $this->requestConfig['soap_url'];
 		$wsdl .= '?wsdl';
 		$wsdl .= '&l=' . urlencode($this->requestConfig['soap_user']);
 		$wsdl .= '&p=' . urlencode($this->requestConfig['soap_pass']);
 		$this->requestConfig['wsdlUrl'] = $wsdl;
 	}

 	public function wsdlConfig($params)
 	{
 		if ($params && is_array($params))
 		{
 			foreach ($params as $key => $entry)
 			{
 				$this->$requestConfig['wsdlConfig'][$key] = $entry;
 			}
 		}
 	}

 	private function token()
 	{
 		$timestamp = gmdate("Y-m-d") . "T" . gmdate("H:i:s") . ".000Z";
 		$this->requestConfig['timestamp'] = $timestamp;
 		$this->requestConfig['token'] = base64_encode(hash_hmac('sha1', 'LiveConfig' . $this->requestConfig['soap_user'] . $this->requestConfig['function'] . $timestamp, $this->requestConfig['soap_pass'], true));
 	}

 	private function authData($auth)
 	{
 		$this->requestConfig['soap_user'] = $this->registry->get('config')->get('soap_user');
 		$this->requestConfig['soap_pass'] = $this->registry->get('config')->get('soap_pass');
 		$this->requestConfig['soap_url'] = $this->registry->get('config')->get('soap_url');
 		if ($auth && is_array($auth))
 		{
 			foreach ($auth as $key => $entry)
 			{
 				$this->requestConfig[$key] = $entry;
 			}
 		}
 	}

 	private function getParams($params)
 	{
 		if (!$params or !is_array($params))
 		{
 			$params = array();
 		}
 		$params['auth'] = array(
 			'login' => $this->requestConfig['soap_user'],
 			'timestamp' => $this->requestConfig['timestamp'],
 			'token' => $this->requestConfig['token']);
 		return $params;
 	}

 	public function request($function, $params, $auth)
 	{
 		$this->requestConfig['function'] = $function;
 		$this->authData($auth);
 		if (!$this->client)
 		{
 			$this->newClient();
 		}
 		$this->token();
 		$params = $this->getParams($params);
 		try
 		{
 			$response = $this->client->{$function}($params);
            $status = true;
 		}
 		catch (SoapFault $soapFault)
 		{
 			$response = "Error: " . $soapFault->faultstring;
            $status = false;
            $this->registry->get('log')->write($function.' => '.$response);
 		}
        catch(Exception $exception) {
            $response = "Error: " . $soapFault->faultstring;
            $status = false;
            $this->registry->get('log')->write($function.' => '.$response);
        }
 		return array('status'=>$status,'response'=>$response);
 	}
 }
