<?php
if(isset($_POST['submit'])){


  date_default_timezone_set('Africa/Nairobi');

  # access token
  $consumerKey = 'yGnHSOnG4fCsD7JkiiTzQqCZxUzJdOem'; //Fill with your app Consumer Key
  $consumerSecret = '8GWT1qPFfcgSbVRG'; // Fill with your app Secret

  # define the variales
  # provide the following details, this part is found on your test credentials on the developer account
  $InitiatorName = 'COLLINS KIPKOSGEI';
  
  $PartyA = '6331806';
  
  
  
  $PartyB = $_POST['phone']; // This is your phone number, 
  $Occassion = '';
  $Remarks = 'Test Remarks';
  $Amount = $_POST['amount'];;
 
  # Description
  $CommandID = 'SalaryPayment';    
  
  # Security Credential
  $SecurityCredential = 'fpXT/0qBgUxs1w6EqXnmnlox5q9+l7r7G63p5havbE8iaIfuwo2xQMudFwHxj0Euu5ddcKfr9hOKtTiSv3Wvt6gWRzlz80+r8XQbJDMmUtNqWqrUkg9O6gHYFkPOjrrZt93lReUq8epgQsxLlKBNcDn95060EUIZeG7/WMMkDfYvtcmsf9b1VX3szvgx1Z73jbPyhcTd3W1KsaGmpfAr0zx2nDLw2YqekEPdo3u9vL06+Yx19j8sGCSX4p7ZkctKD99mup2h2KZVZEO5Tb7vcwsPuIQIPZQgDAKNkHlR8PtCglhASwEpDZtU0kTTaJfAVYJ0O/E6LoyW2aqehG8FrA==';

  # header for access token
  $headers = ['Content-Type:application/json; charset=utf8'];

    # M-PESA endpoint urls
  $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
  $initiate_url = 'https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';

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
