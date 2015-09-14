<?php

class Liveconfig_Service_Contact extends Liveconfig_Service
{
    public $contact;

    public function __construct(Liveconfig_Client $client)
    {
        parent::__construct($client);
        $this->contact = new Liveconfig_Service_Contact_Resource(
            $this,
            'contact',
            array(
                'methods' => array(
                    'ContactAdd' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'type' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'salutation' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => true,
                            ),
                            'title' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'firstname' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'lastname' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'company' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'address1' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'address2' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'zipcode' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'city' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'country' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'phone' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'fax' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'mobile' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'email' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'website' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                        ),
                    ),
                    'ContactGet' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'id' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                        ),
                    ),
                    'ContactEdit' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'id' => array(
                                'location' => 'body',
                                'type'  => 'string',
                                'required' => true
                            ),
                            'type' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'salutation' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => true,
                            ),
                            'title' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'firstname' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'lastname' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'company' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'address1' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'address2' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'zipcode' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'city' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'country' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'phone' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'fax' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'mobile' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'email' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'website' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                        ),
                    ),
                )
            )
        );
    }
}

class Liveconfig_Service_Contact_Resource extends Liveconfig_Service_Resource
{

    public function add($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('ContactAdd', array($params),'Liveconfig_Service_Contact_AddResponse');
    }

    public function get($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('ContactGet', array($params),'Liveconfig_Service_Contact_GetResponse');
    }

    public function edit($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('ContactEdit', array($params),'Liveconfig_Service_Contact_EditResponse');
    }


}

#ContactAdd
class Liveconfig_Service_Contact_AddResponse extends Liveconfig_Collector
{
    public $id;
}

#ContactGet
class Liveconfig_Service_Contact_GetResponse extends Liveconfig_Collector
{
    public $type = 0;
    public $salutation;
    public $title;
    public $firstname;
    public $lastname;
    public $company;
    public $address1;
    public $address2;
    public $zipcode;
    public $city;
    public $country;
    public $phone;
    public $fax;
    public $mobile;
    public $email;
    public $website;
}

#ContactEdit
class Liveconfig_Service_Contact_EditResponse extends Liveconfig_Collector
{
    public $status;
}