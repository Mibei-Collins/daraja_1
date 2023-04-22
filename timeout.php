<?php

# set the timeout duration in seconds
$timeout_duration = 120;

# get the request body
$request_body = file_get_contents('php://input');

# parse the request body to get the transaction status
$request_data = json_decode($request_body, true);
$status = $request_data['Result']['ResultCode'];

# if the transaction is still being processed, wait for the specified duration and then re-queue the request
if ($status == 0) {
  sleep($timeout_duration);
  http_response_code(202);
  exit();
}

# if the transaction has completed or failed, return the status to the caller
http_response_code(200);
echo json_encode($request_data);

?>