<?php

class Liveconfig_Service_Hosting_FtpTest extends PHPUnit_Framework_TestCase
{
    protected $subscription = 'web34';

    public function testHostingFtpAdd()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('hosting');

        $params = array(
            'subscription'  => $this->subscription, #required
            'login'         => 'web3424', #required
            'password'      => 'Maw6PeajefBecUd', #required
            'path'          => '/', #required
        );

        $result = $service->ftp->add($params);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_FtpAddResponse',$result);
        $this->assertEquals('ok',$result->status);
    }
}
