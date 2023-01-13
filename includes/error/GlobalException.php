<?php
    class GlobalException{
        public $message;
        public $status;
        public $error;
    
    /**
     * @param mixed $message
     * @param int<3, 3> $status
     * @param mixed $error
     */
    public function __construct($message, $status, $error) {
    	$this->message = $message;
    	$this->status = $status;
    	$this->error = $error;
    }
}
?>