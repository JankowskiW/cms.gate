
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="/public/css/style.css">

</head>
<body>
<div id="page">


    <?php if(isset($_SESSION['userId'])): ?>
    <h5> Jesteś zalogowany jako
        <?= $_SESSION['userEmail'] ?>
    </h5>
    <?php endif; ?>

<?php require(dirname(__DIR__) . '/layouts/info.php'); ?>