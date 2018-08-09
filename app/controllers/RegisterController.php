<?php
/**
 * Created by PhpStorm.
 * User: waldemar
 * Date: 13.07.18
 * Time: 09:32
 */

namespace App\Controllers;

use App\Core\App;

class RegisterController
{

    public function register()
    {
        if((!isset($_SESSION['userType'])) || $_SESSION['userType'] == 0) {
            return view('web/register');
        }else
        {
            redirect ('');
        }

    }

    protected function filter($filteredVar)
    {
        if (get_magic_quotes_gpc())
            $filteredVar = stripslashes($filteredVar);
        return (htmlspecialchars(trim($filteredVar)));
    }

    public function registerValidation()
    {
        if (isset($_POST['register'])) {
            $email = $this->filter($_POST['email']);

            $registeredEmails = (int)App::get('database')
                ->table(['users'])
                ->select(['count(*) as howMany'])
                ->where(["email = '$email'"])
                ->fetch()[0]->howMany;
            if ($registeredEmails > 0) {
                $errMsg = "Taki email już istnieje w bazie. <a href='passwordreset'>Zapomniałeś hasła?</a>";
                SessionController::setErrors($errMsg);
                redirect('register');
            }else if ($_POST['password'] != $_POST['password_confirm']) {
                $errMsg = "Hasła się nie zgadzają.";
                SessionController::setErrors($errMsg);
                redirect('register');
            }else
            {
                $password = $this->filter(password_hash($_POST['password'], PASSWORD_DEFAULT));
                App::get('database')
                    ->table(['users'])
                    ->insert([
                        'email' => $email,
                        'password' => $password
                    ]);
                $infoMsg = "Użytkownik został zarejestrowany. Możesz się zalogować";
                SessionController::setInfo($infoMsg);
                redirect('login');
            }
        } else {
            redirect('register');
        }
    }
}