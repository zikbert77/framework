<?php

/**
 * Set route as 'path' => 'NameController/methodAction'
 *
 * Route with parameters 'path/([0-9]+)/([a-zA-Z]+)' => 'NameController/methodAction/$1/$2'
*/

return [
    'path/([0-9]+)/([a-zA-Z]+)' => 'Default/method/$1/$2',
    '' => 'Default/index',
];
