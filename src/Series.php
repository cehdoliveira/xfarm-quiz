<?php

class Series
{
    const HOUSE_OF_CARDS = 'A';
    const GAME_OF_THRONES = 'B';
    const LOST = 'C';
    const BREAKING_BAD = 'D';
    const SILICON_VALLEY = 'E';

    private static $messages = [
        self::HOUSE_OF_CARDS => 'Você é House of Cards: ataca o problema com método e faz de tudo para resolver a situação.',
        self::GAME_OF_THRONES => 'Você é Game of Thrones: não tem muita delicadeza nas ações, mas resolve o problema de forma prática.',
        self::LOST => 'Você é Lost: faz as coisas sem ter total certeza se é o caminho certo ou se faz sentido, mas no final dá tudo certo.',
        self::BREAKING_BAD => 'Você é Breaking Bad: pra fazer acontecer você toma a liderança, mas sempre contando com seus parceiros.',
        self::SILICON_VALLEY => 'Você é Silicon Valley: vive a tecnologia o tempo todo e faz disso um mantra para cada situação no dia.'
    ];

    private static $names = [
        self::HOUSE_OF_CARDS => 'House of Cards',
        self::GAME_OF_THRONES => 'Game of Thrones',
        self::LOST => 'Lost',
        self::BREAKING_BAD => 'Breaking Bad',
        self::SILICON_VALLEY => 'Silicon Valley'
    ];

    public static function getMessage($seriesCode)
    {
        return self::$messages[$seriesCode] ?? '';
    }

    public static function getName($seriesCode)
    {
        return self::$names[$seriesCode] ?? '';
    }

    public static function getAll()
    {
        return [
            self::HOUSE_OF_CARDS,
            self::GAME_OF_THRONES,
            self::LOST,
            self::BREAKING_BAD,
            self::SILICON_VALLEY
        ];
    }
}
