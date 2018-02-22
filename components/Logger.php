<?php

namespace components;


class Logger
{
    private static $logFile = 'logs/log.txt';

    /**
     * @param bool|string $msg
     */
    public static function log($msg = false)
    {
        $file = file_exists(self::$logFile) ? fopen(self::$logFile, 'w') : false;

        $msg = '[ ' . date('Y-m-d h:i:s') . ' ] ' . $msg . "\n";

        if($file) {
            fwrite($file, $msg);
            fclose($file);
        }
    }
}