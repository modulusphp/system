<?php

namespace Modulus\System;

use Dotenv\Dotenv;
use Modulus\System\Config;

class Env
{
  /**
   * Start Environment
   *
   * @return void
   */
  public static function start() : void
  {
    $required = Config::$environment;
    $dotenv   = Dotenv::create(Config::$root);

    $dotenv->overload();
    $dotenv->required($required);
  }
}
