<?php

class Liveconfig_Config
{
    protected $configuration;

    public function __construct($config_file = null)
    {
        $this->configuration = array(

            //Endpoint and access data
            'api_user'      => 'username',
            'api_password'  => 'password',
            'api_endpoint'  => 'https://host.example.com:8443/liveconfig/soap?wsdl',

            'io_class'      => 'Liveconfig_IO_Soap',
            'cache_class'   => 'Liveconfig_Cache_File',
            'logger_class'  => 'Liveconfig_Logger_Null',

           // Definition of class specific values, like file paths and so on.
            'classes' => array(

                //Define an endpoint for an api-call
                'Liveconfig_Service_System' => array(
                    //'endpoint' => 'http://example.com',
                ),


                'Liveconfig_IO_Abstract' => array(
                    'request_timeout_seconds' => 3,
                ),
                'Liveconfig_IO_Soap' => array(
                    //if you wana use a proxy
                    #'proxy_type' => 'CURLPROXY_HTTP',
                    #'proxy_host' => 'localhost',
                    #'proxy_port' => '8888',

                    //SOAPClient options for WSDL-Mode
                    'options' => array(
                        'style'    => SOAP_DOCUMENT,
                        'use'      => SOAP_LITERAL,
                        'stream_context' => stream_context_create(
                            array(
                                'ssl' => array(
                                    'verify_peer' => true,
                                    'verify_peer_name' => false,
                                    'allow_self_signed' => true
                                )
                            )
                        ),
                        'exceptions'=>true,
                        'trace'=>1,
                        'cache_wsdl'=>WSDL_CACHE_NONE
                    ),
                ),
                'Liveconfig_Logger_Abstract' => array(
                    'level' => 'debug',
                    'log_format' => "[%datetime%] %level%: %message% %context%\n",
                    'date_format' => 'd/M/Y:H:i:s O',
                    'allow_newlines' => true
                ),
                'Liveconfig_Logger_File' => array(
                    'file' => 'php://stdout',
                    'mode' => 0640,
                    'lock' => false,
                ),
                'Liveconfig_Http_Request' => array(

                ),
                'Liveconfig_Cache_File' => array(
                    'directory' => sys_get_temp_dir() . '/Liveconfig'
                )
            ),
        );
        $config = false;
        //allows set config as array (for unittests)
        if(is_array($config_file)){
            $config = $config_file;
        }elseif ($config_file && file_exists($config_file) && is_readable($config_file)) {
            $file = file_get_contents($config_file);
            if (empty($file)) {
                return true;
            }
            $config = json_decode($file, true);
        }

        if ($config && is_array($config) && count($config)) {
            $merged_configuration = array_replace_recursive($this->configuration,$config);
            $this->configuration = $merged_configuration;
        }
        date_default_timezone_set('Europe/Berlin');
    }

    public function setClassConfig($class, $config, $value = null)
    {
        if (!is_array($config)) {
            if (!isset($this->configuration['classes'][$class])) {
                $this->configuration['classes'][$class] = array();
            }
            $this->configuration['classes'][$class][$config] = $value;
        } else {
            $this->configuration['classes'][$class] = $config;
        }
    }
    public function getClassConfig($class, $key = null)
    {
        if (!isset($this->configuration['classes'][$class])) {
            return null;
        }
        if ($key === null) {
            return $this->configuration['classes'][$class];
        } else {
            return $this->configuration['classes'][$class][$key];
        }
    }

    public function getCacheClass()
    {
        return $this->configuration['cache_class'];
    }

    public function getLoggerClass()
    {
        return $this->configuration['logger_class'];
    }

    public function setIoClass($class)
    {
        $prev = $this->configuration['io_class'];
        if (!isset($this->configuration['classes'][$class]) &&
            isset($this->configuration['classes'][$prev])) {
            $this->configuration['classes'][$class] =
                $this->configuration['classes'][$prev];
        }
        $this->configuration['io_class'] = $class;
    }

    public function setCacheClass($class)
    {
        $prev = $this->configuration['cache_class'];
        if (!isset($this->configuration['classes'][$class]) &&
            isset($this->configuration['classes'][$prev])) {
            $this->configuration['classes'][$class] =
                $this->configuration['classes'][$prev];
        }
        $this->configuration['cache_class'] = $class;
    }

    public function setLoggerClass($class)
    {
        $prev = $this->configuration['logger_class'];
        if (!isset($this->configuration['classes'][$class]) &&
            isset($this->configuration['classes'][$prev])) {
            $this->configuration['classes'][$class] =
                $this->configuration['classes'][$prev];
        }
        $this->configuration['logger_class'] = $class;
    }

    public function getIoClass()
    {
        return $this->configuration['io_class'];
    }

    public function setEndpoint($entpoint){
        $this->configuration['api_endpoint'] = $entpoint;
    }

    public function getEndpoint()
    {
        return $this->configuration['api_endpoint'];
    }

    public function setAuth(){
        $args = func_get_args();
        if(count($args) == 2){
            $this->configuration['api_user'] = $args[0];
            $this->configuration['api_password'] = $args[1];
        }else{
            $this->configuration['api_user'] = $args[0]['api_user'];
            $this->configuration['api_password'] = $args[0]['api_password'];
        }
    }

    public function getAuth(){
        return array(
            'api_user' => $this->configuration['api_user'],
            'api_password' => $this->configuration['api_password']
        );
    }

}