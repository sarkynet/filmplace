<?php
session_start();
require_once 'conn.php';

if (isset($_REQUEST['login'])) {
    $gallery = 'SELECT house_image, house_description FROM house WHERE owner_telephone='.$_SESSION["Telephone"];
    $result = $conn->query($gallery);

    if ($result->num_rows > 0) {
        while($data = $result->fetch_assoc()){
            print('
            <div class="gallery-grids">
                <div class="w3ls-hover">
                    <a href="'.str_replace("../", "", $data["house_image"]).'" data-lightbox="example-set" data-title="'.$data["house_description"].'">
                        <img src="'.str_replace("../", "", $data["house_image"]).'" class="img-responsive zoom-img" alt="'.str_replace("../", "", $data["house_image"]).'" />
                        <div class="view-caption">
                            <h5>View+</h5>
                        </div>
                    </a>
                </div>
            </div>
            ');
        }
    }
    else
        print("<span class='w3-margin-8 w3-center w3-btn-block w3-purple'>No recent Uploads </span>");
}