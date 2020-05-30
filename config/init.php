<?php
require_once "conn.php";

if (isset($_REQUEST["login"])) {

    $view = "SELECT * FROM `house` order by house_id DESC LIMIT 5";
    $query_result = $conn->query($view);

    while ($data = $query_result->fetch_assoc()) {
        $preview = '<div class="properties-img w3-margin">
        <img src="' . str_replace("../", "", $data["house_image"]) . '" alt="' . str_replace("../", "", $data["house_image"]) . '" />
        <div class="view-caption rent-caption">
            <h4><span class="glyphicon glyphicon-map-marker"></span> ' . $data["house_address"] . ', ' . $data["house_city"] . ', <b>' . $data["house_country"] . '</b>
            </h4>
        </div>
        <div class="w3ls-buy">
            <a href="single.html" class="rent">Rent</a>
        </div>
    </div>
    <div class="w3ls-text">
        <h5>' . $data["house_cate"] . '</h5>
        <h6 class="w3-large w3-text-green"><b>&#8358</b> ' . $data["house_cost"] . '.00</h6>
        <p><b class="glyphicon glyphicon-user w3-text-teal"> :</b> ' . $data["house_owner"] . '</p>
        <p><b class="glyphicon glyphicon-phone"> : </b> <a href="tel:'.$data["owner_telephone"].'">' . $data["owner_telephone"] . '</a></p>
    </div>';
        print($preview);
    }
}
