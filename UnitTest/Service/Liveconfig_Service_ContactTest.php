<?php

class Liveconfig_Service_ContactTest extends \PHPUnit_Framework_TestCase
{
    public function testContactAdd()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('contact');

        $params = array(
            'type'          => '1', #required
            'salutation'    => '0', #required
            'title'         => 'none',
            'firstname'     => 'Max '.rand(0,9999), #required
            'lastname'      => 'Mustermann', #required
            'company'       => 'Musterfirma',
            'address1'      => 'Musterstr. 35a',
            'address2'      => 'Zusatz 3',
            'zipcode'       => '01020',
            'city'          => 'Musterstadt',
            'country'       => 'DE', #required
            'phone'         => '+49 8586 98 87 76',
            'fax'           => '0049 8586 98 87 75',
            'mobile'        => '0100 234 567 89',
            'email'         => 'demo@example.com',
            'website'       => 'http://www.example.com'
        );

        $result = $service->contact->add($params);
        $this->assertInstanceOf('Liveconfig_Service_Contact_AddResponse',$result);
    }

    public function testContactGet()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('contact');

        $params = array(
            'id'          => 'cFNsgU1GkpW7', #required
        );

        $result = $service->contact->get($params);
        $this->assertInstanceOf('Liveconfig_Service_Contact_GetResponse',$result);
    }

    public function testContactEdit()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('contact');

        $params = array(
            'id'          => 'cFNsgU1GkpW7', #required
        );

        $result = $service->contact->get($params);
        $this->assertInstanceOf('Liveconfig_Service_Contact_GetResponse',$result);

        $params = array_merge($params,get_object_vars($result));
        $params['firstname'] = 'John';

        $result = $service->contact->edit($params);
        $this->assertInstanceOf('Liveconfig_Service_Contact_EditResponse',$result);
        $this->assertEquals('ok',$result->status);
    }
}
