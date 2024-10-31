<?php

spl_autoload_register(function($class) {
    if (strpos($class, 'NoCake\\FormBuilder\\') === 0) {
        require __DIR__.'/'.str_replace('\\', '/', $class).'.php';
    }
});