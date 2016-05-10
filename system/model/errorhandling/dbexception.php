<?php
//code 2 = DBException for log
class DBException extends Exception{
    public function __construct($message, $previous = NULL) {
        parent::__construct($message, 2, $previous);
    }
}
