<?php

namespace Modulus\System;

use Modulus\System\Config;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

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