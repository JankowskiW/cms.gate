<?php require(dirname(__DIR__) . '/layouts/head.php');  ?>
<?php require(dirname(__DIR__) . '/layouts/nav.php'); ?>

    <div>
        <form method="POST" action="/tradersettings"  class="form-control">

            <div class="form-group">
                <label id="user_type">Typ użytkownika</label>
                <select id="user_type" name="user_type">
                    <?php foreach($types as $type) : ?>
                        <option value="<?= $type->id ?>"
                        <?= ($trader->ID_user_type == $type->id)?"selected=1":"" ?>>
                            <?= $type->type_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <hr>

            <input type='hidden' id="traderId" name="traderId" value="<?= $trader->id ?>">

            <div class="form-group">
                <label id="email">Adres e-mail</label>
                <input id="email" type="email" name="email" value="<?= $trader->email ?>">
            </div>

            <div class="form-group">
                <label id="password">Hasło</label>
                <input id="password" type="password" name="password">
            </div>

            <div class="form-group">
                <label id="password_confirm">Powtórz hasło</label>
                <input id="password_confirm" type="password" name="password_confirm">
            </div>

            <div class="form-group">
                <label id="imie_nazwisko">Imie i nazwisko</label>
                <input id="imie_nazwisko" type="text" name="imie_nazwisko" value="<?= $trader->imie_i_nazwisko ?>">
            </div>

            <div class="form-group">
                <label id="stanowisko">Stanowisko</label>
                <input id="stanowisko" type="text" name="stanowisko" value="<?= $trader->stanowisko ?>">
            </div>

            <div class="form-group">
                <label id="kontakt">Kontakt</label>
                <input id="kontakt" type="text" name="kontakt" value="<?= $trader->numer_telefonu ?>">
            </div>

            <div class="form-group">
                <label id="api_login">API login</label>
                <input id="api_login" type="text" name="api_login" value="<?= $trader->API_login ?>">
            </div>
            <div class="form-group">
                <input type="submit" value="Anuluj" name="cancel">
                <input type="submit" value="Zapisz zmiany" name="save">
            </div>
        </form>
    </div>
<?php require(dirname(__DIR__) . '/layouts/footer.php'); ?>