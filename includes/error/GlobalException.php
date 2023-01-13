<?php
    class GlobalException{
        public $message;
        public $status;
        public $type;
    
    /**
     * @param mixed $message
     * @param int<3, 3> $status
     * @param mixed $type
     */
    public function __construct($message, $status, $type) {
    	$this->message = $message;
    	$this->status = $status;
    	$this->type = $type;
    }
}
?>