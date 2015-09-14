<?php

class Liveconfig_Client
{
    const LIBVER = "2.0.0";

    private $cache;
    private $config;
    private $logger;
    private $services;

    public function __construct($config = null)
    {
        if (is_string($config) && strlen($config)) {
            $config = new Liveconfig_Config($config);
        } else if (!($config instanceof Liveconfig_Config)) {
            $config = new Liveconfig_Config();
        }
        $this->config = $config;
        $this->services = new stdClass();
    }

    public function execute($request)
    {
        if ($request instanceof Liveconfig_Http_Request) {
            $request->setUserAgent('LiveConfig API SDK v'. $this->getClientVersion());
            $class = $this->config->getIoClass();
            $class = new $class($this);
            return $class->makeRequest($request);
        } else {
            throw new Liveconfig_Exception("Do not know how to execute this type of object.");
        }
    }

    public function getIo()
    {
        if (!isset($this->io)) {
            $class = $this->config->getIoClass();
            $this->io = new $class($this);
        }
        return $this->io;
    }

    public function getCache()
    {
        if (!isset($this->cache)) {
            $class = $this->config->getCacheClass();
            $this->cache = new $class($this);
        }
        return $this->cache;
    }

    public function getLogger()
    {
        if (!isset($this->logger)) {
            $class = $this->config->getLoggerClass();
            $this->logger = new $class($this);
        }
        return $this->logger;
    }

    public function getConfig(){
        return $this->config;
    }

    public function getAuth(){
        return $this->config->getAuth();
    }

    public function getAuthToken($function){

        $auth = $this->config->getAuth();
        $ts = gmdate("Y-m-d") . "T" . gmdate("H:i:s") . ".000Z";
        $token = base64_encode(hash_hmac('sha1',
                'LiveConfig' . $auth['api_user'] . $function . $ts,
                $auth['api_password'],
                true
            )
        );

        return array(
            'login'     => $auth['api_user'],
            'timestamp' => $ts,
            'token'     => $token
        );

    }

    public function getService($service){
        if(isset($this->services->$service)){
            return $this->services->$service;
        }
        $service_class = 'Liveconfig_Service_'.ucfirst($service);
        $this->services->$service = new $service_class($this);
        return $this->services->$service;
    }

    public function getEndpoint(){
        return $this->config->getEndpoint();
    }

    public function getClientVersion(){
        return self::LIBVER;
    }

    public function getClassConfig($class, $key = null)
    {
        if (!is_string($class)) {
            $class = get_class($class);
        }
        return $this->config->getClassConfig($class, $key);
    }

    public function setClassConfig($class, $config, $value = null)
    {
        if (!is_string($class)) {
            $class = get_class($class);
        }
        $this->config->setClassConfig($class, $config, $value);
    }


}