<?php
error_reporting(E_ALL);
require_once('system/system.php');
$system = new System;

$params = array(
    'cid'       => '1',
    'owner_c'   => 'cB5D4Fy2w5tk',
    'admin_c'   => 'cB5D4Fy2w5tk',
    'billing_c' => 'cB5D4Fy2w5tk',
    'locked'    => 0
);

$request = $system->api->request('CustomerAdd',$params);
if(!$request['status'])
{
    echo "Error<br />\n".$request['response'];
}
else
{
    echo $request['response']->id;
}
