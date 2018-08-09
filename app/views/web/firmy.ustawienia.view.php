<?php require(dirname(__DIR__) . '/layouts/head.php');  ?>
<?php require(dirname(__DIR__) . '/layouts/nav.php'); ?>
    <h1> DANE FIRMY / FIRMY -> USTAWIENIA </h1>
    <div id = "form-bg">
        <form method="POST" action="/companysettings"  class="form-control">
            <input type='hidden' id="companyId" name="companyId" value="<?= $company->id ?>">
            <div class="form-group">
                <label id="name">Nazwa firmy</label>
                <input id="name" type="text" name="name" value="<?= $company->nazwa_firmy ?>">
            </div>

            <div class="form-group">
                <label id="address">Adres</label>
                <input id="address" type="text" name="address" value="<?= $company->adres ?>">
            </div>

            <div class="form-group">
                <label id="street">Ulica</label>
                <input id="street" type="text" name="street" value="<?= $company->ulica ?>">
            </div>

            <div class="form-group">
                <label id="city">Miejscowosc</label>
                <input id="city" type="text" name="city" value="<?= $company->miejscowosc ?>">
            </div>

            <div class="form-group">
                <label id="country">Kraj</label>
                <input id="country" type="text" name="country" value="<?= $company->kraj ?>">
            </div>

            <div class="form-group">
                <label id="nip">NIP</label>
                <input id="nip" type="text" name="nip" value="<?= $company->NIP ?>">
            </div>

            <div class="form-group">
                <label id="email">Adres e-mail</label>
                <input id="email" type="email" name="email" value="<?= $company->email ?>">
            </div>
            <hr>
            <span>Data utworzenia: <?= $company->data_utworzenia ?></span>

            <div class="form-group">
                <input type="checkbox" name="dane_osobowe"
                    <?php echo ($company->przetwarzanie_danych)?"checked":""; ?>>
                Zgoda na przetwarzanie danych osobowych<br/>
                <input type="checkbox" name="materialy_reklamowe"
                    <?php echo ($company->otrzymywanie_materialow)?"checked":""; ?>>
                Zgoda na otrzymywanie materiałów reklamowych
            </div>

            <div class="form-group">
                <input type="submit" value="Anuluj" name="cancel">
                <?php if(isset($company)) : ?>
                    <input type="submit" value="Zapisz zmiany" name="save">
                <?php else : ?>
                    <input type="submit" value="Dodaj" name="add">
                <?php endif; ?>
            </div>
        </form>
    </div>
<?php require(dirname(__DIR__) . '/layouts/footer.php'); ?>