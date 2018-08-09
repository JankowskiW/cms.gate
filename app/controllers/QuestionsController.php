<?php
/**
 * Created by PhpStorm.
 * User: waldemar
 * Date: 24.07.18
 * Time: 08:38
 */

namespace App\Controllers;

use App\Core\App;

class QuestionsController
{
    public function addForm()
    {   // odsyła do formularza dodawania pytania.
        if (isset($_SESSION['userType']) && $_SESSION['userType'] != 0) {
            $types = App::get('database')
                ->table(['kategoria_pytania'])
                ->select()
                ->fetch();

            return view('web/pytania.szczegoly', compact('types'));
        } else {
            redirect('accessdenied');
        }

    }

    public function add()
    {
        if (isset($_POST['addquestion'])) {
            $tresc = htmlspecialchars($_POST['tresc']);
            $id_kategorii = $_POST['kategoria'];
            $typ_odpowiedzi = $_POST['typ_odpowiedzi'];
            $_POST['status'] = isset($_POST['status']) ? $_POST['status'] : 'enabled';
            $status = $_POST['status'] == "enabled" ? 1 : 0;
            $answers = $_POST['answer'];
            var_dump($_POST);
            var_dump($tresc);
            var_dump($id_kategorii);
            var_dump($typ_odpowiedzi);
            var_dump($status);
            App::get('database')
                ->table(['pytania'])
                ->insert([
                    'tresc' => $tresc,
                    'id_kategorii' => $id_kategorii,
                    'typ_odpowiedzi' => $typ_odpowiedzi,
                    'status' => $status
                ]);
            $id_pytania = App::get('database')
                ->select(['pytania'])
                ->select(['id'])
                ->where(["tresc = '" . $tresc . "'"])
                ->fetchColumn()[0];
            foreach ($answers as $answer) {
                App::get('database')
                    ->table(['odpowiedzi'])
                    ->insert([
                        "ID_pytania" => $id_pytania,
                        "tresc" => htmlspecialchars($answer)
                    ]);
            }
            redirect('questions');
        } else {
            redirect('addquestion');
        }

    }

    public function show()
    {

        if (isset($_SESSION['userType']) && $_SESSION['userType'] != 0) {
            $questions = App::get('database')
                ->table(['pytania'])
                ->select([
                    "pytania.id as id",
                    "pytania.id_kategorii as id_kategorii",
                    "kategoria_pytania.nazwa_kategorii as kategoria",
                    "pytania.tresc as tresc",
                    "pytania.status as status"
                ])
                ->leftJoin("kategoria_pytania", "pytania.id_kategorii", "kategoria_pytania.id");
            if (isset($_GET['categoryId'])) {
                $questions = $questions->where(["pytania.id_kategorii = " . $_GET['categoryId']]);
            }
            $questions = $questions->fetch();
            $counter = 0;
            foreach ($questions as $question) {
                $questions[$counter]->tresc = substr($question->tresc, 0, 50);
                $counter++;
            }
            return view('web/pytania', compact('questions'));
        } else {
            redirect('accessdenied');
        }
    }
}