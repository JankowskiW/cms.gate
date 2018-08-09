<?php require(dirname(__DIR__) . '/layouts/head.php'); ?>
<?php require(dirname(__DIR__) . '/layouts/nav.php'); ?>

    <hr>
    <hr>
    <div>
        <form method="POST" action="/addcustomer" class="form-control" class="form-control">

            <div class="form-group">
                <label id="company">Nazwa firmy</label>
                <select id="company" name="company">
                    <?php foreach ($companies as $company): ?>
                        <option value="<?= $company->id ?>">
                            <?= $company->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <a href="addcompany" type="button">Dodaj firme</a>
            </div>
            <hr>
            <div class="form-group">
                <label id="imie_i_nazwisko">Imię i nazwisko<span style="color: red;">*</span></label>
                <input id="imie_i_nazwisko" type="text" name="imie_i_nazwisko" required>
            </div>

            <div class="form-group">
                <label id="stanowisko">Stanowisko</label>
                <input id="stanowisko" type="text" name="stanowisko">
            </div>

            <div class="form-group">
                <label id="telefon">Numer telefonu<span style="color: red;">*</span></label>
                <input id="telefon" type="text" name="telefon" required>
            </div>

            <div class="form-group">
                <label id="email">Adres E-mail<span style="color: red;">*</span></label>
                <input id="email" type="email" name="email" required>
            </div>

            <div class="form-group">
                <label id="skan">Skan</label>
                <input id="skan" type="button" name="skan" value="Wybierz inne zdjęcie">
            </div>


            <div class="form-group">
                <input type="checkbox" name="dane_osobowe">
                Zgoda na przetwarzanie danych osobowych<br/>
                <input type="checkbox" name="materialy_reklamowe">
                Zgoda na otrzymywanie materiałów reklamowych
            </div>

            <?php if (isset($_SESSION['userType']) && $_SESSION['userType'] == 1) : ?>
                <div class="form-group">
                    <select name="handlowiec">
                        <?php foreach ($traders as $trader): ?>
                            <option value="<?= $trader->ID ?>">
                                <?= $trader->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php else : ?>
                <input type='hidden' name="handlowiec" value="<?= $_SESSION['userId'] ?>">
                <hr>
                <?php $indexQue = 0; ?>
                <?php foreach ($questions as $question) : $indexQue++; ?>
                    <hr>
                    <h3><?= $question->tresc ?></h3>
                    <input type='hidden' name="questionId[<?= $indexQue ?>]" value="<?= $question->id ?>">
                    <?php $indexAns = 0; ?>
                    <?php foreach ($answers as $answer) : $indexAns++; ?>
                        <?php if ($answer->id_pytania == $question->id) : ?>
                            <div id="form-group">
                                <label id="answers"><?= $answer->tresc ?></label>

                                <?php if ($question->typ_odpowiedzi == "radio") : ?>
                                    <input type="<?= $question->typ_odpowiedzi ?>"
                                           name="answers[<?= $indexQue ?>]" value="<?= $answer->id ?>"><br/>
                                <?php elseif ($question->typ_odpowiedzi == "checkbox") : ?>
                                    <input type="<?= $question->typ_odpowiedzi ?>"
                                           name="answers[<?= $indexQue ?>][<?= $indexAns ?>]"
                                           value="<?= $answer->id ?>"><br/>
                                <?php elseif ($question->typ_odpowiedzi == "textarea") : ?>
                                    <textarea name="answersTxt[<?= $question->id //$indexQue ?>][]"
                                              rows="1" cols="50"></textarea><br/>
                                <?php else : ?>
                                    <input type="text" name="answersTxt[<?=  $question->id //$indexQue ?>][]""><br/>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <hr>
            <div class="form-group">
                <input type="submit" value="Anuluj" name="cancel">
                <input type="submit" value="Dodaj" name="add">
            </div>

        </form>
        <hr>
        <span>Uwaga, pola oznaczone <span style="color: red;">*</span> są wymagane.</span>
    </div>

<?php require(dirname(__DIR__) . '/layouts/footer.php'); ?>