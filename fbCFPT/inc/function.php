<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/dbconnect.php";


function getAll()
{
    try {
        $s = "SELECT * FROM m152.post;";
        $statement = EDatabase::prepare($s);
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (Exception $e) {
        return $e;
    }
}

function insertPost()
{
    try {
        
        $s = "INSERT INTO users (NICKNAME, EMAIL, PSWD, BIRTHDATE, CREATION_DATE, EMAIL_VERIFIED, TEXT_CHALLENGE, STATE, ROLES_CODE) VALUES (:nickname, :email, :pwd, :birthdate, :creationDate, '0', :text_hash,  'active', '2');";
        $statement = EDatabase::prepare($s);
        $statement->execute(array(':nickname' => $nicknameParam, ':email' => $emailParam, ':pwd' => $pwdParam, ':birthdate' => $birthdayDateParam, ':creationDate'=>$date, ':text_hash' => $random_hash));        return $result;
        
    } catch (Exception $e) {
        return $e;
    }
}


