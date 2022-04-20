<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class QueryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \Illuminate\Database\Events\QueryExecuted $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
        if ($event->sql) {
            DB::listen(function ($query) {
                $sql = str_replace("?", "'%s'", $query->sql);
                $log = "[{$query->time}ms] " .vsprintf($sql, $query->bindings);
                Log::channel('daily_sql')->info($log);
            });
        }
    }
}
