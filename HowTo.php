<?php
//load System
require_once('system/system.php');
$system = new System;

##### CONFIG ####
//get config
$config = $system->registry->get('config');
//load other config file
$config->load('example');
//set config value
$config->set('soap_user','demo');
//small code
$system->registry->get('config')->set('soap_url','www.example.com');

#### REQUEST ####
$system->api->request('FunctionName','Parameter','Auth');

#### EXAMPLE #### 
//TestSayHello
$params = array(
    'firstname' => 'John',
    'lastname'  => 'Doe'
);
$result = $system->api->request('TestSayHello',$params);
echo $result['response']->version;

//Change the server between requests
//You do not need to load new config or overwrite the values ​​in the config 
//Server 1
$auth_server_1 = array(
    'soap_user' => 'admin1',
    'soap_pass' => 'Demo',
    'soap_url'  => 'https://example.com:8443/liveconfig/soap'
);

$auth_server_2 = array(
    'soap_user' => 'admin2',
    'soap_pass' => 'Demo',
    'soap_url'  => 'https://example2.com:8443/liveconfig/soap'
);

$params = array(
    'firstname' => 'John',
    'lastname'  => 'Doe'
);

//Request server 1
$system->api->request('TestSayHello',$params,$auth_server_1);

//Requst server 2
$system->api->request('TestSayHello',$params,$auth_server_2);

#### RESPONSE ####
$result = $system->api->request('TestSayHello',$params);
//!isset($result['status']) => You found a bug
//!$result['status'] => Error or Exeption
//If the status is true, it only means that the request has been executed successfully.
//Nevertheless you need to check the return of the server for serverside errors (missing parameter).
if(!isset($result['status']) OR !$result['status'])
{
    echo 'ERROR';
}
else
{
    $api_response = $result['response'];
}