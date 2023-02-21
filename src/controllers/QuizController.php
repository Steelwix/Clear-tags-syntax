<?php

function quizController()
{
    $questionManager = new QuestionManager();
    $answerManager = new AnswerManager();
    $resultManager = new ResultManager;
    $userManager = new UserManager;
    $questions = $questionManager->getQuestions();
    $answers = $answerManager->getAnswers();



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = $userManager->getUser();
        $resultManager->removeResultByUser($user);
        $total = 0;
        foreach ($_POST as $key => $value) {
            $question = $questionManager->getQuestionById($key);
            $answer = $answerManager->getAnswerById($value);

            $result = new Result(null, $user, $question, $answer);
            $resultManager->createResult($result);
            $total = $total + $answer->getScore();
        }
        if ($user->getBestScore() < $total) {
            $user->setBestScore($total);
        }
        $user->setLastScore($total);
        $_SESSION['total'] = $total;
        header("Location: /result");
        exit();
    }
    require './templates/quiz.html';
}
function resultController()
{
    if (isset($_SESSION['total'])) {
        $total = $_SESSION['total'];
        var_dump($total);
    }
    require './templates/result.html';
}
