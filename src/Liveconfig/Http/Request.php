<?php

class Liveconfig_Http_Request
{
    protected $requestHeaders;
    protected $endpoint = null;
    protected $userAgent;
    protected $responseHttpCode;
    protected $responseHeaders;
    protected $responseBody;
    protected $method;
    protected $body;
    protected $expectedClass;

    public function setEndpoint($endpoint){
        $this->endpoint = $endpoint;
    }

    public function getEndpoint(){
        return $this->endpoint;
    }

    public function setMethod($method){
        $this->method = $method;
    }

    public function getMethod(){
        return $this->method;
    }

    public function setBody($body){
        if(!is_array($body)){
            return;
        }
        if(is_array($body)){
            foreach($body as $key => $params){
                if($params['location'] == 'body'){
                    $this->body[$key] = $params['value'];
                }
            }
        }
    }

    public function getBody(){
        return $this->body;
    }

    public function getResponseHttpCode()
    {
        return (int) $this->responseHttpCode;
    }

    public function setResponseHttpCode($responseHttpCode)
    {
        $this->responseHttpCode = $responseHttpCode;
    }

    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    public function getResponseBody()
    {
        return $this->responseBody;
    }

    public function setExpectedClass($class)
    {
        $this->expectedClass = $class;
    }

    public function getExpectedClass()
    {
        return $this->expectedClass;
    }

    public function setResponseHeaders($headers)
    {
        $headers = Liveconfig_Utils::normalize($headers);
        if ($this->responseHeaders) {
            $headers = array_merge($this->responseHeaders, $headers);
        }
        $this->responseHeaders = $headers;
    }

    public function getResponseHeader($key)
    {
        return isset($this->responseHeaders[$key])
            ? $this->responseHeaders[$key]
            : false;
    }

    public function setResponseBody($responseBody)
    {
        $this->responseBody = $responseBody;
    }

    public function getRequestHeader($key)
    {
        return isset($this->requestHeaders[$key])
            ? $this->requestHeaders[$key]
            : false;
    }

    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    public function getUserAgent()
    {
        return $this->userAgent;
    }

    public function getCacheKey()
    {
        $key = $this->endpoint;
        if (isset($this->accessKey)) {
            $key .= $this->accessKey;
        }
        if (isset($this->requestHeaders['authorization'])) {
            $key .= $this->requestHeaders['authorization'];
        }
        return md5($key);
    }
    public function getParsedCacheControl()
    {
        $parsed = array();
        $rawCacheControl = $this->getResponseHeader('cache-control');
        if ($rawCacheControl) {
            $rawCacheControl = str_replace(', ', '&', $rawCacheControl);
            parse_str($rawCacheControl, $parsed);
        }
        return $parsed;
    }

    public function createRequestUri($endpoint,$pathParams, &$params)
    {
        $requestUrl = $endpoint . $pathParams;
        $uriTemplateVars = array();
        $queryVars = array();
        foreach ($params as $paramName => $paramSpec) {
            if ($paramSpec['type'] == 'boolean') {
                $paramSpec['value'] = ($paramSpec['value']) ? 'true' : 'false';
            }
            if ($paramSpec['location'] == 'path') {
                $uriTemplateVars[$paramName] = $paramSpec['value'];
                unset($params[$paramName]);
            } else if ($paramSpec['location'] == 'query') {
                if (isset($paramSpec['repeated']) && is_array($paramSpec['value'])) {
                    foreach ($paramSpec['value'] as $value) {
                        $queryVars[] = $paramName . '=' . rawurlencode(rawurldecode($value));
                    }
                } else {
                    $queryVars[] = $paramName . '=' . rawurlencode(rawurldecode($paramSpec['value']));
                }
                unset($params[$paramName]);
            }
        }
        if (count($uriTemplateVars)) {
            $uriTemplateParser = new Liveconfig_Utils_URITemplate();
            $requestUrl = $uriTemplateParser->parse($requestUrl, $uriTemplateVars);
        }
        if (count($queryVars)) {
            $requestUrl .= '?' . implode($queryVars, '&');
        }
        return $requestUrl;
    }
}