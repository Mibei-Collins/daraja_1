<?php
if(isset($_POST['submit'])){


  date_default_timezone_set('Africa/Nairobi');

  # access token
  $consumerKey = 'xcZqjmXZBgcsOwGzMM597hEtJGUwlw6J'; //Fill with your app Consumer Key
  $consumerSecret = 'RyHG1PIxfjAwLnbH'; // Fill with your app Secret

  # define the variales
  # provide the following details, this part is found on your test credentials on the developer account
  $InitiatorName = 'testapi';
  $BusinessShortcode = '8488534';
  $PartyA = '6331806';
  $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';  
  
  
  $PartyB = $_POST['phone']; // This is your phone number, 
  $Occassion = '';
  $Remarks = 'Test Remarks';
  $Amount = $_POST['amount'];;
 
  # Description
  $CommandID = 'SalaryPayment';    
  
  # Security Credential
  $SecurityCredential = 'C6CBUn/ULRbL5jrxNWCXVgxAV3g5vFk4NfurHtU0v80MhFjXoSmpVEcxI8XqJYueZvCNOXl8+lRZR5lp+c/k97vp10EcaiG2OUIg29/tOWSTDtAcNUU/H9+qw1Wf4wM5f0MyCGI+y4wpX+JHbZKGMkVB8uTePTUAfG6GhXKxyhRm/teS740eapaDgC5HtoVb87J0ZmXUsfRH+5+LA+tZZWyBIsnbsAKffjlGnvASTSsYtgr77lsz/c42bG1HBplBySyYjRZ0bRfYdFUBngwL008JR9n3oDO1soUKC4NNKI4bYKX/LOqFvPiUW+15v3RVh6u0uho5qhWV13QbxOf0eQ==';

  # header for access token
  $headers = ['Content-Type:application/json; charset=utf8'];

    # M-PESA endpoint urls
  $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
  $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';

  # callback url
  $Results = 'https://evening-scrubland-40886.herokuapp.com/results.php';
  
  $QueueTime = 'https://evening-scrubland-40886.herokuapp.com/timeout.php';

  $curl = curl_init($access_token_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($curl, CURLOPT_HEADER, FALSE);
  curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
  $result = curl_exec($curl);
  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  $result = json_decode($result);
  $access_token = $result->access_token;  
  curl_close($curl);
  $stkheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];

  # initiating the transaction
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $initiate_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader);
  

  $curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinessShortcode' => $BusinessShortcode,
    'InitiatorName' => $InitiatorName,
    'SecurityCredential' => $SecurityCredential,
    'CommandID' => $CommandID,
    'Amount' => $Amount,
    'PartyA' => $PartyA,
    'PartyB' => $PartyB,
    'QueueTime' => $QueueTime,
    'Results' => $Results,
    'Occassion' => $Occassion,
    'Remarks' => $Remarks
  );

  $data_string = json_encode($curl_post_data);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  $curl_response = curl_exec($curl);
  print_r($curl_response);

  echo $curl_response;
};
?>
