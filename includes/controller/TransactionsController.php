<?php

    include_once '../functions/Database.php';
    include_once '../service/TransactionService.php';
    include_once '../error/GlobalException.php';

    $requestBody = file_get_contents('php://input');
    $body = json_decode($requestBody, true);
    
    if(!isset($body['action'])) {
        $exception = new GlobalException("Not action supported", 400, "Bad Request");
        echo json_encode($exception);
        return;
    }

    // Get database connection
    $database = new Database();
    $db = $database->getConnection();

    if($body['action'] == "/findById"){
        // Get request
        $id = $_POST['id'];
    
        $transactionService = new TransactionService($db);
        $result = $transactionService->getTransactionById($id);
        
        echo json_encode($result);
    }
    
    if($body['action'] == "/findAll"){
        // Get request
    
        $transactionService = new TransactionService($db);
        $result = $transactionService->getTransactions();
       
        echo json_encode($result);
    }

?>