<?php
require_once(dirname(__FILE__) . '/../src/Liveconfig/autoload.php');
$client = new Liveconfig_Client();
$service = $client->getService('system');

$params = array(
    'firstname' => 'John',
    'lastname' => 'Doe'
);
try {
    $greetingObj = $service->system->TestSayHello($params);
}catch(Exception $e){
    echo 'LiveconfigClientError:'. $e->getMessage();
    exit;
}

if(!$greetingObj->greeting){
    echo 'Could not connect to Server!';
    exit;
}

try {
    $versionObj = $service->system->LiveConfigVersion(array());
}catch(Exception $e){
    echo 'LiveconfigClientError:'. $e->getMessage();
    exit;
}

echo $greetingObj->greeting . "\n";
echo "Liveconfig version: ".$versionObj->version ."(".$versionObj->revision.")";