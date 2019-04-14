<?php


 /** Set route as
  'name' => [
           'defaults' => 'NameController/methodAction',
           'path' => ''
           ]

  Route with parameters
  name' => [
           'defaults' => 'NameController/methodAction/$1/$2',
           'path' => 'path/([0-9]+)/([a-zA-Z]+)'
           ]
 */


return [
    'login' => [
        'defaults' => 'Security/login',
        'path' => '/login'
    ],
    'logout' => [
        'defaults' => 'Security/logout',
        'path' => '/logout'
    ],
    'homepage' => [
        'defaults' => 'Default/index',
        'path' => '/'
    ],
];
