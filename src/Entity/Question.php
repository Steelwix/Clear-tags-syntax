<?php

class Question
{
    private ?int $id = null;

    private ?int $number = null;

    private ?string $title = null;

    private ?string $question = null;

    public function __construct($id, $number, $title, $question)
    {
        $this->id = $id;
        $this->number = $number;
        $this->title = $title;
        $this->question = $question;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNumber(): ?int
    {
        return $this->number;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getQuestion(): ?string
    {
        return $this->question;
    }


    public function setnumber(string $number): self
    {
        $this->number = $number;
        return $this;
    }
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
    public function setQuestion(string $question): self
    {
        $this->question = $question;
        return $this;
    }
}
