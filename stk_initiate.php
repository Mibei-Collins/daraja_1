<?php
if(isset($_POST['submit'])){


  date_default_timezone_set('Africa/Nairobi');

  # access token
  $consumerKey = 'yGnHSOnG4fCsD7JkiiTzQqCZxUzJdOem'; //Fill with your app Consumer Key
  $consumerSecret = '8GWT1qPFfcgSbVRG'; // Fill with your app Secret

  # define the variales
  # provide the following details, this part is found on your test credentials on the developer account
  $InitiatorName = 'CM';
  
  $PartyA = '6331806';
  
  
  
  $PartyB = $_POST['phone']; // This is your phone number, 
  $Occassion = '';
  $Remarks = 'Test Remarks';
  $Amount = $_POST['amount'];;
 
  # Description
  $CommandID = 'SalaryPayment';    
  
  # Security Credential
  $SecurityCredential = 'eUbqoLZp2Zik9E478l6p9VkezyhpuYcw0dvegUXXZI4M9XWoeteVoA3UEcifl4kZQni7qC2C7Poy7WT7FjtxW/9HzkzfHelm3NRl3YFT/YLz4ZcjzWt7UujGeZLLsRrFW8/ybJ6KmZJ6kGLxFyzShaXk0BvkcdPqdfU3JaxmRHU5LYK+CFj4vIeyX8TclCHc5ioL/aeACoqVcIptvcoLGuX3sLuOI5UqoqK/7ll1ePGr1jWM9ltC9rZ+K3t1u7P/clmm2wwRWlhk/9nVhYqnkIMA5NdTGBLs/xjx14pkEDPGNho2kyjvArIhW46AsM6fNe3gpIb1yhh7Wp9An4ppgA==';

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
