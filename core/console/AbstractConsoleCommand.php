<?php

namespace core\console;

abstract class AbstractConsoleCommand implements ConsoleInterface
{
    /**
     * Describe class methods
     *
     * @return array
     */
    public function describe()
    {
        return get_class_methods($this);
    }
}