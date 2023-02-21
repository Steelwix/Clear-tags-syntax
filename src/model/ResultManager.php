<?php
require_once 'DatabaseManager.php';


class ResultManager extends DatabaseManager
{
    public function createResult(Result $result)
    {
        $req = $this->database->prepare("INSERT INTO result(id, user_id, question_id, answer_id)
        VALUES(NULL, :user, :question, :answer)");
        $req->execute(array(':user' => $result->getUser()->getId(), ':question' => $result->getQuestion()->getId(), ':answer' => $result->getAnswer()->getId()));
        return $req;
    }
    public function removeResultByUser(User $user)
    {
        $req = $this->database->prepare("DELETE FROM result WHERE user_id = :id");
        $req->execute(array(':id' => $user->getId()));
    }
}
