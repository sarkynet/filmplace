<?php
require_once "conn.php";

$preview = null;
// View Latest Uploads
if (isset($_REQUEST["login"])) {

    $view = "SELECT * FROM `house` ORDER BY house_id DESC LIMIT 5";
    $query_result = $conn->query($view);

    if ($query_result->num_rows > 0) {
        while ($data = $query_result->fetch_assoc()) {
            $preview .= '<div class="properties-img">
        <img src="' . str_replace("../", "", $data["house_image"]) . '" alt="' . str_replace("../", "", $data["house_image"]) . '" />
    </div>
    <div class="w3ls-text w3-margin-bottom">
        <h5>' . $data["house_cate"] . '</h5>
        <p>' . $data["house_description"] . '</p>
        <h6 class="w3-large w3-text-green"><b>' . $data["house_currency"] . '</b> ' . $data["house_cost"] . '.00</h6>
        <p><b class="glyphicon glyphicon-user w3-text-teal"> :</b> ' . $data["house_owner"] . '</p>
        <p><b class="glyphicon glyphicon-phone"> : </b> <a href="tel:' . $data["owner_telephone"] . '">' . $data["owner_telephone"] . '</a></p>

        <div class="w3-teal rent-caption">
            <p class="w3-text-white w3-padding-4">
                <b><span class="glyphicon glyphicon-map-marker"></span></b> ' . $data["house_address"] . ', ' . $data["house_city"] . ', <b>' . $data["house_country"] . '</b>
             </p>
        </div>
    </div>';
        }
        print($preview);
    } else
        print("<span class='w3-margin-8 w3-center w3-btn-block w3-purple'>No Latest Uploads  </span>");
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


if (isset($_REQUEST["keyword"])) {
    $keyword = $_REQUEST["keyword"];
    $search = "SELECT * FROM house WHERE house_city LIKE '%$keyword%' OR house_cate LIKE '%$keyword%' OR house_country LIKE '%$keyword%'";
    $search_result = $conn->query($search);

    if ($search_result->num_rows > 0) {
        while ($data = $search_result->fetch_assoc()) {
            $preview .= '<div class="properties-img">
            <img src="' . str_replace("../", "", $data["house_image"]) . '" alt="' . str_replace("../", "", $data["house_image"]) . '" />
        </div>
        <div class="w3ls-text w3-margin-bottom">
            <h5>' . $data["house_cate"] . '</h5>
            <p>' . $data["house_description"] . '</p>
            <h6 class="w3-large w3-text-green"><b>' . $data["house_currency"] . '</b> ' . $data["house_cost"] . '.00</h6>
            <p><b class="glyphicon glyphicon-user w3-text-teal"> :</b> ' . $data["house_owner"] . '</p>
            <p><b class="glyphicon glyphicon-phone"> : </b> <a href="tel:' . $data["owner_telephone"] . '">' . $data["owner_telephone"] . '</a></p>
    
            <div class="w3-teal rent-caption">
                <p class="w3-text-white w3-padding-4">
                    <b><span class="glyphicon glyphicon-map-marker"></span></b> ' . $data["house_address"] . ', ' . $data["house_city"] . ', <b>' . $data["house_country"] . '</b>
                 </p>
            </div>  
        </div> <div class="clearfix"></div>';
        }
        print($preview);
    } else
        print("<span class='w3-margin-8 w3-center w3-text-purple'>No Available Property</span>");
}








// View house properties
// {
//     // print($_GET['id']);
//     $sql = "SELECT * FROM house WHERE house_id=" . $_GET['id'];
//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {
//         while ($data = $result->fetch_assoc()) {
//             $property = '
//             <div class="properties-img properties-img-single">
//                 <img src="'.str_replace("../", "", $data["house_image"]) . '" alt="' . str_replace("../", "", $data["house_image"]).'" alt="">
//                 <div class="view-caption">
//                 <h4><span class="glyphicon glyphicon-map-marker"></span> '.$data["house_address"].', '.$data["house_city"].', '.$data["house_country"].' </h4>  
//             </div>
//         </div>
//             <div class="w3ls-details">
//         <h4>'.$data["house_cate"].'</h4>
//         <p class="agile-text">'.$data["house_description"].' </p>
//         <div class="w3ls-text">
//             <h4>Property Details</h4>
//             <p class="w3-large w3-text-green"><b>' . $data["house_currency"] . '</b> ' . $data["house_cost"] . '.00 <small>(per day)</small></p>
//             <p><b><span class="glyphicon glyphicon-globe"></span> Country :</b> '.$data["house_country"].'</p>
//             <p><b>City: </b>'. $data["house_city"].'</p>
//             <p><b><span class="glyphicon glyphicon-map-marker"></span> Address :</b>'.$data["house_address"].' </p>
            
//         </div>
//     </div>

//     <div class="w3ls-related">
//         <h3 class="w3ls-title">Contact Agent</h3>
//         <div class="agents w3agent-grid">
//             <div class="w3agent-text w3-center">
//                 <h4>'.$data["house_owner"].' </h4>
//                 <p class="w3-xlarge"><b class="glyphicon glyphicon-phone"> : </b> <a href="tel:' . $data["owner_telephone"] . '">' . $data["owner_telephone"] . '</a></p>
//             </div>
//         </div>
//     </div>';
//             print($property);
//         }
//     }
// }
