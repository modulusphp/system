<?php

namespace Modulus\System;

use Modulus\System\Config;
use Modulus\Hibernate\Capsule;

class DB
{
  /**
   * Start Database
   *
   * @param null|string $connection
   * @return bool
   */
  public static function start(?string $connection = null) : bool
  {
    $capsule = new Capsule(null, $connection == null ? config('database.default') : $connection);

    $capsule->addConnection(Config::$database);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule->connection()->getDatabaseName() ? true : false;
  }
}
