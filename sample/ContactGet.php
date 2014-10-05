<?php
error_reporting(E_ALL);
require_once('system/system.php');
$system = new System;

$params = array(
    'id'         => 'cB5D4Fy2w5tk'
);

$request = $system->api->request('ContactGet',$params);
if(!$request['status'])
{
    echo "Error<br />\n".$request['response'];
}
else
{
    foreach($request['response'] as $key => $value)
    {
        echo $key." : ".$value."<br />\n";
    }
}
