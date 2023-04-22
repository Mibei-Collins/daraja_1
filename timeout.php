<?php

$ResultCode = 0;
$ResultDesc = "The service was accepted for processing.";

$Response = array(
    'ResultCode' => $ResultCode,
    'ResultDesc' => $ResultDesc
);

$ResponseJSON = json_encode($Response);

header('Content-Type: application/json');
echo $ResponseJSON;