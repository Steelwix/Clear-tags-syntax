<?php
require_once 'DatabaseManager.php';


class QuestionManager extends DatabaseManager
{
    public function getQuestions()
    {
        $req = $this->database->query('SELECT * FROM question');
        return $req;
    }
}
