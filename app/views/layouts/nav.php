<div id="logo">
    LOGO
</div>
<nav>
    <ul>
        <li><a href = "/"/>Home</a></li>
        <?php if(!isset($_SESSION['userId'])) : ?>
            <li><a href="login">Login</a></li>
            <li><a href="register">Register</a></li>
        <?php else : ?>
            <?php if($_SESSION['userType']==1) : ?>
                <li><a href="traders">Handlowcy</a></li>
            <?php endif; ?>
            <li><a href="companies">Firmy</a></li>
            <li><a href="kontakty">Kontakty</a></li>
            <li><a href="questions">Pytania</a></li>
            <li><a href="addcompany">Dodaj firme</a></li>
            <li><a href="addcustomer">Dodaj kontakt/klienta</a></li>
            <li><a href="addquestion">Dodaj pytanie</a></li>
            <li><a href="logout">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>
