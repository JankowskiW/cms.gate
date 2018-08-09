<?php require(dirname(__DIR__) . '/layouts/head.php');  ?>
<?php require(dirname(__DIR__) . '/layouts/nav.php'); ?>
<!--    'traders.ID as ID',-->
<!--    'traders.imie_i_nazwisko as name',-->
<!--    'traders.stanowisko as stanowisko',-->
<!--    'traders.numer_telefonu as numer_telefonu',-->
<!--    'users.email as email'-->
    <hr>
    <hr>
    <div>
        <form method="POST" action="/customersettings" class="form-control" class="form-control">

            <div class="form-group">
                <label id="company_name">Nazwa firmy</label>
                <h4><?= $companyName ?></h4>
            </div>
            <hr>
            <input type='hidden' id="customerId" name="customerId" value="<?= $customer->id ?>">
            <div class="form-group">
                <label id="imie_i_nazwisko">Imię i nazwisko<span style="color: red;">*</span></label>
                <input id="imie_i_nazwisko" type="text" name="imie_i_nazwisko" value="<?= $customer->imie_i_nazwisko ?>" required>
            </div>

            <div class="form-group">
                <label id="stanowisko">Stanowisko</label>
                <input id="stanowisko" type="text" name="stanowisko" value="<?= $customer->stanowisko ?>" >
            </div>

            <div class="form-group">
                <label id="telefon">Numer telefonu<span style="color: red;">*</span></label>
                <input id="telefon" type="text" name="telefon" value="<?= $customer->numer_telefonu ?>"  required>
            </div>

            <div class="form-group">
                <label id="email">Adres E-mail<span style="color: red;">*</span></label>
                <input id="email" type="email" name="email" value="<?= $customer->email ?>"  required>
            </div>

            <div class="form-group">
                <label id="skan">Skan</label>
                <input id="skan" type="button" name="skan" value="Wybierz inne zdjęcie">
            </div>


            <div class="form-group">
                <input type="checkbox" name="dane_osobowe"
                    <?php echo ($customer->przetwarzanie_danych)?"checked":""; ?>>
                Zgoda na przetwarzanie danych osobowych<br/>
                <input type="checkbox" name="materialy_reklamowe"
                    <?php echo ($customer->otrzymywanie_materialow)?"checked":""; ?>>
                Zgoda na otrzymywanie materiałów reklamowych
            </div>

            <div class="form-group">
                <select name="handlowiec">
                    <?php foreach ($traders as $trader): ?>
                        <option value="<?= $trader->ID ?>"
                            <?= $trader->ID == $customer->id_handlowca?"selected=1":"" ?>>
                            <?= $trader->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <hr>
            <div class="form-group">
                <input type="submit" value="Anuluj" name="cancel">
                <input type="submit" value="Zapisz zmiany" name="save">
            </div>

        </form>
        <hr>
        <span>Uwaga, pola oznaczone <span style="color: red;">*</span> są wymagane.</span>
    </div>

<?php require(dirname(__DIR__) . '/layouts/footer.php'); ?>