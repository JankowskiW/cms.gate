<?php require(dirname(__DIR__) . '/layouts/head.php');  ?>
<?php require(dirname(__DIR__) . '/layouts/nav.php'); ?>

<?php  if(isset($_SESSION['userType']) && $_SESSION['userType'] == 1) :?>
    <h1>HANDLOWCY</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>E-mail</th>
            <th>Imie i nazwisko</th>
            <th>Telefon</th>
            <th>Data dodania</th>
            <th>Grupa</th>
            <th>Status</th>
        </tr>
        <tr>
            <form>
                <td>

                </td>
                <td>
                    <div class="form-group">
                        <input id="email" type="text" name="email">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input id="name" type="text" name="name">
                    </div>
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
        <?php foreach($users as $user) : ?>
            <?php $counter++; ?>
            <form>
                <tr>
                    <td><input type="checkbox" name="customerId<?= $user->ID ?>"><?= $counter ?></td>
                    <td><?= $user->email ?></td>
                    <td>
                        <a href="tradersettings?userId=<?= $user->ID ?>">
                            <?= $user->imie_i_nazwisko ?>
                        </a>
                    </td>
                    <td><?= $user->numer_telefonu ?></td>
                    <td><?= $user->data_dodania ?></td>
                    <td><?= $user->grupa ?></td>
                    <td>
                        <?php if($user->status) : ?>
                            <img src="/../../public/images/positive.png">
                        <?php else : ?>
                            <img src="/../../public/images/negative.png">
                        <?php endif ?>
                    </td>
                </tr>
            </form>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <h1>Nie masz uprawnien do przegladania tej strony.</h1>
<?php  endif; ?>
<?php require(dirname(__DIR__) . '/layouts/footer.php'); ?>