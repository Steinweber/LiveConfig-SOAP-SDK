<?php

class Liveconfig_Service_Hosting_CronTest extends PHPUnit_Framework_TestCase
{
    protected $subscription = 'web34';

    public function testHostingCronAdd()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('hosting');

        $params = array(
            'subscription'  => $this->subscription, #required
            'active'        => 1,
            'minute'        => 1,
            'hour'          => 1,
            'day'           => 1,
            'month'         => 1,
            'weekday'       => 1,
            'command'       => 1,
        );

        $result = $service->cron->add($params);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_CronAddResponse',$result);
        $this->assertEquals('ok',$result->status);
    }
}
