<?php
require_once 'DatabaseManager.php';


class QuestionManager extends DatabaseManager
{
    public function getQuestions()
    {
        $req = $this->database->query('SELECT * FROM question');
        $questions = array();
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $question = new Question($row['id'], $row['number'], $row['title'], $row['question']);
            $questions[] = $question;
        }
        return $questions;
    }
    public function getQuestionWithId(int $id)
    {
        $req = $this->database->prepare('SELECT * FROM question WHERE id = :id');
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        if ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $question = new Question($row['id'], $row['number'], $row['title'], $row['question']);
            return $question;
        }
    }
}
