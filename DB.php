<?php

namespace Modulus\System;

use Modulus\System\Config;
use Modulus\Hibernate\Capsule;

class DB
{
  /**
   * Start Database
   *
   * @return bool
   */
  public static function start() : bool
  {
    $capsule = new Capsule();

    $capsule->addConnection(Config::$database);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    if ($capsule->connection()->getDatabaseName()) {
      return true;
    }

    return false;
  }
}
