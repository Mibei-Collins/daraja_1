<?php
if(isset($_POST['submit'])){


  date_default_timezone_set('Africa/Nairobi');

  # access token
  $consumerKey = 'fGdVMGO2Ecur8FTQbEoAZRNoA4lounSQ'; //Fill with your app Consumer Key
  $consumerSecret = 'NVRWDukLSFUEXDE7'; // Fill with your app Secret

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
  $SecurityCredential = 'B4TNU43PY67qsI6o06+BzGOrvHTHdMi6QFgR9rtnejr5ZUUpnRioY3l3K7/uXrXZEifLRnoTVHHGQ5jMOnjSo5/Dd5ia24zP4PTf+cnZrJLosDCUUChVom0MC6MOS8e0tzPtm2mm+aAz/YYoC7JRGlFHbu8hc1AqrPvzrPSVcSIvLIDQDh89FONw8FHBw0tjwnFhePOw/H+MBDqr5HTPaEocWvDCgG3ificWaMAXAfr64mSHZLz9kKtE3P4Y4Z6nXpczXQuE3cmu7UvhiFd6w+pZMBzHGAKZuc5z85/oFmLCnbLwX+uvdtoDstTFJOx0dx38lQz76c/P+3yvccDhJA==';

  # header for access token
  $headers = ['Content-Type:application/json; charset=utf8'];

    # M-PESA endpoint urls
  $access_token_url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
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
   # initiating the transaction
   $curl = curl_init();
   curl_setopt($curl, CURLOPT_URL, $initiate_url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  $curl_response = curl_exec($curl);
  print_r($curl_response);

  echo $curl_response;
};
?>
