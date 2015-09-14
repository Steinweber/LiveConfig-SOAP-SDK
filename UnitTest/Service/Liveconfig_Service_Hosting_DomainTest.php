<?php

class Liveconfig_Service_Hosting_DomainTest extends PHPUnit_Framework_TestCase
{
    protected $subscription = 'web34';

    public function testHostingDomainAdd()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('hosting');

        $params = array(
            'subscription'  => $this->subscription, #required
            'domain'        => 'example.com',
            'mail'          => 1,
        );

        $result = $service->domain->add($params);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_DomainAddResponse',$result);
    }
}
