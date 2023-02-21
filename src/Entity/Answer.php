<?php

class Answer
{
    private ?int $id = null;

    private ?Question $question = null;

    private ?string $answer = null;

    private ?int $score = null;

    public function __construct($id, $question, $answer, $score)
    {
        $this->id = $id;
        $this->question = $question;
        $this->answer = $answer;
        $this->score = $score;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getQuestion(): ?Question
    {
        return $this->question;
    }
    public function getAnswer(): ?string
    {
        return $this->answer;
    }
    public function getScore(): ?int
    {
        return $this->score;
    }


    public function setQuestion(Question $question): self
    {
        $this->question = $question;
        return $this;
    }
    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;
        return $this;
    }
    public function setScore(int $score): self
    {
        $this->score = $score;
        return $this;
    }
}
