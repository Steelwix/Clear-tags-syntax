<?php
require_once 'DatabaseManager.php';


class ResultManager extends DatabaseManager
{
    public function setResult(User $user, Question $question, Answer $answer)
    {
        $req = $this->database->prepare("INSERT INTO result(id, user_id, question_id, answer_id)
        VALUES(NULL, :user, :question, :answer)");
        $req->execute(array(':user' => $user->getId(), ':question' => $question->getId(), ':answer' => $answer->getId()));
        return $req;
    }
}
