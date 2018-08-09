<?php require(dirname(__DIR__) . '/layouts/head.php');  ?>
<?php require(dirname(__DIR__) . '/layouts/nav.php'); ?>
    <h1>PYTANIA</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Kategoria</th>
            <th>Tresc pytania</th>
            <th>Status</th>
        </tr>
        <tr>
            <form>
                <td>

                </td>
                <td>
                    <div class="form-group">
                        <input id="category" type="text" name="category">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input id="body" type="text" name="body">
                    </div>
                </td>
                <td>

                </td>
            </form>
        </tr>
        <?php $counter = 0; ?>
        <?php foreach($questions as $question) : ?>
            <?php $counter++; ?>
            <form>
                <tr>
                    <td><input type="checkbox" name="questionId<?= $question->id ?>"><?= $counter ?></td>
                    <td>
                        <a href="questions?categoryId=<?= $question->id_kategorii ?>">
                            <?= $question->kategoria ?>
                        </a>
                    </td>
                    <td>
                        <a href="ankieta?questionId=<?= $question->id ?>">
                            <?= $question->tresc ?>
                        </a>
                    </td>
                    <td>
                        <?= $question->status?"wlaczone":"wylaczone" ?>
                    </td>
                </tr>
            </form>
        <?php endforeach; ?>
    </table>
<?php require(dirname(__DIR__) . '/layouts/footer.php'); ?>