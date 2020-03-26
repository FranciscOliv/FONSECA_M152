<?php
require_once dirname(__FILE__) . "/dbconnect.php";


function GetAllPost()
{
    try {
        $s = "SELECT * FROM post ORDER BY creationDate DESC";
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (Exception $e) {
        return $e;
    }
}

function PostExist($id)
{
    try {
        $postExists = false;

        $s = "SELECT * FROM post WHERE idPost = :id";
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute(array(':id' => $id));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            $postExists = true;
        }

        return $postExists;
    } catch (Exception $e) {
        return false;
    }
}


function GetPostInfoById($id)
{
    try {
        $s = "SELECT * FROM post WHERE idPost = :id";
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute(array(':id' => $id));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (Exception $e) {
        return $e;
    }
}

function GetMediaByPostId($id)
{
    try {
        $s = "SELECT * FROM media WHERE idPost = :id";
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute(array(':id' => $id));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (Exception $e) {
        return $e;
    }
}


function GetMediaNameByPostId($id)
{
    try {
        $s = "SELECT nomMedia FROM media WHERE idPost = :id";
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute(array(':id' => $id));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (Exception $e) {
        return $e;
    }
}

function UnlinkMediaById($mediaNames)
{
    try {

        for ($i = 0; $i < count($mediaNames); $i++) {
            $filePath =  dirname(__FILE__) . "/../upload/" . $mediaNames[$i]['nomMedia'];
            if (file_exists($filePath))
                unlink($filePath);
        }
        return true;
    } catch (Exception $e) {
        return false;
    }
}


function UnlinkMediaByName($name)
{
    $filePath = dirname(__FILE__) . "/../upload/" . $name;
    if (file_exists($filePath))
        unlink($filePath);
}

function DeletePostById($id)
{
    try {
        $mediaNamesArray = GetMediaNameByPostId($id);

        EDatabase::beginTransaction();

        $s = "DELETE FROM `m152`.`post` WHERE (`idPost` = :id);";
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute(array(':id' => $id));

        if (!UnlinkMediaById($mediaNamesArray)) {
            EDatabase::rollBack();
        }

        EDatabase::commit();

        return true;
    } catch (Exception $e) {
        EDatabase::rollBack();

        return false;
    }
}

function InsertPost($postText, $mediaInfo)
{
    try {
        EDatabase::beginTransaction();

        $date =  date("Y-m-d H:i:s", time());

        //Insert in post table
        $s = "INSERT INTO `m152`.`post` (`commentaire`, `creationDate`) VALUES (:postText, :creationDate)";
        $statement = EDatabase::prepare($s);
        $statement->execute(array(':postText' => $postText, ':creationDate' => $date));

        $postId = EDatabase::lastInsertId();

        //Insert in media table
        if (count($mediaInfo) > 0) {
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
            UnlinkMediaByName($info['fileName']);
        }
        return $e;
    }
}

function MoveUploadedMedia()
{
    $uploadErrors = array();
    $mediaInfo = array();

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
            array_push($uploadErrors, 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, mp3, mp4...');
        }
        if ($fileSize > $maxSizePerFile or $fileSizeSum > $maxSizeAllFiles) {
            array_push($uploadErrors, 'Le fichier est trop grand...');
        }
        if (empty($uploadErrors)) //S'il n'y a pas d'erreur, on upload
        {
            //On formate le nom du fichier ici...
            $fileName = strtr($fileName, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $fileName = preg_replace('/([^.a-z0-9]+)/i', '-', $fileName);
            if (!move_uploaded_file($files['tmp_name'][$i], $folder . $fileName)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            {
                array_push($uploadErrors, 'Echec de l\'upload !');

                break;
            } else {
                $currentMediaInfo = array(
                    'fileName' => $fileName,
                    'fileType' => $files['type'][$i]
                );
                array_push($mediaInfo, $currentMediaInfo);
            }
        } else {
            foreach ($mediaInfo as $info) {
                UnlinkMediaByName($info['fileName']);
            }
            break;
        }
    }
    return array('errors' => $uploadErrors, 'mediaInfo' => $mediaInfo);
}

function ShowSingleMedia($data)
{
    if (strpos($data['typeMedia'], 'image/') !== false) {
        echo <<<EOT
    <div class="image_blurred_wrapper">
        <div class="image_blurred" style="background-image: url('/upload/{$data['nomMedia']}');"></div>
        <img class="card-img-top imgPost" src="/upload/{$data['nomMedia']}" alt="Card image cap">
    </div>
    
    EOT;
    } elseif (strpos($data['typeMedia'], 'video/') !== false) {
        echo <<<EOT
        <video class="videoPost" controls autoplay loop muted>
            <source src="/upload/{$data['nomMedia']}" type="video/mp4">
            Your browser does not support HTML5 video.                   
        </video>        
        EOT;
    } elseif (strpos($data['typeMedia'], 'audio/') !== false) {
        echo <<<EOT
        <div class="p-1 bg-audio">
            <audio class="audioPost w-100 bg-audio" controls>
                <source src="/upload/{$data['nomMedia']}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>              
        </div>  
        EOT;
    }
}

function ShowMultiMedia($data)
{
    $uniqueCarouselID = "carousel" . uniqid();

    //CAROUSEL START / CAROUSEL INDICATORS START 
    echo <<<EOT
    <div id="$uniqueCarouselID" class="carousel slide card-img-top" data-ride="carousel">                                      
    EOT;


    if (!in_array('audio/mp3', array_column($data, 'typeMedia'))) { // search value in the array

        echo '<ol class="carousel-indicators">';
        // POST IMAGE LIST
        for ($i = 0; $i < count($data); $i++) {
            if ($i == 0) {
                echo '<li data-target="#' . $uniqueCarouselID . '" data-slide-to="' . $i . '" class="active"></li>';
            } else {
                echo '<li data-target="#' . $uniqueCarouselID . '" data-slide-to="' . $i . '"></li>';
            }
        }
        echo '</ol>';
    }

    //CAROUSEL
    echo '<div class="carousel-inner">';

    for ($i = 0; $i < count($data); $i++) {
        $activeBool = "";

        if ($i == 0) $activeBool = "active";



        if (strpos($data[$i]['typeMedia'], 'image/') !== false) {
            echo <<<EOT
                <div class="carousel-item $activeBool image_blurred_wrapper">
                    <div class="image_blurred" style="background-image: url('/upload/{$data[$i]['nomMedia']}')"></div>                               
                    <img alt="image" class="imgPost" src="/upload/{$data[$i]['nomMedia']}" /> 
                </div>                                   
                EOT;
        } elseif (strpos($data[$i]['typeMedia'], 'video/') !== false) {
            echo <<<EOT
                <div class="carousel-item $activeBool">
                    <video class="videoPost" controls autoplay loop muted>
                        <source src="/upload/{$data[$i]['nomMedia']}" type="video/mp4">
                        Your browser does not support HTML5 video.                   
                    </video>
                </div>                                 
                EOT;
        } elseif (strpos($data[$i]['typeMedia'], 'audio/') !== false) {
            echo <<<EOT
                <div class="carousel-item $activeBool bg-audio pb-1 pt-1">
                    <audio class="audioPost" controls>
                        <source src="/upload/{$data[$i]['nomMedia']}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>        
                </div>            
                EOT;
        }
    }
    echo <<<EOT
        </div>
        <a class="carousel-control-prev" href="#$uniqueCarouselID" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#$uniqueCarouselID" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    EOT;
}
