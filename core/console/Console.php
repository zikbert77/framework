<?php

namespace core\console;


class Console
{

    private $argv;
    private $argc;

    private $command;

    public function __construct($argv, $argc)
    {
        $this->argv = $argv;
        $this->argc = $argc;
        $this->command = 'undefined';
        $this->prepare();
    }

    private function execute($class, $method, $arguments)
    {

        if(class_exists($class)){
            $class = new $class;

            if(!method_exists($class, $method))
                die("\nMethod '$method' for command '{$this->argv[1]}' not found\n");

            $class->$method($arguments);
        } else {
            die("\nCommand '{$this->argv[1]}' not found\n");
        }
    }


    private function prepare()
    {
        $ex = explode(':', $this->argv[1]);


        if($ex[0] == 'list'){
            return $this->showList();
        }

        $class = 'core\\console\\commands\\' . $ex[0] . 'Command';
        $method = $ex[1];
        $arguments = [];

        for($i = 2; $i < $this->argc; $i++){
            $arguments[] = $this->argv[$i];
        }

        $this->execute($class, $method, $arguments);
    }

    private function showList()
    {
        $files = scandir(ROOT . '/core/console/commands/');

        echo "\nList of available commands:";

        foreach ($files as $file){
            if (strpos($file, '.')){

                $class =  explode('.php', $file)[0];

                echo "\n==========================\n\t$class\n==========================\n";

                $className = 'core\\console\\commands\\' . $class;
                $classObj = new $className;

                foreach ($classObj->describe() as $method){
                    if($method != 'describe')
                        echo "* $method\n";
                }
            }
        }

        echo "\n";
    }
}