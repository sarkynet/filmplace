<?php
require_once "conn.php";

// View Latest Uploads
if (isset($_REQUEST["login"])) {

    $view = "SELECT * FROM `house` ORDER BY house_id DESC LIMIT 5";
    $query_result = $conn->query($view);

    if ($query_result->num_rows > 0) {
        while ($data = $query_result->fetch_assoc()) {
            $preview = '<div class="properties-img">
        <img src="' . str_replace("../", "", $data["house_image"]) . '" alt="' . str_replace("../", "", $data["house_image"]) . '" />
        <div class="view-caption rent-caption">
            <h4><span class="glyphicon glyphicon-map-marker"></span> ' . $data["house_address"] . ', ' . $data["house_city"] . ', <b>' . $data["house_country"] . '</b>
            </h4>
        </div>
        <div class="w3ls-buy" id="' . $data["house_id"] . '">
            <a class="rent" href="single.html?house_id='.$data["house_id"].'">Rent</a>
        </div>
    </div>
    <div class="w3ls-text w3-margin-bottom">
        <h5>' . $data["house_cate"] . '</h5>
        <p>' . $data["house_description"] . '</p>
        <h6 class="w3-large w3-text-green"><b>'.$data["house_currency"].'</b> ' . $data["house_cost"] . '.00</h6>
        <p><b class="glyphicon glyphicon-user w3-text-teal"> :</b> ' . $data["house_owner"] . '</p>
        <p><b class="glyphicon glyphicon-phone"> : </b> <a href="tel:' . $data["owner_telephone"] . '">' . $data["owner_telephone"] . '</a></p>
    </div>';
            print($preview);
        }
    } else
        print("<span class='w3-red w3-padding-8 w3-center w3-btn-block w3-xlarge'>NO INTERNET: Try Again</span>");
}

// Search Algorithm
/**
 * Advance Search
 */
if (isset($_REQUEST['priceStart']) || isset($_REQUEST['city']) || isset($_REQUEST['category']) || isset($_REQUEST['country']) || isset($_REQUEST['priceEnd'])) {
    $search = "SELECT * FROM house WHERE house_city LIKE '%" . $_REQUEST["city"] . "%' OR house_cate LIKE '%" . $_REQUEST["category"] . "%' OR house_country LIKE '%" . $_REQUEST["country"] . "%'";
    $search_result = $conn->query($search);

    if ($search_result->num_rows > 0) {
        while ($data = $search_result->fetch_assoc()) {
            $preview["result"] .= '<div class="latest-grids-image">
            <img src="' . str_replace("../", "", $data["house_image"]) . '" alt="' . str_replace("../", "", $data["house_image"]) . '" />
            <div class="latest-grids-description">
                <h4><span class="glyphicon glyphicon-map-marker"></span> 25B St, Washington, USA
                </h4>
                <h5>&#8358' . $data["house_cost"] . '</h5>
            </div>
        </div>
        <h6>Sale</h6>
        <div class="latest-grids-text">
            <h5><a href="single.html">Ecat vulputate Don</a></h5>
            <p><b>Area :</b> 1,145 sq.ft </p>
            <p><b>Bed Rooms :</b> 1 </p>
        </div>';
        }
        print(json_encode($preview, JSON_PRETTY_PRINT));
    } else {
        print(json_encode($preview, JSON_PRETTY_PRINT));
    }
}
