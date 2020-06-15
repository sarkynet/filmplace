<?php
require_once "conn.php";

$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions

$path = '../uploads/'; // upload directory
if (isset($_REQUEST['Category']) || isset($_REQUEST['Description'])) {
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    // get uploaded file's extension
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

    // can upload same image using rand function
    $final_image = rand(1000, 100000) . $img;

    // check's valid format
    if (in_array($ext, $valid_extensions)) {
        $path = $path . strtolower($final_image);
        if (move_uploaded_file($tmp, $path)) {

            session_start();

            // //insert form data in the database
            $upload_query = "INSERT INTO house (house_cate, house_currency, house_cost, house_city, house_country, house_description, house_availability, house_address, house_image, house_owner, owner_telephone) 
            VALUES ('{$_REQUEST["Category"]}', '{$_REQUEST["Currency"]}', '{$_REQUEST["Cost"]}', '{$_REQUEST["City"]}', '{$_REQUEST["Country"]}', '{$_REQUEST["Description"]}',1, '{$_REQUEST["Address"]}', '{$path}', '{$_SESSION["FullName"]}', '{$_SESSION["Telephone"]}')";
            $query_result = $conn->query($upload_query);

            if ($query_result == TRUE)
                print ('<span class="w3-animate-top w3-btn-block w3-green w3-padding-8 w3-center">Upload Successful</span>');
             else
               print('<span class="w3-animate-top w3-btn-block w3-red w3-padding-8 w3-center">:' . $conn->connect_error . '</span>');
        }
    }
}
