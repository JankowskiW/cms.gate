<?php
/**
 * Created by PhpStorm.
 * User: waldemar
 * Date: 16.07.18
 * Time: 09:54
 */

namespace App\Controllers;


class SessionController
{
    public static function start($userId, $userEmail, $userType)
    {

        try{
            $_SESSION['userId'] = $userId;
            $_SESSION['userEmail'] = $userEmail;
            $_SESSION['userType'] = $userType;
//            die(var_dump($_SESSION ));
            return true;
        }catch(Exception $e)
        {
            return false;
        }

    }

    public static function destroy()
    {
        try{

            $userId = $_SESSION['userId'];
            $_SESSION = array();
            session_destroy();
            setcookie('PHPSESSID', '', time() - 3600, '/', '', 0, 0);
            return $userId;
        }catch(Exception $e)
        {
            return false;
        }
    }

    public static function setErrors($errorMessage)
    {
        $_SESSION['errors'][] = $errorMessage;
    }

    public static function setInfo($infoMessage)
    {
        $_SESSION['info'][] = $infoMessage;
    }
}