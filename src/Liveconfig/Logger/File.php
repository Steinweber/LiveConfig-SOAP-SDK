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


class Liveconfig_Logger_File extends Liveconfig_Logger_Abstract
{
  private $file;
  private $mode = 0640;
  private $lock = false;
  private $trappedErrorNumber;
  private $trappedErrorString;

  public function __construct(Liveconfig_Client $client)
  {
    parent::__construct($client);

    $file = $client->getClassConfig('Google_Logger_File', 'file');
    if (!is_string($file) && !is_resource($file)) {
      throw new Liveconfig_Logger_Exception(
          'File logger requires a filename or a valid file pointer'
      );
    }

    $mode = $client->getClassConfig('Google_Logger_File', 'mode');
    if (!$mode) {
      $this->mode = $mode;
    }

    $this->lock = (bool) $client->getClassConfig('Google_Logger_File', 'lock');
    $this->file = $file;
  }

  protected function write($message)
  {
    if (is_string($this->file)) {
      $this->open();
    } elseif (!is_resource($this->file)) {
      throw new Liveconfig_Logger_Exception('File pointer is no longer available');
    }

    if ($this->lock) {
      flock($this->file, LOCK_EX);
    }

    fwrite($this->file, (string) $message);

    if ($this->lock) {
      flock($this->file, LOCK_UN);
    }
  }

  private function open()
  {
    // Used for trapping `fopen()` errors.
    $this->trappedErrorNumber = null;
    $this->trappedErrorString = null;

    set_error_handler(array($this, 'trapError'));

    $needsChmod = !file_exists($this->file);
    $fh = fopen($this->file, 'a');

    restore_error_handler();

    // Handles trapped `fopen()` errors.
    if ($this->trappedErrorNumber) {
      throw new Liveconfig_Exception(
          sprintf(
              "Logger Error: '%s'",
              $this->trappedErrorString
          ),
          $this->trappedErrorNumber
      );
    }

    if ($needsChmod) {
      @chmod($this->file, $this->mode & ~umask());
    }

    return $this->file = $fh;
  }

  private function close()
  {
    if (is_resource($this->file)) {
      fclose($this->file);
    }
  }

  private function trapError($errno, $errstr)
  {
    $this->trappedErrorNumber = $errno;
    $this->trappedErrorString = $errstr;
  }

  public function __destruct()
  {
    $this->close();
  }
}
