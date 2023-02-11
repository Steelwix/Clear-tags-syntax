<?php
require_once 'DatabaseManager.php';


class AnswerManager extends DatabaseManager
{
    public function getAnswers()
    {
        $req = $this->database->query('SELECT * FROM answer');
        return $req;
    }
}
