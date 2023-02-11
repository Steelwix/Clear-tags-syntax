<?php

function quizController()
{
    $questionManager = new QuestionManager();
    $answerManager = new AnswerManager();
    $questions = $questionManager->getQuestions();
    $rawAnswers = $answerManager->getAnswers();

    foreach ($rawAnswers as $raw) {
        $answers[] = $raw;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $total = 0;
        foreach ($_POST as $score) {
            $total = $total + $score;
        }
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
