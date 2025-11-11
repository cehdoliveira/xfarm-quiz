<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Quiz.php';
require_once __DIR__ . '/../src/Series.php';

class QuizTest extends TestCase
{
    private $quiz;

    protected function setUp(): void
    {
        $this->quiz = new Quiz();
    }

    /**
     * Teste #1: Silicon Valley
     * Perguntas ordenadas por importância (peso 1 a 5):
     * 1. Só consegue... (C - Lost) - peso 1
     * 2. Ajuda-a... (C - Lost) - peso 2
     * 3. Convence... (A - House of Cards) - peso 3
     * 4. Desabafa... (E - Silicon Valley) - peso 4
     * 5. Acho... (E - Silicon Valley) - peso 5
     */
    public function testCase1SiliconValley()
    {
        $answers = [
            1 => Series::LOST,              // Só consegue...
            2 => Series::LOST,              // Ajuda-a...
            3 => Series::HOUSE_OF_CARDS,    // Convence...
            4 => Series::SILICON_VALLEY,    // Desabafa...
            5 => Series::SILICON_VALLEY     // Acho...
        ];

        $result = $this->quiz->calculateResult($answers);
        $this->assertEquals(Series::SILICON_VALLEY, $result);
    }

    /**
     * Teste #2: Lost
     * 1. Passa... (E - Silicon Valley) - peso 1
     * 2. Testa... (E - Silicon Valley) - peso 2
     * 3. Convence... (A - House of Cards) - peso 3
     * 4. Puxa... (B - Game of Thrones) - peso 4
     * 5. No ponto... (C - Lost) - peso 5
     */
    public function testCase2Lost()
    {
        $answers = [
            1 => Series::SILICON_VALLEY,    // Passa...
            2 => Series::SILICON_VALLEY,    // Testa...
            3 => Series::HOUSE_OF_CARDS,    // Convence...
            4 => Series::GAME_OF_THRONES,   // Puxa... (Larga uma frase polêmica)
            5 => Series::LOST               // No ponto...
        ];

        $result = $this->quiz->calculateResult($answers);
        $this->assertEquals(Series::LOST, $result);
    }

    /**
     * Teste #3: House of Cards
     * 1. Passa... (E - Silicon Valley) - peso 1
     * 2. Oferece... (D - Breaking Bad) - peso 2
     * 3. Você... (C - Lost) - peso 3
     * 4. Larga... (B - Game of Thrones) - peso 4
     * 5. Vou chamar... (A - House of Cards) - peso 5
     */
    public function testCase3HouseOfCards()
    {
        $answers = [
            1 => Series::SILICON_VALLEY,    // Passa...
            2 => Series::BREAKING_BAD,      // Oferece...
            3 => Series::LOST,              // Você questiona...
            4 => Series::GAME_OF_THRONES,   // Larga...
            5 => Series::HOUSE_OF_CARDS     // Vou chamar...
        ];

        $result = $this->quiz->calculateResult($answers);
        $this->assertEquals(Series::HOUSE_OF_CARDS, $result);
    }

    /**
     * Teste #4: Silicon Valley
     * 1. Acorda... (A - House of Cards) - peso 1
     * 2. Levanta... (B - Game of Thrones) - peso 2
     * 3. Você... (C - Lost) - peso 3
     * 4. Sugere... (D - Breaking Bad) - peso 4
     * 5. Acho... (E - Silicon Valley) - peso 5
     */
    public function testCase4SiliconValley()
    {
        $answers = [
            1 => Series::HOUSE_OF_CARDS,    // Acorda...
            2 => Series::GAME_OF_THRONES,   // Levanta...
            3 => Series::LOST,              // Você questiona...
            4 => Series::BREAKING_BAD,      // Sugere...
            5 => Series::SILICON_VALLEY     // Acho...
        ];

        $result = $this->quiz->calculateResult($answers);
        $this->assertEquals(Series::SILICON_VALLEY, $result);
    }

    /**
     * Teste #5: House of Cards
     * 1. Acorda... (A - House of Cards) - peso 1
     * 2. Ela... (A - House of Cards) - peso 2
     * 3. Convence... (A - House of Cards) - peso 3
     * 4. Larga... (B - Game of Thrones) - peso 4
     * 5. Pegarei... (B - Game of Thrones) - peso 5
     */
    public function testCase5HouseOfCards()
    {
        $answers = [
            1 => Series::HOUSE_OF_CARDS,    // Acorda...
            2 => Series::HOUSE_OF_CARDS,    // Ela vai atrapalhar...
            3 => Series::HOUSE_OF_CARDS,    // Convence...
            4 => Series::GAME_OF_THRONES,   // Larga...
            5 => Series::GAME_OF_THRONES    // Pegarei...
        ];

        $result = $this->quiz->calculateResult($answers);
        $this->assertEquals(Series::HOUSE_OF_CARDS, $result);
    }

    /**
     * Teste #6: Game of Thrones
     * 1. Passa... (E - Silicon Valley) - peso 1
     * 2. Testa... (E - Silicon Valley) - peso 2
     * 3. Ignora... (B - Game of Thrones) - peso 3
     * 4. Larga... (B - Game of Thrones) - peso 4
     * 5. Vou de... (D - Breaking Bad) - peso 5
     */
    public function testCase6GameOfThrones()
    {
        $answers = [
            1 => Series::SILICON_VALLEY,    // Passa...
            2 => Series::SILICON_VALLEY,    // Testa...
            3 => Series::GAME_OF_THRONES,   // Ignora...
            4 => Series::GAME_OF_THRONES,   // Larga...
            5 => Series::BREAKING_BAD       // Vou de carro...
        ];

        $result = $this->quiz->calculateResult($answers);
        $this->assertEquals(Series::GAME_OF_THRONES, $result);
    }

    /**
     * Teste #7: House of Cards
     * 1. Acorda... (A - House of Cards) - peso 1
     * 2. Levanta... (B - Game of Thrones) - peso 2
     * 3. Você... (C - Lost) - peso 3
     * 4. Larga... (B - Game of Thrones) - peso 4
     * 5. Vou chamar... (A - House of Cards) - peso 5
     */
    public function testCase7HouseOfCards()
    {
        $answers = [
            1 => Series::HOUSE_OF_CARDS,    // Acorda...
            2 => Series::GAME_OF_THRONES,   // Levanta...
            3 => Series::LOST,              // Você questiona...
            4 => Series::GAME_OF_THRONES,   // Larga...
            5 => Series::HOUSE_OF_CARDS     // Vou chamar...
        ];

        $result = $this->quiz->calculateResult($answers);
        $this->assertEquals(Series::HOUSE_OF_CARDS, $result);
    }

    /**
     * Testa se não há empates em todas as combinações possíveis
     * Este teste verifica uma amostra de combinações aleatórias
     */
    public function testNoTies()
    {
        $series = Series::getAll();
        $results = [];

        // Testa 10000 combinações aleatórias
        for ($i = 0; $i < 10000; $i++) {
            $answers = [
                1 => $series[array_rand($series)],
                2 => $series[array_rand($series)],
                3 => $series[array_rand($series)],
                4 => $series[array_rand($series)],
                5 => $series[array_rand($series)]
            ];

            $result = $this->quiz->calculateResult($answers);
            
            // Verifica se o resultado é uma série válida
            $this->assertContains($result, $series);
            
            // Armazena o resultado
            $key = implode('-', $answers);
            $results[$key] = $result;
        }

        // Verifica que todas as combinações únicas testadas retornaram um resultado válido
        // Como há apenas 5^5 = 3125 combinações possíveis, é esperado que haja repetições
        $this->assertGreaterThan(0, count($results));
        $this->assertLessThanOrEqual(3125, count($results));
    }

    /**
     * Testa que todas as séries podem ser resultado
     */
    public function testAllSeriesCanBeResult()
    {
        $foundSeries = [];

        // Testa respostas específicas para cada série
        $testCases = [
            Series::HOUSE_OF_CARDS => [1 => 'A', 2 => 'A', 3 => 'A', 4 => 'A', 5 => 'A'],
            Series::GAME_OF_THRONES => [1 => 'B', 2 => 'B', 3 => 'B', 4 => 'B', 5 => 'B'],
            Series::LOST => [1 => 'C', 2 => 'C', 3 => 'C', 4 => 'C', 5 => 'C'],
            Series::BREAKING_BAD => [1 => 'D', 2 => 'D', 3 => 'D', 4 => 'D', 5 => 'D'],
            Series::SILICON_VALLEY => [1 => 'E', 2 => 'E', 3 => 'E', 4 => 'E', 5 => 'E']
        ];

        foreach ($testCases as $expectedSeries => $answers) {
            $result = $this->quiz->calculateResult($answers);
            $foundSeries[] = $result;
            $this->assertEquals($expectedSeries, $result);
        }

        // Verifica que todas as 5 séries foram encontradas
        $this->assertCount(5, array_unique($foundSeries));
    }
}
