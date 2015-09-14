<?php

class Liveconfig_Service
{
    public $endpoint;
    public $api_username = null;
    public $api_password = null;
    public $resource;
    private $client;

    public function __construct(Liveconfig_Client $client)
    {
        $this->client = $client;

        $config = $this->client->getClassConfig(get_called_class());

        if($config){
            foreach($config as $k => $v){
                $this->$k = $v;
            }
        }


    }

    public function getClient()
    {
        return $this->client;
    }
}