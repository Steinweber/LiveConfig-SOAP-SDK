<?php

class Liveconfig_Service_CustomerTest extends \PHPUnit_Framework_TestCase
{
    public function testCustomerAdd()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('customer');

        /*
         * Die gleiche Kundennummer kann mehrmals vergeben.
         * Ist ein Kunde mit genau den gleichen Details schon vorhanden, wird die ID zurück gegeben.
         * Der Kunde wird aber nicht 2 mal angelegt.
         */

        $params = array(
            'cid'           => '123456782',
            'owner_c'       => 'cFNsgU1GkpW7', #required
            'admin_c'       => 'cB5D4Fy2w5tk', #required
            'billing_c'     => 'cB5D4Fy2w5tk', #required
            'locked'        => '0', #required
        );

        $result = $service->customer->add($params);
        $this->assertInstanceOf('Liveconfig_Service_Customer_AddResponse',$result);
    }

    public function testCustomerGet()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('customer');

        $params = array(
            //'cid'          => '123456782'
        );

        $result = $service->customer->get($params);
        $this->assertInstanceOf('Liveconfig_Service_Customer_GetResponse',$result);
    }

    public function testCustomerEdit()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('customer');

        $params = array(
            'cid'          => '12345678', #required
        );

        $result = $service->customer->get($params);
        $this->assertInstanceOf('Liveconfig_Service_Customer_GetResponse',$result);

        //convert to array
        $customer = json_decode(json_encode($result->customer[0]),1);

        $params = array_merge($params,$customer);
        unset($params['id'],$params['subscription']);
        $params['owner_c'] = 'cB5D4Fy2w5tk';

        $result = $service->customer->edit($params);
        $this->assertInstanceOf('Liveconfig_Service_Customer_EditResponse',$result);
        $this->assertEquals('ok',$result->status);
    }
}
