<?php
    class Transaction{
        public $id;
        public $amount;
        public $date;
        public $category;
        public $type;
        public static $dbTableName = 'transactions';
        
}
?>