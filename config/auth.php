<?php
require_once 'conn.php';

// Login Algorithm
if (isset($_REQUEST['loginEmail'])) {

    // Sanitize Email input
    $email = filter_var(trim($_REQUEST['loginEmail']), FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z0-9.@_-]+$/")));

    // Server Query Request
    $login_request = 'SELECT * FROM sellers WHERE email_address ="' . $email . '"';
    $request_result = $conn->query($login_request);

    if ($request_result->num_rows > 0) {
        while ($request_data = $request_result->fetch_assoc()) {

            // Deciphering Password
            if (password_verify($_REQUEST['loginPassword'], $request_data['user_password'])) {
                session_start();
                $_SESSION['FullName'] = $request_data['full_name'];
                $_SESSION['UserID'] = $request_data['sellerId'];
                $_SESSION['Telephone'] = $request_data['tel'];
                print('<script>window.location.href = "main.html"</script>');
            } else
                print('<span class="w3-animate-top w3-btn-block w3-red w3-padding-8 w3-center">Invalid Email/Password</span>');
        }
    } else
        print('<span class=" w3-red w3-animate-top w3-btn-block w3-padding-8 w3-center">Email does not exist</span>');
}


// Account verification
if (isset($_REQUEST['verifiedEmail'])) {
    $email = filter_var(trim($_REQUEST['verifiedEmail']), FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z0-9.@_-]+$/")));
    $verification_request = "SELECT * FROM sellers WHERE email_address='{$email}' AND security_question ='{$_REQUEST["securityQuestion"]}' AND user_answer='{$_REQUEST["answer"]}'";
    $request_result = $conn->query($verification_request);

    if ($request_result->num_rows > 0) {
        while ($request_data = $request_result->fetch_assoc()) {
            $request_response['Status'] = TRUE;
            $request_response['userId'] = intval($request_data['sellerId']);
        }
        print(json_encode($request_response));
    } else {
        $request_response['error'] = '<span class="w3-animate-top w3-red w3-padding-8 w3-btn-block w3-center">Verification Failed </span>';
        print(json_encode($request_response));
    }
}

// Reset Password
if (isset($_REQUEST['userId'])) {
    $reset_query = "UPDATE sellers SET user_password='" . password_hash($_REQUEST["password"], PASSWORD_DEFAULT) .
        "' WHERE sellerId=" . $_REQUEST["userId"];
    $query_result = $conn->query($reset_query);
    $request_data['Status'] = TRUE;
    $request_data['Message'] = '<span class="w3-animate-top w3-btn-block w3-green w3-padding-8 w3-center">Password Changed</span>';
     print(json_encode($request_data));
}

// New User

if (isset($_REQUEST['newUserEmail'])) {
    // Sanitize Name and Email
    $email = filter_var(trim($_REQUEST['newUserEmail']), FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z0-9.@_-]+$/")));
    $name = filter_var(trim($_REQUEST['fullName']), FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")));

    $sign_up_query = "INSERT INTO sellers (full_name, email_address, user_password, tel, security_question, user_answer, dateOfReg) 
    VALUES ('{$name}','{$email}','" . password_hash($_REQUEST["password"], PASSWORD_DEFAULT). "','{$_REQUEST["telephone"]}','{$_REQUEST["NewSecurityQuestion"]}','{$_REQUEST["answer"]}','{$_REQUEST["dateOfRegistration"]}')";

    $request_result = $conn->query($sign_up_query);
    if ($request_result === TRUE)
        print('<span class="w3-animate-top w3-btn-block w3-green w3-padding-8 w3-center">Registration Successful</span>');
    else
        print('<span class="w3-animate-top w3-btn-block w3-red w3-padding-8 w3-center">Email Address or Telephone number is already existing</span>');
}
