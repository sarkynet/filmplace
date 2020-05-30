<?php
session_start();
require_once 'conn.php';

if (isset($_SESSION['FullName'])) {
    $session['fullName'] = $_SESSION['FullName'];
    $session['userID'] = $_SESSION['UserID'];
    $session['telephone'] = $_SESSION['Telephone'];
    $session['loginStatus'] = TRUE;
    print(json_encode($session, JSON_PRETTY_PRINT));
} else {
    $session['loginStatus'] = FALSE;
    print(json_encode($session, JSON_PRETTY_PRINT));
}