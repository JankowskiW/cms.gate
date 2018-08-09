<?php require(dirname(__DIR__).'/layouts/head.php');  ?>
<?php require(dirname(__DIR__).'/layouts/nav.php'); ?>

<h1> LOGIN </h1>
    <div id = "form-bg">
        <div id="logo">
            LOGO
        </div>
        <form method="POST" action="/loginValidation" class="form-control">

            <div class="form-group">
                <label id="email">Adres e-mail</label>
                <input id="email" type="email" name="email" required>
            </div>

            <div class="form-group">
                <label id="password">Hasło</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Zaloguj" name="login">
                <!--                <button type="submit" name="login"> Zaloguj </button>-->
            </div>
        </form>
    </div><br/>
    <div id="buttons">
        <a href="passwordreset">Zapomniałem hasła</a><br/>
        <span>Nie masz jeszcze konta?</span><br/>
        <a href="register">Załóż konto</a>
    </div>
<?php require(dirname(__DIR__).'/layouts/footer.php'); ?>