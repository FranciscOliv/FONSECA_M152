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

        $files = $_FILES['inputFile'];

        //FILE SIZING
        $fileSizeSum = 0;
        $maxSizeAllFiles = 70000000;

        for ($i = 0; $i < count($files['name']); $i++) {
            $folder =  dirname(__FILE__) . "/../upload/";
            $maxSizePerFile = 3000000;

            $extensions = array('.png', '.gif', '.jpg', '.jpeg', '.mp4', '.mp3');
            $mediaMimeTypes = array('image/png', 'image/gif', 'image/jpeg', 'video/mp4', 'audio/mpeg');

            $fileSize = filesize($files['tmp_name'][$i]);
            $fileSizeSum += $fileSize;
            $extension = strrchr($files['name'][$i], '.');
            $mediaFileTest = mime_content_type($files['tmp_name'][$i]);
            $files['name'][$i] = uniqid() . $extension;
            $fileName = basename($files['name'][$i]);

            //Début des vérifications de sécurité...
            if (!in_array($extension, $extensions) or !in_array($mediaFileTest, $mediaMimeTypes)) //Si l'extension n'est pas dans le tableau
            {
                array_push($errors, 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, mp3, mp4...');
            }
            if ($fileSize > $maxSizePerFile or $fileSizeSum > $maxSizeAllFiles) {
                array_push($errors, 'Le fichier est trop grand...');
            }
            if (empty($errors)) //S'il n'y a pas d'erreur, on upload
            {
                //On formate le nom du fichier ici...
                $fileName = strtr($fileName, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                $fileName = preg_replace('/([^.a-z0-9]+)/i', '-', $fileName);
                if (!move_uploaded_file($files['tmp_name'][$i], $folder . $fileName)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                {
                    array_push($errors, 'Echec de l\'upload !');

                    break;
                } else {
                    $currentMediaInfo = array(
                        'fileName' => $fileName,
                        'fileType' => $files['type'][$i]
                    );
                    array_push($mediaInfo, $currentMediaInfo);
                    $containsMedia = true;
                }
            } else {
                foreach ($mediaInfo as $info) {
                    unlinkMediaByName($info['fileName']);
                }
                break;
            }
        }
    } else {
        array_push($errors, "The post must contain some media");
    }

    if (empty($errors)) {

        try {
            EDatabase::beginTransaction();

            $date =  date("Y-m-d H:i:s", time());

            //Insert in post table
            $s = "INSERT INTO `m152`.`post` (`commentaire`, `creationDate`) VALUES (:postText, :creationDate)";
            $statement = EDatabase::prepare($s);
            $statement->execute(array(':postText' => $postText, ':creationDate' => $date));

            $postId = EDatabase::lastInsertId();

            //Insert in media table
            if ($containsMedia) {
                foreach ($mediaInfo as $arr) {
                    $s = "INSERT INTO `m152`.`media` (`typeMedia`, `nomMedia`, `creationDate`, `idPost`) VALUES (:mediaType, :mediaName , :creationDate, :postId);";
                    $statement = EDatabase::prepare($s);
                    $statement->execute(array(':mediaType' => $arr['fileType'], ':mediaName' => $arr['fileName'], ':creationDate' => $date, ':postId' => $postId));
                }
            }

            EDatabase::commit();
            header("Location: index.php");
        } catch (Exception $e) {
            EDatabase::rollBack();
            foreach ($mediaInfo as $info) {
                unlinkMediaByName($info['fileName']);
            }
            return $e;
        }
    }
}
