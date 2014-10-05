<?php
error_reporting(E_ALL);
require_once('system/system.php');
$system = new System;

$request = $system->api->request('LiveConfigVersion');
if(!$request['status'])
{
    echo "Error<br />\n".$request['response'];
}
else
{
    echo $request['response']->version;
}
