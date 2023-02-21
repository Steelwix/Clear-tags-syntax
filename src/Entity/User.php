<?php

class User
{
    private ?int $id = null;

    private ?string $username = null;

    private ?string $password = null;

    private ?string $roles = "ROLE_USER";

    private ?int $bestScore = null;

    private ?int $lastScore = null;
    public function __construct($id, $username, $password, $roles, $bestScore, $lastScore)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->roles = $roles;
        $this->bestScore = $bestScore;
        $this->lastScore = $lastScore;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function getRoles(): ?string
    {
        return $this->roles;
    }
    public function getBestScore(): ?int
    {
        return $this->bestScore;
    }
    public function getLastScore(): ?int
    {
        return $this->lastScore;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    public function setRoles(string $roles): self
    {
        $this->roles = $roles;
        return $this;
    }
    public function setBestScore(int $bestScore): self
    {
        $this->bestScore = $bestScore;
        return $this;
    }
    public function setLastScore(int $lastScore): self
    {
        $this->lastScore = $lastScore;
        return $this;
    }
}
