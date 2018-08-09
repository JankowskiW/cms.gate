<?php require(dirname(__DIR__) . '/layouts/head.php'); ?>
<?php require(dirname(__DIR__) . '/layouts/nav.php'); ?>
    <h1>ODPOWIEDZI ANKIETY</h1>
    <h2><?= $customer->imie_i_nazwisko ?></h2>
    <span style="font-size: 25px">
        JEŚLI ŹLE SĄ WYSWIETLANE ODPOWIEDZI NA OSTATNIE PYTANIE, <br/>
        TO ZNACZY ŻE UŻYTKOWNIK BYŁ WPROWADZANY DO BAZY PRZED POPRAWKAMI KODU. <br/>
        JEŚLI WYBIERZESZ JEDNEGO Z OSTATNICH UŻYTKOWNIKÓW, ALBO DODASZ NOWEGO, <br/>
        TO WSZYSTKO BĘDIE DZIAŁAĆ JAK NALEŻY.
    </span>
    <br/><br/>

    <form class="form-control">
        <?php $indexQue = 0; ?>
        <?php foreach ($questions as $question) : $indexQue++ ?>
            <hr>
            <h3><?= $question->tresc ?></h3>
            <?php $indexAns = 0;
                  $indexTxtAns = 0;
                $txtans = [];
                foreach($answerstxt as $ans)
                {
                    if($ans->id_pytania == $question->id)
                    {
                        $txtans[] = $ans->tresc;
                    }
                }
            ?>
            <?php foreach ($allanswers as $answer) : $indexAns++; ?>
                <?php if ($answer->id_pytania == $question->id) :

                        $exists = false;
                        $txtid = 0;
                        foreach($answers as $ans)
                        {
                            if ($answer->id == $ans->id)
                            { $exists = true;}
                        }
                        ?>

                    <div id="form-group">
                        <label id="answers"><?= $answer->tresc ?></label>
                        <?php if ($question->typ_odpowiedzi == "radio") : ?>
                            <input type="<?= $question->typ_odpowiedzi ?>"
                                   name="answers[<?= $indexQue ?>]" value="<?= $answer->id ?>" disabled
                                    <?= $exists?"checked":"" ?>><br/>
                        <?php elseif ($question->typ_odpowiedzi == "checkbox") : ?>
                            <input type="<?= $question->typ_odpowiedzi ?>"
                                   name="answers[<?= $indexQue ?>][<?= $indexAns ?>]"
                                   value="<?= $answer->id ?>" disabled
                                    <?= $exists?"checked":"" ?>><br/>
                        <?php elseif ($question->typ_odpowiedzi == "textarea") : ?>
                            <textarea name="answersTxt[<?= $indexQue ?>][]"
                                      rows="1" cols="50" disabled>
                                <?= $txtans[$indexTxtAns++]; ?>
                            </textarea><br/>
                        <?php else : ?>
                            <input type="text" name="answersTxt[<?= $indexQue ?>][]" disabled
                             value = "<?= $txtans[$indexTxtAns++]; ?>"><br/>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </form>

<?php require(dirname(__DIR__) . '/layouts/footer.php'); ?>