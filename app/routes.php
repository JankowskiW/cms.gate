<?php


/*  PagesController */
$router->get('404notfound', 'PagesController@pagenotfound');
$router->get('accessdenied', 'PagesController@accessDenied');

if (isset($_SESSION['userType']) && $_SESSION['userType'] != 0) {
    $router->get('', 'UsersController@dashboard');
} else {
    $router->get('', 'PagesController@home');
}

/* UsersController */
$router->get('traders', 'UsersController@show');
$router->get('passwordreset', 'UsersController@passwordResetGet');
$router->get('tradersettings', 'UsersController@tradersSettings');                  //  ZMIANA KONTROLLERA
$router->get('resetconfirmation', 'UsersController@pswdResetConfirmation');
$router->get('passwordresetconfirm', 'UsersController@passwordResetConfirm');
$router->post('tradersettings', 'UsersController@settings');
$router->post('resetpassword', 'UsersController@passwordReset');


/* RegisterController */
$router->get('register', 'RegisterController@register');                               //  ZMIANA KONTROLLERA
$router->post('registerValidation', 'RegisterController@registerValidation');

/* LoginController */
$router->get('login', 'LoginController@login');                                     //  ZMIANA KONTROLLERA
$router->get('logout', 'LoginController@logout');
$router->post('loginValidation', 'LoginController@loginValidation');

/* CompanyController */
$router->get('companies', 'CompanyController@show');
$router->get('addcompany', 'CompanyController@addCompany');                           //  ZMIANA KONTROLLERA
$router->get('companysettings', 'CompanyController@companiesSettings');               //  ZMIANA KONTROLLERA
$router->post('addcompany', 'CompanyController@add');
$router->post('companysettings', 'CompanyController@settings');

/* CustomersController */
$router->get('kontakty', 'CustomersController@show');
$router->get('addcustomer', 'CustomersController@addCustomer');                         //  ZMIANA KONTROLLERA
$router->get('customersettings', 'CustomersController@customersSettings');              //  ZMIANA KONTROLLERA
$router->post('addcustomer', 'CustomersController@add');
$router->post('customersettings', 'CustomersController@settings');


/* !! QuestionController i AnswersController mozna zamienic na jeden kontroler ankiety */
/* QuestionsController */
$router->get('questions', 'QuestionsController@show');
$router->get('addquestion', 'QuestionsController@addForm');
$router->post('questionForm', 'QuestionsController@add');

/* AnswersController */
$router->get('wynikankiety', 'AnswersController@show');