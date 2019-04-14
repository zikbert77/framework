<?php

namespace core\console\commands;

use components\Db;
use components\Logger;
use core\console\AbstractConsoleCommand;

class dbCommand extends AbstractConsoleCommand
{
    /**
     * @param array $arguments
     */
    public function init($arguments = [])
    {
        echo "Start importing database...\n";

        if (file_exists(ROOT . 'framework.sql')) {

            try {
                $pdo = Db::getConnection();

                $templine = '';
                $lines = file(ROOT . 'framework.sql');

                foreach ($lines as $line) {

                    if (substr($line, 0, 2) == '--' || $line == '') {
                        continue;
                    }

                    $templine .= $line;

                    if (substr(trim($line), -1, 1) == ';') {
                        $pdo->query($templine);
                        $templine = '';
                    }
                }
                echo "\nTables imported successfully!\n";
            } catch (\PDOException $exception) {
                echo "\n{$exception->getMessage()}\n";
                Logger::log($exception->getMessage());
            }
        } else {
            echo "\nFile with database does not exists!\n";
        }

        return;
    }
}