<?php

namespace core\console;


class Console
{

    private $argv;
    private $argc;

    private $command;

    /**
     * Console constructor.
     * @param $argv
     * @param $argc
     */
    public function __construct($argv, $argc)
    {
        $this->argv = $argv;
        $this->argc = $argc;
        $this->command = 'undefined';
        $this->prepare();
    }

    /**
     * @param string $class
     * @param string $method
     * @param array $arguments
     */
    private function execute($class, $method, $arguments = [])
    {
        if (class_exists($class)) {
            $class = new $class;

            if (!method_exists($class, $method)) {
                die("\nMethod '$method' for command '{$this->argv[1]}' not found\n");
            }

            $class->$method($arguments);
        } else {
            die("\nCommand '{$this->argv[1]}' not found\n");
        }
    }

    /**
     * Prepare class name, method name and arguments and call execute method
     */
    private function prepare()
    {
        $ex = explode(':', $this->argv[1]);

        if ($ex[0] == 'list') {
            $this->showList();
            exit();
        }

        $class = 'core\\console\\commands\\' . $ex[0] . 'Command';
        $method = $ex[1];
        $arguments = [];

        for ($i = 2; $i < $this->argc; $i++) {
            $arguments[] = $this->argv[$i];
        }

        $this->execute($class, $method, $arguments);
    }

    /**
     * Call describe method and build all available commands view
     */
    private function showList()
    {
        $files = scandir(ROOT . '/core/console/commands/');

        echo "\nList of available commands:";

        foreach ($files as $file){
            if (strpos($file, '.')) {

                $class = explode('.php', $file)[0];

                echo "\n==========================\n\t$class\n==========================\n";

                $className = 'core\\console\\commands\\' . $class;
                $classObj = new $className;

                foreach ($classObj->describe() as $method) {
                    if ($method != 'describe') {
                        echo explode('Command', $class)[0] . ":{$method}\n";
                    }
                }
            }
        }

        echo "\n";
    }
}