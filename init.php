<?php
Route::set('cli', 'cli(/<action>)',
    array(
        'action'    => '(index|help)',
    ))->defaults(array(
        'controller'=> 'cli',
        'action'    => 'index',
    ));
