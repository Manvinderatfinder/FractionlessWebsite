<?php

/***********************************\
 * Somewhat secure PHP mail script *
 * Version 0.5					   *
 * Written by Bill Patrianakos	   *
 * http://billpatrianakos.me 	   *
\***********************************/

// Check for valid form submission
if(isset($_POST['submit'])) {
	// Check for required fields
	$required = array('email', 'message');
		foreach($required as $field) {
			if(!isset($_POST[$field]) || empty($_POST[$field]) ) {
				$error[] = $field;
				echo "Really? All we asked for was an email address and a message. Is that really too much? Please <a href=\"../index.html\">Go back</a> and fill those in.";
			}
			else {
				
				// Sanitize and validate
				// Set the POST info as variables
				$senderEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
				$senderMessage = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
			}
		}

	// Do not let mail be sent unless via _POST request
	if($_SERVER['REQUEST_METHOD'] != "POST") {
	   echo("Error. Spam activity detected. Please spam elsewhere.");
	   exit;
	}
	else {
		$email_to = "bill@chooseclever.com";
		$subject = "Fractionless Contact Message";
		$email_message .= "Email: \n" . $senderEmail . "\n";
		$email_message .= "Message: \n" . $senderMessage . "\n";

		// Send the mail
		mail($email_to, $subject, $email_message);
		header("location: http://fractionless.info");
	}
}
// If submit was not set that indicates foul play. Throw an error and die.
else {
	echo "You are attempting to send an unauthorized message. Don't waste your time.";
	exit;
}

?>