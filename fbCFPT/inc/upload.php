<?php
if (isset($_FILES['img'])){

    var_dump($_FILES);
    $folder = $_SERVER["DOCUMENT_ROOT"] . '/upload/';
    $file = basename($_FILES['img']['name']);
    $maxSize = 3000000;
    $fileSize = filesize($_FILES['img']['tmp_name']);
    $extensions = array('.png', '.gif', '.jpg', '.jpeg');
    $extension = strrchr($_FILES['img']['name'], '.');
    //Début des vérifications de sécurité...
    if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
    {
        $error = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
    }
    if ($fileSize > $maxSize) {
        $error = 'Le fichier est trop gros...';
    }
    if (!isset($error)) //S'il n'y a pas d'erreur, on upload
    {
        //On formate le nom du fichier ici...
        $file = strtr($file, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        $file = preg_replace('/([^.a-z0-9]+)/i', '-', $file);
        if (!move_uploaded_file($_FILES['img']['tmp_name'], $folder . $file)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
        {
            echo 'Echec de l\'upload !';
        }
    } else {
        echo $error;
    }
}
?>
