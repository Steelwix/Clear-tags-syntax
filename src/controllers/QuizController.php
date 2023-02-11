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
        var_dump($_POST);
    }
    require './templates/quiz.html';
}
