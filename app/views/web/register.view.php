<?php require(dirname(__DIR__) . '/layouts/head.php'); ?>
<?php require(dirname(__DIR__) . '/layouts/nav.php'); ?>
    <div>
        <form method="POST" action="/registerValidation" class="form-control">

            <div class="form-group">
                <label id="email">Adres e-mail</label>
                <input id="email" type="email" name="email" required>
            </div>

            <div class="form-group">
                <label id="password">Hasło</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div class="form-group">
                <label id="password_confirm">Powtórz hasło</label>
                <input id="password_confirm" type="password" name="password_confirm" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Rejestruj" name="register">
                <!--                <button type="submit" name="register"> Rejestruj </button>-->
            </div>
        </form>
    </div>


<?php require(dirname(__DIR__) . '/layouts/footer.php'); ?>