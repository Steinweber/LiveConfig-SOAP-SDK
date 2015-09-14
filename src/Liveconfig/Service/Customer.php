<?php

class Liveconfig_Service_Customer extends Liveconfig_Service
{
    public $customer;

    public function __construct(Liveconfig_Client $client)
    {
        parent::__construct($client);
        $this->customer = new Liveconfig_Service_Customer_Resource(
            $this,
            'customer',
            array(
                'methods' => array(
                    'CustomerAdd' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'cid' => array(
                                'location' => 'body',
                                'type' => 'long',
                                'required' => false,
                            ),
                            'owner_c' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => true,
                            ),
                            'admin_c' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'billing_c' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'locked' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => true,
                            ),
                        ),
                    ),
                    'CustomerGet' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'cid' => array(
                                'location' => 'body',
                                'type' => 'long',
                                'required' => false,
                            ),
                        ),
                    ),
                    'CustomerEdit' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'cid' => array(
                                'location' => 'body',
                                'type' => 'long',
                                'required' => false,
                            ),
                            'owner_c' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => true,
                            ),
                            'admin_c' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'billing_c' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'locked' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => true,
                            ),
                        ),
                    ),
                )
            )
        );
    }
}

class Liveconfig_Service_Customer_Resource extends Liveconfig_Service_Resource
{

    public function add($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('CustomerAdd', array($params),'Liveconfig_Service_Customer_AddResponse');
    }

    public function get($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('CustomerGet', array($params),'Liveconfig_Service_Customer_GetResponse');
    }

    public function edit($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('CustomerEdit', array($params),'Liveconfig_Service_Customer_EditResponse');
    }


}

#CustomerAdd
class Liveconfig_Service_Customer_AddResponse extends Liveconfig_Collector
{
    public $id;
}

#CustomerGet
class Liveconfig_Service_Customer_GetResponse extends Liveconfig_Collector
{
    protected $automap = false;
    public $customer = array();

    protected function constructor(){
        if(
            isset($this->collectorData['customers']) &&
            isset($this->collectorData['customers']['CustomerDetails']) &&
            count($this->collectorData['customers']['CustomerDetails'])
        ){
            if(!isset($this->collectorData['customers']['CustomerDetails'][0])){
                //Single result
                $this->customer[] = new Liveconfig_Service_Customer_CustomerDetails($this->collectorData['customers']['CustomerDetails']);
            }else{
                //Multiple results
                foreach($this->collectorData['customers']['CustomerDetails'] as $customer){
                    $this->customer[] = new Liveconfig_Service_Customer_CustomerDetails($customer);
                }
            }
            unset($this->collectorData['customers']);
        }
    }
}

class Liveconfig_Service_Customer_CustomerDetails extends Liveconfig_Collector{
    public $id;
    public $cid;
    public $owner_c;
    public $admin_c;
    public $billing_c;
    public $locked;
    public $subscription=array();
}

#CustomerEdit
class Liveconfig_Service_Customer_EditResponse extends Liveconfig_Collector
{
    public $status;
}