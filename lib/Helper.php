<?php

class Helper {

    public static function redirect($page, $time = 0) {
        if($time>0){
            header('refresh:'.$time.';url=' . URL . $page);
        } else{
            header('Location: ' . URL . $page);
        }
    }
}