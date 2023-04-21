<?php
  // read the response data sent by M-PESA API
  $callbackJSONData = file_get_contents('php://input');

  // parse the response data
  $callbackData = json_decode($callbackJSONData);

  // extract the transaction status
  $resultCode = $callbackData->Result->ResultCode;

  // perform actions based on the transaction status
  if ($resultCode == 0) {
    // update transaction status in database
    $transactionStatus = $callbackData->Result->ResultDesc;
    $transactionId = $callbackData->TransactionID;
    // update database records accordingly
    // ...
  } else {
    // handle error
    $errorMessage = $callbackData->Result->ResultDesc;
    // log error message
    // ...
  }

  // send response back to M-PESA API
  header("Content-Type: application/json");
  echo '{"ResultCode": 0, "ResultDesc": "The service was accepted successfully"}';
?>
