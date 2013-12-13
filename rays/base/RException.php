<?php
/**
 * RException class
 *
 * @author: Raysmond
 */

class RException extends Exception{

}

class RPageNotFoundException extends RException{

    public function __construct($message=''){
        $this->code = 404;
    }
}