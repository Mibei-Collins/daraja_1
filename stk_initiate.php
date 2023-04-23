<?php
if(isset($_POST['submit'])){


  date_default_timezone_set('Africa/Nairobi');

  # access token
  $consumerKey = '6u2l6BdioLH1kalyGrUWNXaS6qCCjUbV'; //Fill with your app Consumer Key
  $consumerSecret = 'GGmKYfueo0wkBi8q'; // Fill with your app Secret

  # define the variales
  # provide the following details, this part is found on your test credentials on the developer account
  $InitiatorName = 'COLLINS KIPKOSGEI';
  $BusinessShortCode = '8488534';
  $PartyA = '6331806';
  
  
  
  $PartyB = $_POST['phone']; // This is your phone number, 
  $Occassion = '';
  $Remarks = 'Test Remarks';
  $Amount = $_POST['amount'];;
 
  # Description
  $CommandID = 'SalaryPayment';    
  
  # Security Credential
  $SecurityCredential = 'XAknZaZ3nEKQwFhrNdQAZI1J5t7Q9W5M4qrWl1BA7XPOTSde29mnXiB/rUXyY2Fe5kbp103EylzBtPJwIQ0KVEmdo7AwI0mbVfLbNpKpj1vTyCNTQUhn4wzEjM0/Ex3nCt36ZtpDDoDjQ+bMy7WfGjzWPyxxx7LjvoFYPPKmDRsZ5iZiqOBBzHoilJJG3i5/Qp/SOi18E7ysE5EPFDo2JgBTgazrTQprKCzTPf5ZYI88aDKyxlOVPK+Y3v1w4EiNzfYwBtSb4rGOiMuMqAwHijScj8haBpyXgiWGm9GMNZXeSEBKMNEqEDTNn30w3HnNkq88jNExRyjNNltYhxBNSA==';

  # header for access token
  $headers = ['Content-Type:application/json; charset=utf8'];

    # M-PESA endpoint urls
  $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
  $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

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
    'BusinessShortcode' => $BusinessShortCode,
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
