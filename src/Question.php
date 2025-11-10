<?php

require_once __DIR__ . '/Answer.php';

class Question
{
    private $id;
    private $text;
    private $answers;
    private $weight;

    public function __construct($id, $text, array $answers, $weight)
    {
        $this->id = $id;
        $this->text = $text;
        $this->answers = $answers;
        $this->weight = $weight;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getAnswers()
    {
        return $this->answers;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getShuffledAnswers()
    {
        $shuffled = $this->answers;
        shuffle($shuffled);
        return $shuffled;
    }
}
