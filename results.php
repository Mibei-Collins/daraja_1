<?php
// Retrieve the POST data sent by M-Pesa API
$callbackJSONData = file_get_contents('php://input');

// Log the M-Pesa response
$logFile = "logs/response.log";
$log = fopen($logFile, "a");
fwrite($log, $callbackJSONData . PHP_EOL);
fclose($log);

// Decode the JSON data received
$callbackData = json_decode($callbackJSONData);

// Retrieve the result code and result description
$resultCode = $callbackData->ResultCode;
$resultDesc = $callbackData->ResultDesc;

// If transaction was successful, perform necessary actions
if ($resultCode == 0) {
    // Retrieve the transaction ID and amount
    $transID = $callbackData->TransactionID;
    $amount = $callbackData->Amount;

    // Perform necessary actions e.g. update database, notify user, etc.
    // ...

    // Send response back to M-Pesa API
    header("Content-Type: application/json");
    echo '{"ResultCode":0, "ResultDesc":"The service was accepted successfully"}';
} else {
    // If transaction failed, log the error and send response back to M-Pesa API
    $errorLog = "logs/error.log";
    $log = fopen($errorLog, "a");
    fwrite($log, "Error: $resultCode - $resultDesc" . PHP_EOL);
    fclose($log);

    header("Content-Type: application/json");
    echo '{"ResultCode":1, "ResultDesc":"The service was not accepted"}';
}
?>