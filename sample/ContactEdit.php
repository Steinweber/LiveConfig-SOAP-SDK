<?php
error_reporting(E_ALL);
require_once('system/system.php');
$system = new System;

$params = array(
    'id'         => 'cB5D4Fy2w5tk',
    'type'       => 0,
    'salutation' => 0,
    'title' => null,
    'firstname'  => 'Demo',
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
    'website'    => 'www.google.com' 
);

$request = $system->api->request('ContactEdit',$params);
if(!$request['status'])
{
    echo "Error<br />\n".$request['response'];
}
else
{
    echo $request['response']->status;
}
