<?php

require_once __DIR__ . '/Question.php';
require_once __DIR__ . '/Answer.php';
require_once __DIR__ . '/Series.php';

class Quiz
{
    private $questions;

    public function __construct()
    {
        $this->questions = $this->initializeQuestions();
    }

    private function initializeQuestions()
    {
        // Pesos: [5, 7, 11, 3, 13] (números primos que garantem não haver empates)
        // Soma Q1-Q3: 23 vs Q4-Q5: 16, garantindo que 3 respostas nas primeiras perguntas
        // superam 2 respostas nas últimas, mas Q5 ainda tem peso significativo
        return [
            new Question(
                1,
                'De manhã, você:',
                [
                    new Answer('Acorda cedo e come frutas cortadas metodicamente.', Series::HOUSE_OF_CARDS),
                    new Answer('Sai da cama com o despertador e se prepara para a batalha da semana.', Series::GAME_OF_THRONES),
                    new Answer('Só consegue lembrar do seu nome depois do café.', Series::LOST),
                    new Answer('Levanta e faz café pra todos da casa.', Series::BREAKING_BAD),
                    new Answer('Passa o café e conserta um erro no HTML.', Series::SILICON_VALLEY)
                ],
                5
            ),
            new Question(
                2,
                'Indo para o trabalho você encontra uma senhora idosa caída na rua.',
                [
                    new Answer('Ela vai atrapalhar seu horário. Oculte o corpo.', Series::HOUSE_OF_CARDS),
                    new Answer('Levanta a senhora e jura protegê-la com sua vida.', Series::GAME_OF_THRONES),
                    new Answer('Ajuda-a, mas questiona sua real identidade.', Series::LOST),
                    new Answer('Oferece para caminharem juntos até um destino em comum.', Series::BREAKING_BAD),
                    new Answer('Testa se ela roda bem no Firefox. Não roda.', Series::SILICON_VALLEY)
                ],
                7
            ),
            new Question(
                3,
                'Chega no prédio e o elevador está cheio.',
                [
                    new Answer('Convence parte das pessoas a esperarem o próximo.', Series::HOUSE_OF_CARDS),
                    new Answer('Ignora as pessoas no elevador e entra de qualquer forma.', Series::GAME_OF_THRONES),
                    new Answer('Você questiona a realidade, as coisas e tudo mais. Sobe de escada.', Series::LOST),
                    new Answer('Com uma leve intimidação passivo-agressiva, encontra um lugar no elevador.', Series::BREAKING_BAD),
                    new Answer('Cria um app que mostra a lotação do elevador. Vende o app e fica milionário.', Series::SILICON_VALLEY)
                ],
                11
            ),
            new Question(
                4,
                'Você chega no trabalho e as convenções sociais te obrigam a puxar assunto.',
                [
                    new Answer('Fala sobre a política, eleições, como tudo é um absurdo.', Series::HOUSE_OF_CARDS),
                    new Answer('Larga uma frase polêmica e vê uma pequena guerra se formar.', Series::GAME_OF_THRONES),
                    new Answer('Puxa um assunto e te lembram que já foi discutido semana passada.', Series::LOST),
                    new Answer('Sugere que os colegas trabalhem na ideia de um novo projeto.', Series::BREAKING_BAD),
                    new Answer('Desabafa sobre como odeia PHP. Todo mundo na sala adora PHP.', Series::SILICON_VALLEY)
                ],
                3
            ),
            new Question(
                5,
                'A pauta pegou o dia todo, mas você está indo para casa.',
                [
                    new Answer('Vou chamar aqui o meu Uber.', Series::HOUSE_OF_CARDS),
                    new Answer('Pegarei o bus junto com o resto do povo.', Series::GAME_OF_THRONES),
                    new Answer('No ponto de ônibus mais uma vez, espero não errar a linha de novo.', Series::LOST),
                    new Answer('Vou de carro, mas ofereço uma carona para os colegas.', Series::BREAKING_BAD),
                    new Answer('Acho que descobri uma forma de fazer aquela senhora rodar no Firefox.', Series::SILICON_VALLEY)
                ],
                13
            )
        ];
    }

    public function getQuestions()
    {
        return $this->questions;
    }

    public function calculateResult(array $answers)
    {
        $scores = [
            Series::HOUSE_OF_CARDS => 0,
            Series::GAME_OF_THRONES => 0,
            Series::LOST => 0,
            Series::BREAKING_BAD => 0,
            Series::SILICON_VALLEY => 0
        ];

        foreach ($this->questions as $question) {
            $questionId = $question->getId();
            if (isset($answers[$questionId])) {
                $selectedSeries = $answers[$questionId];
                $weight = $question->getWeight();
                $scores[$selectedSeries] += $weight;
            }
        }

        // Encontra a série com maior pontuação
        $maxScore = max($scores);
        $winners = array_keys($scores, $maxScore);

        if (count($winners) === 1) {
            return $winners[0];
        }

        // Desempate: verifica pergunta por pergunta da mais importante para a menos importante
        for ($i = count($this->questions) - 1; $i >= 0; $i--) {
            $question = $this->questions[$i];
            $questionId = $question->getId();
            
            if (isset($answers[$questionId])) {
                $selectedSeries = $answers[$questionId];
                if (in_array($selectedSeries, $winners)) {
                    return $selectedSeries;
                }
            }
        }

        // Desempate final: ordem alfabética das séries
        sort($winners);
        return $winners[0];
    }
}
