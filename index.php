<?php

function __autoload($class){
    require 'lib/'.$class.'.php';
}
$app = new Application();