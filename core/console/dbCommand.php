<?php

namespace core\console;

use components\Db;

class dbCommand
{
    /**
     * @param array $arguments
     */
    public function init($arguments = [])
    {
        echo "Start importing database...";

        if(file_exists(ROOT . 'framework.sql')){
            $pdo = Db::getConnection();

            $templine = '';
            $lines = file(ROOT . 'framework.sql');

            foreach ($lines as $line)
            {
                if (substr($line, 0, 2) == '--' || $line == '')
                    continue;

                $templine .= $line;

                if (substr(trim($line), -1, 1) == ';')
                {
                    $pdo->query($templine);
                    $templine = '';
                }
            }
            echo "\nTables imported successfully!\n";
        } else {
            echo "\nFile with database does not exists!\n";
        }
        return;
    }
}