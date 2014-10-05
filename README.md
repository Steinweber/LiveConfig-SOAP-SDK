LiveConfig-SOAP-SDK
===================

Dieses Script soll den Einstieg und den Umgang mit der SOAP-API von LiveConfig erleichtern.

## Umfang
* Vordefinierte Config-Dateien
* Einfaches Ändern der Config
* Gleichzeitige Verbindung zu mehreren Servern
* Einfache Erweiterung durch eigenen Code
* Log für Fehler
* Einfache Integration von Validierungen
* Bis ins kleinste Detail flexibel und konfigurierbar
* Zahlreiche Beispiele für Funktionen
 

#Einstieg

##Systemaufruf
Es wird nur die Datei system/system.php geladen. Darin werden alle weiteren Klassen geladen, die benötigt werden.
```php
require_once('system/system.php');
$system = new System;
```

##Registry
Über die Registry kann man auf alle Klassen zugreifen.
```php
require_once('system/system.php');
$system = new System;

$config = $system->registry->get('config');
$log = $system->registry->get('log');
//...
```
Man kann auch mit weniger Code direkt auf eine Funktion zugreifen
```php
require_once('system/system.php');
$system = new System;

//Config laden
$system->registry->get('config')->load('cfg');
//Einen Eintrag in den Log schreiben
$system->registry->get('log')->write('error');
```

##Config-Dateien
Bei jedem Aufruf der Systemklasse wird die default-config geladen. Diese hat den Namen cfg.php und muss den Wert `log_status` haben. Ist der Wert true, muss auch `log_file` gesetzt werden.
```php
$_['log_file'] = 'log.txt';
$_['log_status'] = true;
```
Zudem kann die cfg.php eine SOAP-Verbindung beinhalten.
```php
$_['soap_user'] = 'admin';
$_['soap_pass'] = 'admin';
$_['soap_url'] = 'https://example.com:8443/liveconfig/soap';
```
Möchte man weitere Verbindungen speichern, kann man dazu zusätzliche Config-Dateien anlegen. Diese müssen keinen Log-Wert enthalten, da diese schon in der default-config enthalten sind. Möchte man für jeden Server einen eigenen Log, kann man in jede Config-Datei einen eigenen Lognamen eintragen.
```php
$_['log_file'] = 'server_host_1.txt';
```

###Config-Werte direkt setzen und prüfen
Die Funktion get gibt entweder den Wert oder null zurück. Zum Prüfen, ob ein Wert vorhanden ist, sollte die Funktion has verwendet werden. Set erwartet Key und Value.
```php
require_once('system/system.php');
$system = new System;

$config = $system->registry->get('config');

$is_user = $config->has('soap_user');
$user = $config->get('soap_user');
$config->set('soap_user','admin');
//to complete the config-functions - load a config-file
$config->load('filename'); //without .php
```

## Aufruf und Rückgaben
Jeder Aufruf liefert ein Array als Rückgabe. Das Array hat zwei Einträge. status und response. Der Wert status steht nur dafür, ob das System den Request erfolgreich durchführen konnte. Das bedeutet nicht, dass der Funktionsaufruf auf dem Server keinen Fehler verursacht hat. response beinhaltet die Rückgabe. Wenn der status true ist, ist die Rückgabe vom Server. Bei false, ist die Rückgabe vom System. 

### Aufruf
Ein Request kann aus bis zu drei Parametern bestehen. Der erste Parameter ist die Funktion. Der zweite Parameter sind die Parameter (Daten) für die Funktion und der dritte Parameter kann eine Verbindung enthalten.
```php
require_once('system/system.php');
$system = new System;

$params = array(
    'firstname' => 'John',
    'lastname'  => 'Doe'
);
$result = $system->api->request('TestSayHello',$params);

//check the result
if(!$result['status'])
{
  //output the error-message
    echo $result['response'];
}
else
{
    $api_response = $result['response'];
    echo $result['response']->greeting;
}
```
Das gleiche Beispiel mit Verbindungsdaten
```php
require_once('system/system.php');
$system = new System;

$params = array(
    'firstname' => 'John',
    'lastname'  => 'Doe'
);
$auth = array(
    'soap_user' => 'admin1',
    'soap_pass' => 'Demo',
    'soap_url'  => 'https://example.com:8443/liveconfig/soap/'
);

$result = $system->api->request('TestSayHello',$params,$auth);

//check the result
if(!$result['status'])
{
  //output the error-message
    echo $result['response'];
}
else
{
    $api_response = $result['response'];
    echo $result['response']->greeting;
}
```
### Rückgaben
Sollte einmal kein status im response vorhanden sein, ist es ein Bug im System. Wenn status false ist, ist die Rückgabe immer ein String mit einer Fehlermeldung.
```php
$result = $system->api->request('LiveConfigVersion');

//check the result
if(!$result['status'])
{
  //output the error-message
    echo $result['response'];
}
else
{
    $api_response = $result['response'];
    echo $result['response']->version;
}
```
Viele Beispiele für Funktionen sind unter beispiele abgelegt. WICHTIG!! Diese kann man nicht in dem Ordner aufrufen, da die Pfade nicht stimmen. Zum Testen müssen diese in das Stammverzeichnis des Systems kopiert werden (neben HowTo.php)
