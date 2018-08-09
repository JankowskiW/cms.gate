<?php require(dirname(__DIR__) . '/layouts/head.php');  ?>
<?php require(dirname(__DIR__) . '/layouts/nav.php'); ?>
<h1>FIRMY</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Nazwa firmy</th>
        <th></th>
        <th>Data utworzenia</th>
    </tr>
        <tr>
            <form>
                <td>

                </td>
                <td colspan="2">
                    <div class="form-group">
                         <input id="company_name" type="text" name="company_name">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        OD: <input id="date_from" type="date" name="date_from" placeholder="data od"><br/>
                        DO: <input id="date_to" type="date" name="date_to" placeholder="data do">
                    </div>
                </td>
            </form>
        </tr>
    <?php $counter = 0; ?>
    <?php foreach($companies as $company) : ?>
        <?php $counter++; ?>
        <form>
            <tr>
                <td><input type="checkbox" name="companyCustomerId<?= $company->companyId ?>"><?= $counter ?></td>
                <td>
                    <a href="companysettings?companyId=<?= $company->companyId ?>">
                        <?= $company->nazwa_firmy ?>
                    </a>
                </td>
                <td><a href="kontakty?companyId=<?= $company->companyId ?>">(kontakty)</a></td>
                <td><?= $company->data_utworzenia ?></td>
            </tr>
        </form>
    <?php endforeach; ?>
</table>
<?php require(dirname(__DIR__) . '/layouts/footer.php'); ?>