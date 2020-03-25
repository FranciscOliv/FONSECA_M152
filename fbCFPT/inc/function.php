<?php
require_once dirname(__FILE__) . "/dbconnect.php";


function getAllPost()
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

function getMediaByPostId($id)
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
function getMediaNameByPostId($id)
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


function unlinkMediaById($id)
{
    try {
        $mediaNames = getMediaNameByPostId($id);

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


function unlinkMediaByName($name)
{
    $filePath = dirname(__FILE__) . "/../upload/" . $name;
    if (file_exists($filePath))
        unlink($filePath);
}

function deletePostById($id)
{
    try {

        if (!unlinkMediaById($id)) {
            return false;
        }

        $s = "DELETE FROM `m152`.`post` WHERE (`idPost` = :id);";
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute(array(':id' => $id));

        return true;
    } catch (Exception $e) {

        return false;
    }
}
