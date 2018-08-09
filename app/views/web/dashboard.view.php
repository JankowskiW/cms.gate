<?php require(dirname(__DIR__) . '/layouts/head.php');  ?>
<?php require(dirname(__DIR__) . '/layouts/nav.php'); ?>
    <H1>Dashboard</H1>
    <div class="dashboard" style="border-style: solid; margin: 10px 0 0 10px; padding: 10px;">
        <h4>Nowych klientów ostatnie <?= $daysCustomers ?> dni</h4>
        <h1>
            <?= $numOfCustomers ?>
        </h1>
    </div>
    <div class="dashboard" style="border-style: solid; margin: 10px 0 0 10px; padding: 10px;">
        <h4>Nowych firm ostatnie <?= $daysCompanies ?> dni</h4>
        <h1>
            <?= $numOfCompanies ?>
        </h1>
    </div>

    <div class="dashboard" style="border-style: solid; margin: 10px 0 0 10px; padding: 10px;">

        <div id="chartContainer" style="height: 370px; width: 100%;">
        </div>
    </div>
<?php require(dirname(__DIR__) . '/layouts/footer.php'); ?>