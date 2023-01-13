<?php
    include_once './Database.php';
    require_once '../model/Transaction.php';
    require_once '../service/TransactionService.php';

    $database = new Database();
    $db = $database->getConnection();
    $transactionService = new TransactionService($db);
    $result = $transactionService->getTransactions();

    // Return response
    echo '<pre>';
    print_r($result);
    echo '</pre>';

     $conn = null;
?>