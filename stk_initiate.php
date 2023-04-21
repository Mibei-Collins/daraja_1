<?php
if(isset($_POST['submit'])){


  date_default_timezone_set('Africa/Nairobi');

  # access token
  $consumerKey = 'xcZqjmXZBgcsOwGzMM597hEtJGUwlw6J'; //Fill with your app Consumer Key
  $consumerSecret = 'RyHG1PIxfjAwLnbH'; // Fill with your app Secret

  # define the variales
  # provide the following details, this part is found on your test credentials on the developer account
  $InitiatorName = 'COLLINS KIPKOSGEI';
  $BusinesShortcode = '8488534';
  $PartyA = '6331806';
  $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';  
  
  
  $PartyB = $_POST['phone']; // This is your phone number, 
  $Occassion = '';
  $Remarks = 'Test Remarks';
  $Amount = $_POST['amount'];;
 
  # Description
  $CommandID = 'SalaryPayment';    
  
  # Security Credential
  $SecurityCredential = 'KfN6H6lkEaRQ0iZXH8Q2uQpNgayI+IvGh/t08gOqu861c8eqRXyPzrXjQawTBZK5766sHAtjbp1t40Xm8rBFsVdMuVTPXdMTC6BnSgdWLdnfxVp/a0JkuLtTA1kh5vAdLqNTcywc0jdPmOVvfofLX6o2nZpLlecZhS7hhbeUUjj6rPpwv75JVkoi8PQXyc97fIxh4iPR29yr7PaAI0l2Jz3Kv55zlBi4Sh4yxctBw2iLEMX230oyYRMsGzgw5yV/wRsmKWKSdlozlaJXzktuvPWMRnODnM2dFxeQ9bpUZejROijZh6ac0TZzwiikNujIVa3WRjjfZC+J9tVAfmrGPw==';

  # header for access token
  $headers = ['Content-Type:application/json; charset=utf8'];

    # M-PESA endpoint urls
  $access_token_url = 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
 

  # callback url
  $Results = 'https://morning-forest-72309.herokuapp.com/results.php';
  
  $QueueTime = 'https://morning-forest-72309.herokuapp.com/queuetime.php';

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

  

  $curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinesShortcode' => $BusinesShortcode, 
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
