<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Que série de TV você é?</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div id="quiz-container">
            <h1>🎬 Que série de TV você é?</h1>
            <p class="subtitle">Descubra qual série melhor representa você!</p>
            
            <!-- Indicador de progresso -->
            <div class="progress-container">
                <div class="progress-bar" id="progress-bar"></div>
                <div class="progress-text" id="progress-text">Pergunta 1 de 5</div>
            </div>
            
            <div class="error-message" id="error-message">
                Por favor, selecione uma resposta antes de continuar.
            </div>

            <?php
            require_once __DIR__ . '/../src/Quiz.php';
            
            $quiz = new Quiz();
            $questions = $quiz->getQuestions();
            ?>

            <form id="quiz-form" method="POST" action="result.php" data-questions="<?php echo count($questions); ?>">
                <?php
                foreach ($questions as $questionIndex => $question):
                    $shuffledAnswers = $question->getShuffledAnswers();
                ?>
                    <div class="question" id="question-<?php echo $questionIndex; ?>" style="display: <?php echo $questionIndex === 0 ? 'block' : 'none'; ?>;">
                        <div class="question-title">
                            <?php echo $question->getId(); ?>. <?php echo htmlspecialchars($question->getText()); ?>
                        </div>
                        <?php foreach ($shuffledAnswers as $index => $answer): ?>
                            <div class="answer">
                                <label>
                                    <input 
                                        type="radio" 
                                        name="q<?php echo $question->getId(); ?>" 
                                        value="<?php echo htmlspecialchars($answer->getSeries()); ?>"
                                        required
                                    >
                                    <span><?php echo htmlspecialchars($answer->getText()); ?></span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

                <div class="navigation-buttons">
                    <button type="button" class="nav-btn prev-btn" id="prev-btn" style="display: none;">← Anterior</button>
                    <button type="button" class="nav-btn next-btn" id="next-btn">Próxima →</button>
                    <button type="submit" class="submit-btn" id="submit-btn" style="display: none;">Ver Resultado</button>
                </div>
            </form>
        </div>

        <div id="result-container" class="result-container">
            <!-- Resultado será exibido aqui via JavaScript -->
        </div>
    </div>

    <script src="assets/js/quiz.js"></script>
</body>
</html>
