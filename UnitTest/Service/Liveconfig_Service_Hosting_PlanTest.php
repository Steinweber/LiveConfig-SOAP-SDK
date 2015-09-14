<?php

/**
 * Created by PhpStorm.
 * User: Steinweber
 * Date: 01.09.2015
 * Time: 19:58
 */
class Liveconfig_Service_Hosting_PlanTest extends PHPUnit_Framework_TestCase
{
    public function testHostingPlanAdd()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('hosting');

        $params = array(
            'name'          => 'HostingPlan_'.rand(999,99999), #required
            'maxcustomers'  => null, #empty for non-reseller
            'maxusers'      => rand(1,9), #required
            'webspace'      => (rand(1,5)*1024),
            'ssi'           => '1',
            'php'           => '1',
            'cgi'           => '1',
            'ssl'           => '1',
            'cronjobs'      => '2',
            'apps'          => '3',
            'ftpaccounts'   => '4',
            'shellaccess'   => '0',
            'databases'     => '6',
            'subdomains'    => '7',
            'extdomains'    => '8',
            'mailboxes'     => '9',
            'mailaddrs'     => '10',
            'mailquota'     => rand(999,999999),
            'traffic'       => rand(999,999999),
        );

        $result = $service->plan->add($params);
        var_dump($result);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_PlanAddResponse',$result);
    }

    public function testHostingPlanGet()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('hosting');

        $params = array(
            //'name'          => 'HostingPlan_47568'
        );

        $result = $service->plan->get($params);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_PlanGetResponse',$result);
    }
}
