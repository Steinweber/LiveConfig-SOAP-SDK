<?php

/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


abstract class Liveconfig_Logger_Abstract
{
  const DEFAULT_LOG_FORMAT = "[%datetime%] %level%: %message% %context%\n";
  const DEFAULT_DATE_FORMAT = 'd/M/Y:H:i:s O';
  const EMERGENCY = 'emergency';
  const ALERT = 'alert';
  const CRITICAL = 'critical';
  const ERROR = 'error';
  const WARNING = 'warning';
  const NOTICE = 'notice';
  const INFO = 'info';
  const DEBUG = 'debug';

  protected static $levels = array(
      self::EMERGENCY  => 600,
      self::ALERT => 550,
      self::CRITICAL => 500,
      self::ERROR => 400,
      self::WARNING => 300,
      self::NOTICE => 250,
      self::INFO => 200,
      self::DEBUG => 100,
  );
  protected $level = self::DEBUG;
  protected $logFormat = self::DEFAULT_LOG_FORMAT;
  protected $dateFormat = self::DEFAULT_DATE_FORMAT;
  protected $allowNewLines = false;

  public function __construct(Liveconfig_Client $client)
  {
    $this->setLevel(
        $client->getClassConfig('Liveconfig_Logger_Abstract', 'level')
    );

    $format = $client->getClassConfig('Liveconfig_Logger_Abstract', 'log_format');
    $this->logFormat = $format ? $format : self::DEFAULT_LOG_FORMAT;

    $format = $client->getClassConfig('Liveconfig_Logger_Abstract', 'date_format');
    $this->dateFormat = $format ? $format : self::DEFAULT_DATE_FORMAT;

    $this->allowNewLines = (bool) $client->getClassConfig(
        'Liveconfig_Logger_Abstract',
        'allow_newlines'
    );
  }

  public function setLevel($level)
  {
    $this->level = $this->normalizeLevel($level);
  }

  public function shouldHandle($level)
  {
    return $this->normalizeLevel($level) >= $this->level;
  }

  public function emergency($message, array $context = array())
  {
    $this->log(self::EMERGENCY, $message, $context);
  }

  public function alert($message, array $context = array())
  {
    $this->log(self::ALERT, $message, $context);
  }

  public function critical($message, array $context = array())
  {
    $this->log(self::CRITICAL, $message, $context);
  }

  public function error($message, array $context = array())
  {
    $this->log(self::ERROR, $message, $context);
  }

  public function warning($message, array $context = array())
  {
    $this->log(self::WARNING, $message, $context);
  }

  public function notice($message, array $context = array())
  {
    $this->log(self::NOTICE, $message, $context);
  }

  public function info($message, array $context = array())
  {
    $this->log(self::INFO, $message, $context);
  }

  public function debug($message, array $context = array())
  {
    $this->log(self::DEBUG, $message, $context);
  }

  public function log($level, $message, array $context = array())
  {
    if (!$this->shouldHandle($level)) {
      return false;
    }

    $levelName = is_int($level) ? array_search($level, self::$levels) : $level;
    $message = $this->interpolate(
        array(
            'message' => $message,
            'context' => $context,
            'level' => strtoupper($levelName),
            'datetime' => new DateTime(),
        )
    );

    $this->write($message);
  }

  protected function interpolate(array $variables = array())
  {
    $template = $this->logFormat;

    if (!$variables['context']) {
      $template = str_replace('%context%', '', $template);
      unset($variables['context']);
    } else {
      $this->reverseJsonInContext($variables['context']);
    }

    foreach ($variables as $key => $value) {
      if (strpos($template, '%'. $key .'%') !== false) {
        $template = str_replace(
            '%' . $key . '%',
            $this->export($value),
            $template
        );
      }
    }

    return $template;
  }

  protected function reverseJsonInContext(array &$context)
  {
    if (!$context) {
      return;
    }

    foreach ($context as $key => $val) {
      if (!$val || !is_string($val) || !($val[0] == '{' || $val[0] == '[')) {
        continue;
      }

      $json = @json_decode($val);
      if (is_object($json) || is_array($json)) {
        $context[$key] = $json;
      }
    }
  }

  protected function export($value)
  {
    if (is_string($value)) {
      if ($this->allowNewLines) {
        return $value;
      }

      return preg_replace('/[\r\n]+/', ' ', $value);
    }

    if (is_resource($value)) {
      return sprintf(
          'resource(%d) of type (%s)',
          $value,
          get_resource_type($value)
      );
    }

    if ($value instanceof DateTime) {
      return $value->format($this->dateFormat);
    }

    if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
      $options = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

      if ($this->allowNewLines) {
        $options |= JSON_PRETTY_PRINT;
      }

      return @json_encode($value, $options);
    }

    return str_replace('\\/', '/', @json_encode($value));
  }

  protected function normalizeLevel($level)
  {
    if (is_int($level) && array_search($level, self::$levels) !== false) {
      return $level;
    }

    if (is_string($level) && isset(self::$levels[$level])) {
      return self::$levels[$level];
    }

    throw new Liveconfig_Logger_Exception(
        sprintf("Unknown LogLevel: '%s'", $level)
    );
  }

  abstract protected function write($message);
}
