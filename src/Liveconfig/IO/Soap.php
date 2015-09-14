<?php


class Liveconfig_IO_Soap extends Liveconfig_IO_Abstract
{

    protected $options;
    private $soapClient = null;

    public function __construct(Liveconfig_Client $client){
        parent::__construct($client);
        if(!class_exists('SOAPClient')){
            $client->getLogger()->critical('SOAPClient is not installed or is disabled!');
            throw new Liveconfig_IO_Exception('SOAPClient is not installed or is disabled!');
        }
    }

    public function setTimeout($timeout){

    }

    public function setOptions($options){
        $this->options = array_merge($this->options,$options);
    }

    public function executeRequest(Liveconfig_Http_Request $request){

        if(!$this->soapClient){
            $this->newClient($request->getEndpoint());
            if(!$this->soapClient){
                throw new Liveconfig_IO_Exception('Could not connect to server');
            }
        }
        try
        {
            $result = $this->soapClient->{$request->getMethod()}($request->getBody());
            if(!is_soap_fault($result)){
                //object to array
                $result = json_decode(json_encode($result),true);
            }
            $headers = $this->getHttpResponseHeaders($this->soapClient->__getLastResponseHeaders());
            if(isset($headers['response_code'])){
                $httpCode = $headers['response_code'];
                unset($headers['response_code']);
            }else{
                $httpCode = 0;
            }
            return array(
                $result,
                $headers,
                $httpCode
            );
        }
        catch (SoapFault $soapFault)
        {
            throw new Liveconfig_IO_Exception($soapFault->faultstring);
        }
        catch(Exception $exception) {
            throw new Liveconfig_IO_Exception($exception->getMessage());
        }
    }

    public function newClient($endpoint)
    {
        try
        {
            $this->soapClient = @new SoapClient($endpoint, $this->options);
        }
        catch (SoapFault $soapFault)
        {
            $this->client->getLogger()->critical($soapFault->faultstring);
            throw new Liveconfig_IO_Exception($soapFault->faultstring);
        }
        catch(Exception $exception) {
            $this->client->getLogger()->critical($exception->getMessage());
            throw new Liveconfig_IO_Exception($exception->getMessage());
        }
    }
}