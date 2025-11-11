<?php

require_once __DIR__ . '/../src/Quiz.php';

// Verifica se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Coleta as respostas
$answers = [];
for ($i = 1; $i <= 5; $i++) {
    if (isset($_POST['q' . $i])) {
        $answers[$i] = $_POST['q' . $i];
    }
}

// Valida se todas as perguntas foram respondidas
if (count($answers) < 5) {
    header('Location: index.php');
    exit;
}

// Calcula o resultado
$quiz = new Quiz();
$resultSeries = $quiz->calculateResult($answers);
$resultMessage = Series::getMessage($resultSeries);
$seriesName = Series::getName($resultSeries);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Quiz</title>
    <link rel="stylesheet" href="assets/css/result.css">
</head>
<body>
    <div class="container">
        <div class="emoji">🎬</div>
        <h1>Seu Resultado</h1>
        <div class="series-name"><?php echo htmlspecialchars($seriesName); ?></div>
        <div class="result-message">
            <?php echo htmlspecialchars($resultMessage); ?>
        </div>
        <div class="buttons">
            <a href="index.php" class="btn btn-primary">Fazer o Quiz Novamente</a>
            <button onclick="window.print()" class="btn btn-secondary">Imprimir Resultado</button>
        </div>
    </div>
</body>
</html>
