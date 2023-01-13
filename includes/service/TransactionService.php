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
                $exception = new GlobalException($ex->getMessage(), 500, "Fatal Exception");
                return $exception;
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
                $exception = new GlobalException($ex->getMessage(), 500, "Fatal Exception");
                return $exception;
            }
        }

        public function getTransactionsByType(int $type){
            try{
            $query = "SELECT t.id, t.amount, t.date, c.name as category, tt.type
                FROM transactions t
                JOIN category c
                ON t.category = c.id
                JOIN transactionType tt
                ON t.transactionType = tt.id
                WHERE t.transactionType = :type
                ORDER BY t.date DESC";

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':type', $type, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();

            return $result;
            }catch(Exception $ex){
                $exception = new GlobalException($ex->getMessage(), 500, "Fatal Exception");
            return $exception;
            }
        }
    
    

    
}
?>