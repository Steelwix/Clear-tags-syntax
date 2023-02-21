<?php

class Result
{
    private ?int $id = null;

    private ?User $user = null;

    private ?Question $question = null;

    private ?Answer $answer = null;

    public function __construct($id, $user, $question, $answer)
    {
        $this->id = $id;
        $this->user = $user;
        $this->question = $question;
        $this->answer = $answer;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }
    public function getQuestion(): ?Question
    {
        return $this->question;
    }
    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }


    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }
    public function setQuestion(Question $question): self
    {
        $this->question = $question;
        return $this;
    }
    public function setAsnwer(Answer $answer): self
    {
        $this->answer = $answer;
        return $this;
    }
}
