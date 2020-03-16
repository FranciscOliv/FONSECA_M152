<?php

require_once dirname(__FILE__) . "/function.php";


$id = "";

if (isset($_POST["id"])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
}


if (strlen($id) > 0) {

    if (deletePostById($id)) {
        
        echo '{ "ReturnCode": 0, "Message": "Suppression s\'est déroulé correctement"}';
        exit();
    } else {
        echo '{ "ReturnCode": 2, "Message": "L\'id n\'existe pas"}';
        exit();
    }
}
// Problème
echo '{ "ReturnCode": 1, "Message": "Paramètres manquants ou invalides."}';
