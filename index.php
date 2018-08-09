<?php

session_start();

require 'vendor/autoload.php';
require 'core/bootstrap.php';

use App\Core\Router;
use App\Core\Request;
use App\Core\Post;

$router = Router::load('app/routes.php');

$router->direct(Request::uri(), Request::method());