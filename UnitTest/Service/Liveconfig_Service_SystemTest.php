<?php

/**
 * Created by PhpStorm.
 * User: Steinweber
 * Date: 27.08.2015
 * Time: 15:48
 */
class Liveconfig_Service_SystemTest extends PHPUnit_Framework_TestCase
{
    public function testLiveConfigVersion()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('system');

        $result = $service->system->LiveConfigVersion(array());
        $this->assertInstanceOf('Liveconfig_Service_System_LiveConfigVersionResponse',$result);
    }

    public function testTestSayHello()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('system');

        $params = array(
            'firstname' => 'John',
            'lastname' => 'Doe'
        );

        $result = $service->system->TestSayHello($params);
        $this->assertInstanceOf('Liveconfig_Service_System_TestSayHelloResponse',$result);
    }
}
