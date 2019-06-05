<?php

namespace Modulus\System;

use Carbon\Carbon;
use GO\Scheduler as Schedule;
use Modulus\Support\Filesystem;
use Modulus\Utility\Scheduler as Runner;
use Modulus\Hibernate\Schedule as Hibernate;

class Scheduler extends Runner
{
  /**
   * Run application scheduler
   *
   * @param Schedule $scheduler
   * @return void
   */
  protected function schedule(Schedule $scheduler)
  {
    $this->removeLogs($scheduler);
    Hibernate::schedule($scheduler);
  }

  /**
   * Remove application logs
   *
   * @param Schedule $scheduler
   * @return void
   */
  private function removeLogs(Schedule $scheduler)
  {
    $scheduler->call(function () {
      $searchDir = Config::$root . 'storage' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR;

      $prefix = config('app.logger.name');
      $logs = glob($searchDir . $prefix . '-*-*-*.log');

      if (count($logs) < 1) return;

      foreach($logs as $log) {
        $date = str_replace($prefix . '-', '', Filesystem::name($log));
        $end = new Carbon($date);
        $now = Carbon::now();

        if ($now->diffInDays($end) > config('app.logger.keep')) {
          try {
            Filesystem::delete($log);
          } catch (\Exception $e) {
            // do nothing...
          }
        }
      }
    })->daily();
  }
}
