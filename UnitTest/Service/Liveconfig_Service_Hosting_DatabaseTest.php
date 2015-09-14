<?php

class Liveconfig_Service_Hosting_DatabaseTest extends PHPUnit_Framework_TestCase
{
    protected $subscription = 'web34';

    public function testHostingDatabaseAdd()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('hosting');

        $params = array(
            'subscription'  => $this->subscription, #required
            'name'          => 'DB'.rand(999,999999),
            'login'         => 'db_'.rand(999,99999),
            'comment'       => 'Comment as a string',
            'extern'        => 1,
            'create'        => 1,
            'password'      => 'Password'.rand(999,99999).'Test',

        );

        $result = $service->database->add($params);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_DatabaseAddResponse',$result);
    }
}
