<?php
if(isset($_POST['submit'])){
  
  // rest of the code...
  
  // Get response code and message from M-Pesa API response
  $response_code = $curl_response['ResponseCode'];
  $response_message = $curl_response['ResponseDescription'];
  
  // Check if payment was successful
  if($response_code == '0'){
    echo "Payment successful: " . $response_message;
  }
  else{
    echo "Payment failed: " . $response_message;
  }
  
}
?>
