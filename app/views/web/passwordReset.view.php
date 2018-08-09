<?php require(dirname(__DIR__) . '/layouts/head.php'); ?>
<?php require(dirname(__DIR__) . '/layouts/nav.php'); ?>
    <div>
        <form method="POST" action="/resetpassword" class="form-control">
            <div class="form-group">
                <label id="email">Podaj twój adres e-mail</label>
                <input id="email" type="email" name="email" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Wyślij prośbę" name="reset">
                <!--                <button type="submit" name="register"> Rejestruj </button>-->
            </div>
        </form>
    </div>


<?php require(dirname(__DIR__) . '/layouts/footer.php'); ?>