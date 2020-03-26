<?php
require_once dirname(__FILE__) . "/dbconnect.php";
require_once dirname(__FILE__) . "/security.inc.php";
require_once dirname(__FILE__) . "/function.php";

date_default_timezone_set('Europe/Zurich');

if (filter_has_var(INPUT_POST, 'createPost')) {

    //Variables locales
    $postText = "";
    $errors = array();
    $containsMedia = false;
    $mediaInfo = array();
    $okMessage = false;

    //Entrees par l'utilisateur
    $postText = filter_input(INPUT_POST, 'postText', FILTER_SANITIZE_STRING);


    if (empty($postText)) {
        array_push($errors, "The post must contain some text");
    }

    if (isset($_FILES['inputFile']) && $_FILES['inputFile']['error'][0] != 4 && empty($errors)) {
        $result = MoveUploadedMedia();

        if (empty($result['errors'])) {
            $mediaInfo = $result['mediaInfo'];
        } else {
            $errors = array_merge($errors, $result['errors']);
        }
    } else {
        array_push($errors, "The post must contain some media");
    }

    if (empty($errors)) {
        InsertPost($postText, $mediaInfo);
    }
}

