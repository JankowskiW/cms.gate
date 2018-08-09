<?php require(dirname(__DIR__) . '/layouts/head.php'); ?>
<?php require(dirname(__DIR__) . '/layouts/nav.php'); ?>
<script>

    var index = 0;
    function addTextbox()
    {
        index++;
        var br = document.createElement('br');
        document.getElementById('answers').appendChild(br);
        var textbox = document.createElement('input');
        textbox.type = 'text';
        textbox.name = 'answer['+index+']';
        textbox.placeholder = 'Tresc odpowiedzi';
        textbox.required = true;
        textbox.style = "margin: 5px; width: 500px;";
        document.getElementById('answers').appendChild(textbox);

    }
</script>
    <div>
        <form method="POST" action="/questionForm" class="form-control">

            <div class="form-group">
                <label id="tresc">Tresc pytania</label>
                <textarea name="tresc" cols="50" rows="10" required></textarea>
            </div>

            <div class="form-group">
                <label id="kategoria">Kategoria</label>
                <select id="kategoria" name="kategoria">
                    <?php foreach($types as $type) : ?>
                        <option value="<?= $type->id ?>">
                            <?= $type->nazwa_kategorii ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <hr/>
            <div class="form-group">
                <label>Radio buttony</label>
                <input type="radio" name="typ_odpowiedzi" value="radio" checked><br/>
                <label>Checkboxy</label>
                <input type="radio" name="typ_odpowiedzi" value="checkbox"><br/>
                <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] == 1) : ?>
                    <label>Input</label>
                    <input type="radio" name="typ_odpowiedzi" value="input"><br/>
                    <label>Textarea</label>
                    <input type="radio" name="typ_odpowiedzi" value="textarea">
                <?php endif; ?>
            </div>
            <hr/>
            <div class="form-group">
                <button type="button" onclick="addTextbox()">Dodaj odpowiedz</button>
            </div>
            <div class="form-group" id="answers"
            <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] == 1) : ?>
                style="border: solid; text-align: center; padding: 15px;"
             <?php endif; ?>>
                <input type="text" name="answer[0]" placeholder="Tresc odpowiedzi" style="margin: 5px; width: 500px;" required>
            </div>
            <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] == 1) : ?>
                <div class="form-group">
                    <select name="status">
                        <option value="enabled">Wlaczone</option>
                        <option value="disabled">Wylaczone</option>
                    </select>
                </div>
            <?php endif; ?>
            <hr/>
            <div class="form-group">
                <input type="submit" value="Dodaj pytanie" name="addquestion">
                <!--                <button type="submit" name="register"> Rejestruj </button>-->
            </div>
        </form>
    </div>


<?php require(dirname(__DIR__) . '/layouts/footer.php'); ?>