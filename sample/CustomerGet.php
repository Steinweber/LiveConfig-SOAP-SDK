<?php
error_reporting(E_ALL);
require_once('system/system.php');
$system = new System;

$params = array(
    'cid'       => '1'
);

$request = $system->api->request('CustomerGet',$params);
if(!$request['status'])
{
    echo "Error<br />\n".$request['response'];
}
else
{
    echo '<pre>';
    var_Dump($request['response']);
    echo '</pre>';
}
