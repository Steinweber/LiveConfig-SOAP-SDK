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

/**
 * Psr logging class based on the PSR-3 standard.
 *
 * This logger will delegate all logging to a PSR-3 compatible logger specified
 * with the `Google_Logger_Psr::setLogger()` method.
 */
class Liveconfig_Logger_Psr extends Liveconfig_Logger_Abstract
{

  private $logger;

  public function __construct(Liveconfig_Client $client, /*Psr\Log\LoggerInterface*/ $logger = null)
  {
    parent::__construct($client);

    if ($logger) {
      $this->setLogger($logger);
    }
  }

  public function setLogger(/*Psr\Log\LoggerInterface*/ $logger)
  {
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public function shouldHandle($level)
  {
    return isset($this->logger) && parent::shouldHandle($level);
  }

  /**
   * {@inheritdoc}
   */
  public function log($level, $message, array $context = array())
  {
    if (!$this->shouldHandle($level)) {
      return false;
    }

    if ($context) {
      $this->reverseJsonInContext($context);
    }

    $levelName = is_int($level) ? array_search($level, self::$levels) : $level;
    $this->logger->log($levelName, $message, $context);
  }

  /**
   * {@inheritdoc}
   */
  protected function write($message, array $context = array())
  {
  }
}
