<?php
// set the timeout duration in seconds
$timeout_duration = 30;

// get the start time
$start_time = time();

// loop until the timeout duration has elapsed
while ((time() - $start_time) < $timeout_duration) {
    // check if the payment has been completed
    // you can do this by checking the status of the payment in your database or in the MPESA API
    // if the payment has been completed, you can exit the loop and return a success response

    // if the payment is still in progress, wait for a short time before checking again
    sleep(1);
}

// if the timeout duration has elapsed, return a failure response
echo "Payment timed out";
?>
