<?php
 
    // include the PHP TwilioRest library
    require "twilio.php";
 
    // twilio REST API version
    $ApiVersion = "2010-04-01";
 
    // set our AccountSid and AuthToken
    $AccountSid = "ACc434bc16a7fd6bbb82c531f5dbc2cca2";
    $AuthToken = "2d411ed8581fbccc61ce6944eaf92d05";
     
    // instantiate a new Twilio Rest Client
    $client = new TwilioRestClient($AccountSid, $AuthToken);
 
    // make an associative array of people we know, indexed by phone number
    $people = array(
        "+17608894854"=>"David",
		"+18186441679"=>"Andrew",
    );
         
    // iterate over all our friends
    foreach ($people as $number => $name) {
 
        // Send a new outgoinging SMS by POSTing to the SMS resource */
        $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
            "POST", array(
            "To" => $number,
            "From" => "+14155992671",
            "Body" => "Hey $name, Let's Party!"
        ));
        if($response->IsError)
            echo "Error: {$response->ErrorMessage}";
        else
            echo "Sent message to $name";
    }
?>