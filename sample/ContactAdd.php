<?php
error_reporting(E_ALL);
require_once('system/system.php');
$system = new System;

$params = array(
    'type'       => 0,
    'salutation' => 0,
    'title' => null,
    'firstname'  => 'Max',
    'lastname'   => 'Mustermann',
    'company'    => null,
    'address1'   => 'Beispielstraße 13',
    'address2'   => null,
    'zipcode'    => '60630',
    'city'       => 'Musterhausen',
    'country'    => 'FK',
    'phone'      => '+49 8035 506070',
    'fax'        => null,
    'mobile'     => null,
    'email'      => 'demo@example.com',
    'website'    => 'www.example.com' 
);

$request = $system->api->request('ContactAdd',$params);
if(!$request['status'])
{
    echo "Error<br />\n".$request['response'];
}
else
{
    echo $request['response']->id;
}
