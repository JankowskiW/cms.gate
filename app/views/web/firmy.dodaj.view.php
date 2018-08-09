<?php require(dirname(__DIR__) . '/layouts/head.php');  ?>
<?php require(dirname(__DIR__) . '/layouts/nav.php'); ?>
    <h1> DANE FIRMY / FIRMY -> USTAWIENIA </h1>
    <div id = "form-bg">
        <form method="POST" action="/addcompany"  class="form-control">
            <div class="form-group">
                <label id="name">Nazwa firmy</label>
                <input id="name" type="text" name="name">
            </div>

            <div class="form-group">
                <label id="address">Adres</label>
                <input id="address" type="text" name="address">
            </div>

            <div class="form-group">
                <label id="street">Ulica</label>
                <input id="street" type="text" name="street">
            </div>

            <div class="form-group">
                <label id="city">Miejscowosc</label>
                <input id="city" type="text" name="city">
            </div>

            <div class="form-group">
                <label id="country">Kraj</label>
                <input id="country" type="text" name="country">
            </div>

            <div class="form-group">
                <label id="nip">NIP</label>
                <input id="nip" type="text" name="nip">
            </div>

            <div class="form-group">
                <label id="email">Adres e-mail</label>
                <input id="email" type="email" name="email">
            </div>
            <hr>

            <div class="form-group">
                <input type="checkbox" name="dane_osobowe">
                Zgoda na przetwarzanie danych osobowych<br/>
                <input type="checkbox" name="materialy_reklamowe">
                Zgoda na otrzymywanie materiałów reklamowych
            </div>

            <div class="form-group">
                <input type="submit" value="Anuluj" name="cancel">
                <input type="submit" value="Dodaj" name="add">
            </div>
        </form>
    </div>
<?php require(dirname(__DIR__) . '/layouts/footer.php'); ?>