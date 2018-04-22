<?php

namespace core\console;

use components\Db;

class dbCommand
{
    public function init()
    {
        echo "Start importing database...\n";

        if(file_exists(ROOT . 'framework.sql')){
            $pdo = Db::getConnection();

            $templine = '';
            $lines = file(ROOT . 'framework.sql');

            foreach ($lines as $line)
            {
                // Skip it if it's a comment
                if (substr($line, 0, 2) == '--' || $line == '')
                    continue;

                // Add this line to the current segment
                $templine .= $line;

                // If it has a semicolon at the end, it's the end of the query
                if (substr(trim($line), -1, 1) == ';')
                {
                    // Perform the query
                    $pdo->query($templine);
                    // Reset temp variable to empty
                    $templine = '';
                }
            }
            echo "\nTables imported successfully!";
        } else {
            echo "\nFile with database does not exists!";
        }
        return;
    }
}