<?php
//code 4 = ControllerException for log
class ControllerException extends Exception{
    public function __construct($message, $previous) {
        parent::__construct($message, 4, $previous);
    }
}
