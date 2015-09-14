<?php

class Liveconfig_Service_Resource
{
    // Valid query parameters that work, but don't appear in discovery.
    private $stackParameters = array(
        'api_user' => array('type' => 'string', 'location' => 'path'),
        'api_password' => array('type' => 'string', 'location' => 'path'),
        'endpoint' => array('type' => 'string', 'location' => 'path')
    );

    private $endpoint;
    private $client;
    private $resourceName;
    private $methods;

    public function __construct($service, $resourceName, $resource)
    {
        $this->endpoint = $service->endpoint;
        $this->client = $service->getClient();
        $this->resourceName = $resourceName;
        $this->methods = is_array($resource) && isset($resource['methods']) ?
            $resource['methods'] :
            array($resourceName => $resource);
    }

    public function call($name, $arguments, $expected_class = null)
    {
        if (!isset($this->methods[$name])) {
            $this->client->getLogger()->error(
                'Service method unknown',
                array(
                    'resource' => $this->resourceName,
                    'method' => $name
                )
            );
            throw new Liveconfig_Exception(
                "Unknown function: " .
                get_called_class() . "->{$this->resourceName}->{$name}()"
            );
        }
        $method = $this->methods[$name];
        $parameters = $arguments[0];

        if (!isset($method['parameters'])) {
            $method['parameters'] = array();
        }
        $method['parameters'] = array_merge(
            $method['parameters'],
            $this->stackParameters
        );
        foreach ($parameters as $key => $val) {
            if ($key != 'body' && !isset($method['parameters'][$key])) {
                $this->client->getLogger()->error(
                    'Service parameter unknown',
                    array(
                        'resource' => $this->resourceName,
                        'method' => $name,
                        'parameter' => $key
                    )
                );
                throw new Liveconfig_Exception("($name) unknown parameter: '$key'");
            }
        }
        foreach ($method['parameters'] as $paramName => $paramSpec) {
            if (isset($paramSpec['required']) &&
                $paramSpec['required'] &&
                !isset($parameters[$paramName])
            ) {
                $this->client->getLogger()->error(
                    'Service parameter missing',
                    array(
                        'resource' => $this->resourceName,
                        'method' => $name,
                        'parameter' => $paramName
                    )
                );
                throw new Liveconfig_Exception("($name) missing required param: '$paramName'");
            }
            if (isset($parameters[$paramName])) {
                $value = $parameters[$paramName];
                $parameters[$paramName] = $paramSpec;
                $parameters[$paramName]['value'] = $value;
                unset($parameters[$paramName]['required']);
            } else {
                // Ensure we don't pass nulls.
                unset($parameters[$paramName]);
            }
        }
        $this->client->getLogger()->info(
            'Service Call',
            array(
                'resource' => $this->resourceName,
                'method' => $name,
                'arguments' => $parameters,
            )
        );

        $httpRequest = new Liveconfig_Http_Request();
        $httpRequest->setMethod($name);

        //API-Auth
        $auth = $this->client->getAuth();
        if (array_key_exists('api_user', $parameters)) {
            $auth['api_user'] = $parameters['api_user']['value'];
        }
        if (array_key_exists('api_password', $parameters)) {
            $auth['api_password'] = $parameters['api_password']['value'];
        }

        $this->client->getConfig()->setAuth($auth);

        $parameters = array_merge($parameters, array(
            'api_user' => array('location' => 'path', 'type' => 'string', 'value' => $auth['api_user']),
            'api_password' => array('location' => 'path', 'type' => 'string', 'value' => $auth['api_password']),
        ));

        $parameters['auth'] = array(
            'location' => 'body',
            'type' => 'array',
            'value' => $this->client->getAuthToken($name)
        );


        //API endpoint
        if (array_key_exists('api_endpoint', $parameters)) {
            $this->endpoint = $parameters['api_endpoint'];
        } elseif (!$this->endpoint) {
            $this->endpoint = $this->client->getEndpoint();
        }

        //create URI and drop path/query (URI) params
        $url = $httpRequest->createRequestUri(
            $this->endpoint,
            $method['path'],
            $parameters
        );

        $httpRequest->setBody($parameters);
        $httpRequest->setEndpoint($url);
        $httpRequest->setExpectedClass($expected_class);

        return $this->client->execute($httpRequest);
    }

    protected function convertToArrayAndStripNulls($o)
    {
        $o = (array)$o;
        foreach ($o as $k => $v) {
            if ($v === null) {
                unset($o[$k]);
            } elseif (is_object($v) || is_array($v)) {
                $o[$k] = $this->convertToArrayAndStripNulls($o[$k]);
            }
        }
        return $o;
    }
}