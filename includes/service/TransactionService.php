<?php
    include_once '../model/Transaction.php';

    class TransactionService {
        private $conn;
        /**
         * @param PDO $conn
         */
        public function __construct(PDO $database) {
            $this->conn = $database;
        }

        // GET all
        public function getTransactions(){
            try{
                $query = "
                    SELECT transactions.id, transactions.amount, transactions.date, transactionType.type, category.name as category
                    FROM transactions 
                    JOIN transactionType 
                    ON transactions.transactionType = transactionType.id 
                    JOIN category 
                    ON transactions.category = category.id
                    ORDER BY transactions.date DESC
                ";
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
    
                $result = $stmt->setFetchMode(PDO::FETCH_CLASS,'Transaction');
                $result = $stmt->fetchAll();
                
                return $result;
            }catch(Exception $ex){
                echo $ex->getMessage();
            }
        }

        public function getTransactionById(int $id){
            try{
                $query = "SELECT * FROM " . Transaction::$dbTableName . " WHERE id = :id LIMIT 1";
                $stmt = $this->conn->prepare($query);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->fetch();

                if($result == false){
                    $exception = new GlobalException("Transaction with id {$id} not found", 404, "NotFoundException");
                    return $exception;
                }

                return $result;
            }catch(Exception $ex){
                echo $ex->getMessage();
            }
        }
    
    

    
}
?>