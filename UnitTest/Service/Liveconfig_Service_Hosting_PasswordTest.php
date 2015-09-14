<?php

class Liveconfig_Service_Hosting_PasswordTest extends PHPUnit_Framework_TestCase
{
    protected $subscription = 'web34';

    public function testHostingPasswordUserAdd()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('hosting');

        $params = array(
            'subscription'  => $this->subscription, #required
            'login'         => 'UnitTest', #required
            'password'      => 'ab4c123', #required
        );

        $result = $service->password->user->add($params);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_PasswordUserAddResponse',$result);
        $this->assertEquals('ok',$result->status);
    }

    public function testHostingPasswordPathAdd()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('hosting');

        $params = array(
            'subscription'  => $this->subscription, #required
            'path'          => '/htdocs/', #required
            'title'         => 'UnitTestTitle', #required
            'login'         => 'UnitTest', #required
        );

        $result = $service->password->path->add($params);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_PasswordPathAddResponse',$result);
        $this->assertEquals('ok',$result->status);
    }
}
