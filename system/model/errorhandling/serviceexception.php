<?php
//code 3 = serviceException for log
class ServiceException extends Exception{
    public function __construct($message, $previous) {
        parent::__construct($message, 3, $previous);
    }
}
