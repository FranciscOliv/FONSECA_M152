<?php
/*
 * Fonction de securité utilisé dans toutes les pages privées et aussi dans les pages register et login
*/
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function isLogged()
{
    if (array_key_exists('logged', $_SESSION)) {
        return $_SESSION['logged'];
    }
    else{
        return FALSE;
    }
}