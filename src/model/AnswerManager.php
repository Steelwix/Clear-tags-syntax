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
            $question = $questionManager->getQuestionWithId($row['question_id']);
            $answer = new Answer($row['id'], $question, $row['answer'], $row['score']);
            $answers[] = $answer;
        }
        return $answers;
    }
}
