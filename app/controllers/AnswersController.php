<?php
/**
 * Created by PhpStorm.
 * User: waldemar
 * Date: 24.07.18
 * Time: 12:26
 */

namespace App\Controllers;

use App\Core\App;

class AnswersController
{
    public function ankietaForm()
    {
        $question = App::get('database')
            ->table(['pytania'])
            ->select([
                "id",
                "tresc",
                "typ_odpowiedzi"
            ])
            ->where(["id = ".$_GET['questionId']])
            ->fetch()[0];
        $answers = App::get('database')
            ->table(['odpowiedzi'])
            ->select([
                "ID as id",
                "tresc"
            ])
            ->where(["ID_pytania = ".$question->id])
            ->fetch();
        return view('web/odpowiedz', compact('question','answers'));
    }

    public function show()
    {
        $questions = App::get('database')
            ->table(['pytania'])
            ->select([
                "id",
                "tresc",
                "typ_odpowiedzi"
            ])
            ->fetch();
//        var_dump("QUESTIONS = ",$questions);
        $allanswers = App::get('database')
            ->table(['odpowiedzi'])
            ->select([
                "ID as id",
                "ID_pytania as id_pytania",
                "tresc"
            ])
            ->fetch();
//        var_dump("ALL ANSWERS = ",$allanswers);
        $answers = App::get('database')
            ->table(['odpowiedzi'])
            ->select([
                "odpowiedzi.ID as id",
                "odpowiedzi.tresc as tresc",
                "odpowiedzi_klientow.id_pytania as id_pytania"
            ])
            ->leftJoin("odpowiedzi_klientow", "odpowiedzi.ID", "odpowiedzi_klientow.id_odpowiedzi")
            ->where(["odpowiedzi_klientow.id_klienta = ".$_GET['customerId']])
            ->fetch();
//        var_dump("ANSWERS = ",$answers);
        $answerstxt = App::get('database')
            ->table(['odpowiedzi_klientow_txt'])
            ->select([
                "odpowiedzi_klientow_txt.id as id",
                "odpowiedzi_klientow_txt.tresc as tresc",
                "odpowiedzi_klientow_txt.id_pytania as id_pytania"
            ])
            ->where(["odpowiedzi_klientow_txt.id_klienta = ".$_GET['customerId']])
            ->fetch();

        $customer = App::get('database')
            ->table(['klienci'])
            ->select(['imie_i_nazwisko'])
            ->where(['id = '.$_GET['customerId']])
            ->fetch()[0];
//            var_dump("ANSWERSTXT = ",$answerstxt);
        return view('web/kontakty.wynik_ankiety', compact('questions','allanswers','answers','answerstxt', 'customer'));
    }
}