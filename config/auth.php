<?php
require_once '../config/conn.php';

// Login Algorithm
if (isset($_REQUEST['email'])) {

    // Sanitize Email input
    $email = filter_var(trim($_REQUEST['email']), FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z0-9.@_-]+$/")));

    // Server Query Request
    $login_request = 'SELECT * FROM sellers WHERE emailAddress ="' . $email . '"';
    $request_result = $conn->query($login_request);

    if ($request_result->num_rows > 0) {
        while ($request_data = $request_result->fetch_assoc()) {

            // Deciphering Password
            if (password_verify($_REQUEST['password'], $request_data['password'])) {
                session_start();
                $_SESSION['FullName'] = $data['full_name'];
                print('<script>window.location.href = "../main.html"</script>');
            } else
                print('<span class="w3-animate-top w3-red w3-padding-8 w3-center">Invalid Email/Password</span>');
        }
    } else
        print('<span class=" w3-red w3-animate-top w3-padding-8 w3-center">Email does not exist</span>');
}


// Account verification
if(isset($_REQUEST['email']))
{
    $email = filter_var(trim($_REQUEST['userEmail']), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9.@_-]+$/")));
    $verification_request = "SELECT * FROM sellers WHERE emailAddress={$email}";
    $request_result = $conn->query($verification_request);
    if($request_result->num_rows > 0)
    {
        while ($request_data = $request_result->fetch_assoc())
        {
            $request_response['email'] = $request_data['emailAddress'];
            $request_response['verify'] = TRUE;
            $request_response['userId'] = intval($db_data['user_id']);
        }
        print(json_encode($request_response));
    }
    else
    {
        $response['error'] = '<span class="w3-animate-top w3-red w3-padding-8 w3-center">Verification Failed</span>';
        print(json_encode($response));
        return FALSE;
    }
}

// Reset Password
if (isset($_REQUEST['newPassword']))
{
    if ($_REQUEST['newPassword'] == $_REQUEST['verifyNewPassword'])
    {
        $update_action = "UPDATE celteck_user SET user_password='".password_hash($_REQUEST["newPassword"], PASSWORD_DEFAULT).
        "' WHERE user_id=".$_REQUEST["userId"];
        $result = $conn->query($update_action);
        $data['status'] = TRUE;
        $data['msg'] = '<small class="alert alert-success w3-animate-bottom">Pasword Changed <a href="index.html">Sign In</a></small>';
        print(json_encode($data));
    }
    else
    {
        $data['error'] = '<small class="alert alert-danger w3-animate-bottom">Password Does not Match</small>';
        return FALSE;
        print(json_encode($data));
    }
}
