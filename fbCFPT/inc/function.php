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
            $filePath = "../upload/" . $mediaNames[$i]['nomMedia'];
            if (file_exists($filePath))
                unlink($filePath);
        }
        return true;
    } catch (Exception $e) {
        return false;
    }
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



// function insertPost()
// {
//     try {
        
//         $s = "INSERT INTO users (NICKNAME, EMAIL, PSWD, BIRTHDATE, CREATION_DATE, EMAIL_VERIFIED, TEXT_CHALLENGE, STATE, ROLES_CODE) VALUES (:nickname, :email, :pwd, :birthdate, :creationDate, '0', :text_hash,  'active', '2');";
//         $statement = EDatabase::prepare($s);
//         $statement->execute(array(':nickname' => $nicknameParam, ':email' => $emailParam, ':pwd' => $pwdParam, ':birthdate' => $birthdayDateParam, ':creationDate'=>$date, ':text_hash' => $random_hash));        return $result;
        
//     } catch (Exception $e) {
//         return $e;
//     }
// }
