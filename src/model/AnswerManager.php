<?php
require_once 'DatabaseManager.php';


class AnswerManager extends DatabaseManager
{
    public function getAnswers()
    {
        $req = $this->database->query('SELECT * FROM answer');
        $answers = array();
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $questionManager = new QuestionManager;
            $question = $questionManager->getQuestionById($row['question_id']);
            $answer = new Answer($row['id'], $question, $row['answer'], $row['score']);
            $answers[] = $answer;
        }
        return $answers;
    }
    public function getAnswerById(int $id)
    {
        $req = $this->database->prepare('SELECT * FROM answer WHERE id = :id');
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        if ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $questionManager = new QuestionManager;
            $question = $questionManager->getQuestionById($row['question_id']);
            $answer = new Answer($row['id'], $question, $row['answer'], $row['score']);
            return $answer;
        }
    }
}
