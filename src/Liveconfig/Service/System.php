<?php

class Liveconfig_Service_System extends Liveconfig_Service
{
    public $system;

    public function __construct(Liveconfig_Client $client)
    {
        parent::__construct($client);
        $this->system = new Liveconfig_Service_System_System_Resource(
            $this,
            'system',
            array(
                'methods' => array(
                    'TestSayHello' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'firstname' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'lastname' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                        ),
                    ),
                    'LiveConfigVersion' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(

                        ),
                    ),
                )
            )
        );
    }
}

class Liveconfig_Service_System_System_Resource extends Liveconfig_Service_Resource
{

    public function TestSayHello($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('TestSayHello', array($params),'Liveconfig_Service_System_TestSayHelloResponse');
    }

    public function LiveConfigVersion($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('LiveConfigVersion', array($params),'Liveconfig_Service_System_LiveConfigVersionResponse');
    }


}

#TestSayHello
class Liveconfig_Service_System_TestSayHelloResponse extends Liveconfig_Collector
{
    public $greeting;
}

#LiveConfigVersion
class Liveconfig_Service_System_LiveConfigVersionResponse extends Liveconfig_Collector
{
    public $version;
    public $revision;
    public $major;
    public $minor;
    public $patch;
}