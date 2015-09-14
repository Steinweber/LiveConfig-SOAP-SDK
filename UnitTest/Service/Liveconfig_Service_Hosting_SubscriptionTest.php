<?php

/**
 * Created by PhpStorm.
 * User: Steinweber
 * Date: 04.09.2015
 * Time: 11:14
 */
class Liveconfig_Service_Hosting_SubscriptionTest extends PHPUnit_Framework_TestCase
{
    protected $cid = '12345678';
    protected $subscription = 'web45';

    public function testHostingSubscriptionAdd()
    {
        $client = new Liveconfig_Client();

        $customer_service = $client->getService('customer');
        $params = array('cid'=> $this->cid);
        $customer = $customer_service->customer->get($params);

        $service = $client->getService('hosting');

        var_dump($customer->customer[0]);
        $params = array(
            'subscriptionname'  => $this->subscription, #required
            'plan'              => 'HostingPlan_47568',
            'customerid'        => $customer->customer[0]->id,
            'webserver'         => 'localhost',
            'mailserver'        => 'localhost',
            'dbserver'          => 'localhost'
        );

        $result = $service->subscription->add($params);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_SubscriptionAddResponse',$result);
    }

    public function testHostingSubscriptionGet(){
        $client = new Liveconfig_Client();
        $service = $client->getService('hosting');

        $params = array(
            'subscriptionname' => $this->subscription
        );

        $result = $service->subscription->get($params);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_SubscriptionGetResponse',$result);
    }

    public function testHostingSubscriptionEdit(){
        $client = new Liveconfig_Client();
        $service = $client->getService('hosting');

        $params = array(
            'subscriptionname' => $this->subscription
        );

        $subscription = $service->subscription->get($params);
        unset(
            $subscription->databaseList,
            $subscription->domains,
            $subscription->hostname,
            $subscription->customerid
        );
        $subscription = json_decode(json_encode($subscription),true);
        $subscription['subscriptionname'] = $this->subscription;

        $result = $service->subscription->edit($subscription);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_SubscriptionEditResponse',$result);
    }

    public function ftestHostingSubscriptionDelete(){
        $client = new Liveconfig_Client();
        $service = $client->getService('hosting');

        $params = array(
            'subscriptionname' => $this->subscription
        );

        $result = $service->subscription->delete($params);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_SubscriptionDeleteResponse',$result);
    }
}
