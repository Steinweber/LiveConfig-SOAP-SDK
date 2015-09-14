<?php

abstract class Liveconfig_IO_Abstract
{
    protected $client;

    public function __construct(Liveconfig_Client $client)
    {
        $this->client = $client;
        $timeout = $client->getClassConfig('Liveconfig_IO_Abstract', 'request_timeout_seconds');
        if ($timeout > 0) {
            $this->setTimeout($timeout);
        }
        $config = $this->client->getClassConfig(get_called_class());

        if($config){
            foreach($config as $k => $v){
                $this->$k = $v;
            }
        }
    }

    abstract public function setTimeout($timeout);

    abstract public function setOptions($options);

    abstract public function executeRequest(Liveconfig_Http_Request $request);


    public function setCachedRequest(Liveconfig_Http_Request $request)
    {
        // Determine if the request is cacheable.
        if (Liveconfig_Http_CacheParser::isResponseCacheable($request)) {
            $this->client->getCache()->set($request->getCacheKey(), $request);
            return true;
        }
        return false;
    }

    public function makeRequest(Liveconfig_Http_Request $request)
    {
        // First, check to see if we have a valid cached version.
        $cached = $this->getCachedRequest($request);
        if ($cached !== false && $cached instanceof Liveconfig_Http_Request) {
            if (!$this->checkMustRevalidateCachedRequest($cached, $request)) {
                return $cached;
            }
        }

        list($responseData, $responseHeaders, $respHttpCode) = $this->executeRequest($request);
        if ($respHttpCode == 304 && $cached) {
            return $cached;
        }
        if (!isset($responseHeaders['Date']) && !isset($responseHeaders['date'])) {
            $responseHeaders['date'] = date("r");
        }
        $request->setResponseHttpCode($respHttpCode);
        $request->setResponseHeaders($responseHeaders);
        $request->setResponseBody($responseData);
        $this->setCachedRequest($request);

        if(($class = $request->getExpectedClass())){
            return new $class ($request->getResponseBody());
        }
        return $request;
    }

    public function getCachedRequest(Liveconfig_Http_Request $request)
    {
        if (false === Liveconfig_Http_CacheParser::isRequestCacheable($request)) {
            return false;
        }
        return $this->client->getCache()->get($request->getCacheKey());
    }

    protected function checkMustRevalidateCachedRequest($cached, $request)
    {
        if (Liveconfig_Http_CacheParser::mustRevalidate($cached)) {
            $addHeaders = array();
            if ($cached->getResponseHeader('etag')) {
                // [13.3.4] If an entity tag has been provided by the origin server,
                // we must use that entity tag in any cache-conditional request.
                $addHeaders['If-None-Match'] = $cached->getResponseHeader('etag');
            } elseif ($cached->getResponseHeader('date')) {
                $addHeaders['If-Modified-Since'] = $cached->getResponseHeader('date');
            }
            $request->setRequestHeaders($addHeaders);
            return true;
        } else {
            return false;
        }
    }

    public function getHttpResponseHeaders($rawHeaders)
    {
        $headers = array();
        $responseHeaderLines = explode("\r\n", $rawHeaders);
        foreach ($responseHeaderLines as $headerLine) {
            if ($headerLine && strpos($headerLine, ':') !== false) {
                list($header, $value) = explode(': ', $headerLine, 2);
                $header = strtolower($header);
                if (isset($headers[$header])) {
                    $headers[$header] .= "\n" . $value;
                } else {
                    $headers[$header] = $value;
                }
            }else{
                if(preg_match( "#HTTP/[0-9\.]+\s+([0-9]+)#",$headerLine, $out )){
                    $headers['reponse_code'] = intval($out[1]);
                }
            }
        }
        return $headers;
    }
}