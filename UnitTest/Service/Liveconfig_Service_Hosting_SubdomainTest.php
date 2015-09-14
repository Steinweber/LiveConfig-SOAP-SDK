<?php

class Liveconfig_Service_Hosting_SubdomainTest extends PHPUnit_Framework_TestCase
{
    protected $subscription = 'web34';

    public function testHostingSubdomainAdd()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('hosting');

        $params = array(
            'subscription'  => $this->subscription, #required
            'subdomain'        => 'demo.example.com',
            'mail'          => 1,
        );

        $result = $service->subdomain->add($params);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_SubdomainAddResponse',$result);
    }
}
