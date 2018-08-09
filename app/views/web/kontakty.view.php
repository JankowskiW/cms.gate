<?php require(dirname(__DIR__) . '/layouts/head.php');  ?>
<?php require(dirname(__DIR__) . '/layouts/nav.php'); ?>
    <h1>KONTAKTY</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Nazwa firmy</th>
            <th>Imie i nazwisko</th>
            <th></th>
            <th>Telefon</th>
            <th>Data rejestracji</th>
            <th>Handlowiec</th>
            <th>Skan</th>  <!-- polaczony / niepolaczony -->
        </tr>
        <tr>
            <form>
                <td>

                </td>
                <td>
                    <div class="form-group">
                        <input id="company_name" type="text" name="company_name">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input id="name" type="text" name="name">
                    </div>
                </td>
                <td>

                </td>
                <td>
                    <div class="form-group">
                        <input id="phone_number" type="text" name="phone_number">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        OD: <input id="date_from" type="date" name="date_from" placeholder="data od"><br/>
                        DO: <input id="date_to" type="date" name="date_to" placeholder="data do">
                    </div>
                </td>
                <td>

                </td>
                <td>

                </td>
            </form>
        </tr>
        <?php $counter = 0; ?>
        <?php foreach($customers as $customer) : ?>
        <?php $counter++; ?>
            <form>
                <tr>
                    <td><input type="checkbox" name="customerId<?= $customer->ID ?>"><?= $counter ?></td>
                    <td><?= $customer->nazwa_firmy ?></td>
                    <td>
                        <a href="customersettings?customerId=<?= $customer->ID ?>">
                            <?= $customer->klient ?>
                        </a>
                    </td>
                    <td><a href="wynikankiety?customerId=<?= $customer->ID ?>">(wynik ankiety)</a></td>
                    <td><?= $customer->numer_telefonu ?></td>
                    <td><?= $customer->data_rejestracji ?></td>
                    <td><?= $customer->handlowiec ?></td>
                    <td>
                        <?php if(strlen($customer->skan)>0) : ?>
                            polaczony
                        <?php else : ?>
                            niepolaczony
                        <?php endif ?>
                    </td>
                </tr>
            </form>
        <?php endforeach; ?>
    </table>

<?php require(dirname(__DIR__) . '/layouts/footer.php'); ?>