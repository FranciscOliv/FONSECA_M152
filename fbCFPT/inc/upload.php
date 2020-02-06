<?php
if (isset($_FILES) && is_array($_FILES) && count($_FILES) > 0) {
    //if (isset($_FILES['inputImg[]'])){

    $files = $_FILES['inputImg'];

    //70mo
    $fileSizeSum = 0;
    $maxSizeAllFiles = 70000000;

    for ($i = 0; $i < count($files['name']); $i++) {
        $errors = array();
        $folder = $_SERVER["DOCUMENT_ROOT"] . '/upload/';
        $maxSizePerFile = 3000000;
        $fileSize = filesize($files['tmp_name'][$i]);
        $fileSizeSum += $fileSize;
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($files['name'][$i], '.');
        $files['name'][$i] = uniqid() . $extension;
        $file = basename($files['name'][$i]);
        //Début des vérifications de sécurité...
        if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
        {
            array_push($errors, 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...');
        }
        if ($fileSize > $maxSizePerFile or $fileSizeSum > $maxSizeAllFiles) {
            array_push($errors, 'Le(s) fichier(s) est trop grand(s)...');
        }
        if (!isset($errors)) //S'il n'y a pas d'erreur, on upload
        {
            //On formate le nom du fichier ici...
            $file = strtr($file, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $file = preg_replace('/([^.a-z0-9]+)/i', '-', $file);
            if (!move_uploaded_file($files['tmp_name'][$i], $folder . $file)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            {
                array_push($errors, 'Echec de l\'upload !');
            }
        }
    }
}
