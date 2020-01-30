<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/dbconnect.php";


function getAll()
{
    try {
        $s = "SELECT * FROM m152.post;";
        $statement = EDatabase::prepare($s);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (Exception $e) {
        return $e;
    }
}