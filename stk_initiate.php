<?php
if(isset($_POST['submit'])){


  date_default_timezone_set('Africa/Nairobi');

  # access token
  $consumerKey = 'xcZqjmXZBgcsOwGzMM597hEtJGUwlw6J'; //Fill with your app Consumer Key
  $consumerSecret = 'RyHG1PIxfjAwLnbH'; // Fill with your app Secret

  # define the variales
  # provide the following details, this part is found on your test credentials on the developer account
  $InitiatorName = 'COLLINS KIPKOSGEI';
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
  $SecurityCredential = 'Joc0yqYi6UqVzB7JJW0FzolZ9tFiay9BYPwUaUr5hRSJo0z9G2n8ge6SAk0fnLY88+roDTXIhyZmxtJDv7EBeAfC7DGod+WM1/PIc9q5GOtWovYFm+zv7QnAik700lFROCPUtGCojVw0socXLbx6LYEVRotEs0CMDduAzIINDu6KKmYg++um5p0zBduaUyX07dNZlm3z+R0YI0QALbcZQjpua8AE2uYeq3VQBxDDO5PARoB1lIUN+ACu+5fGs9yqGI+fBUIihvbqEle5OUHUu2etfu3Bfftc13oiTjxsqAXCd9UhsBWkQUUbHHrmFRIZBNmjUOSPCkjqaO7AIzFk5A==';

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
    'Remarks' => $Remarks,
    'QueueTimeOutURL' => $QueueTime,
    'ResultURL' => $Results,
    'Occassion' => $Occassion
    
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
