<?php
// code 1 = domainException for log
class DomainModelException extends Exception {
    
    public function __construct($message, $previous) {
        parent::__construct($message, 1, $previous);
    }
}
