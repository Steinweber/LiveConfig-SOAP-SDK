<?php
error_reporting(E_ALL);
require_once('system/system.php');
$system = new System;

$params = array(
    'firstname' => 'Max',
    'lastname'  => 'Mustermann'
);

$request = $system->api->request('TestSayHello',$params);
if(!$request['status'])
{
    echo "Error<br />\n".$request['response'];
}
else
{
    echo $request['response']->greeting;
}
