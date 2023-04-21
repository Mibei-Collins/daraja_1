<?php
if(isset($_POST['submit'])){


  date_default_timezone_set('Africa/Nairobi');

  # access token
  $consumerKey = 'xcZqjmXZBgcsOwGzMM597hEtJGUwlw6J'; //Fill with your app Consumer Key
  $consumerSecret = 'RyHG1PIxfjAwLnbH'; // Fill with your app Secret

  # define the variales
  # provide the following details, this part is found on your test credentials on the developer account
  $InitiatorName = 'COLLINS KIPKOSGEI';
  $BusinesShortcode = '174379';
  $PartyA = '6331806';
  $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';  
  
  
  $PartyB = $_POST['phone']; // This is your phone number, 
  $Occassion = '';
  $Remarks = 'Test Remarks';
  $Amount = $_POST['amount'];;
 
  # Description
  $CommandID = 'SalaryPayment';    
  
  # Security Credential
  $SecurityCredential = 'o8h/4dGS0BmT6A705OQoaTgyS4zpJxmYO2hOX7pxqK+TA/VvmBq8DKhiEx3NP6ul+NQUMQspDMRg9AhNWXf5KGs0CrKz5aYQdLuwyx8VpVDqqqgLqDTh+2dmyvShvJFzYrQfGokzqSYX9CH/ryyXbszSU+Vujd0rt92GVioUXQ7Q70iAxFWuEMnq+ArfDwLNaT8vSmIVctugHyvn86jhrQqTxzGU/fvuhDgMdlvFsh+Z0eChiSCEHhu3+NWHZPKZDIqZnWEpV1ynsZMdCXqbi48anXGV4Mpd1cQqVmqqskni4uhWqOobNWdZVNvVbXCjRCPIvfX8VH+d2kWy6uuO4A==';

  # header for access token
  $headers = ['Content-Type:application/json; charset=utf8'];

    # M-PESA endpoint urls
  $access_token_url = 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
 

  # callback url
  $Results = 'https://evening-scrubland-40886.herokuapp.com/results.php';
  
  $QueueTime = 'https://evening-scrubland-40886.herokuapp.com/queuetime.php';

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
