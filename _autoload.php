<?php
/*
    Set folder for all includes
*/
define('WSL_ASSETS','/assets/');
/*
    Load config definitions
*/
require_once __DIR__ . WSL_ASSETS . 'config.php';
/*
    Usage example:

        // notation: CamelCase

    Assets folder:

        ./assets
            /php
                ClassName.php
                /NameSpace
                    ClassName.php
                    /NextGroup
                        ClassNext.php

    #        
    # 1 with namespaces

        use NameSpace/ClassName;
            / inside ClassName.php
                namespace NameSpace;

        use NameSpace/NextGroup/ClassNext;
            / inside ClassNext.php
                namespace NameSpace/NextGroup;

    #
    # 2 without

            / just call class

    #
    # then call class

        $class = new ClassName();

            or for class with no __construct

        ClassName::FunctionCall();

*/
spl_autoload_register(function (string $className) {
    $assets = __DIR__ . WSL_ASSETS . 'php/';
    $fileName = [
        // # 1 with namespaces
        $assets . str_replace('\\', '/', $className . '.php'),
        // # 2 without
        $assets . $className . '.php'
    ];
    foreach ($fileName as $file) {
        if (file_exists($file)) {
            require_once $file;
            break;
        }
    }
});

?>