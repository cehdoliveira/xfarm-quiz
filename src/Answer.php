<?php

class Answer
{
    private $text;
    private $series;

    public function __construct($text, $series)
    {
        $this->text = $text;
        $this->series = $series;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getSeries()
    {
        return $this->series;
    }
}
