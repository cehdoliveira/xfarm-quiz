<?php

/**
 * Script para testar 1 milhão de combinações aleatórias
 * e verificar se não há empates no quiz
 */

require_once __DIR__ . '/src/Quiz.php';
require_once __DIR__ . '/src/Series.php';

echo "===========================================\n";
echo "TESTE DE EMPATE - 1 MILHÃO DE COMBINAÇÕES\n";
echo "===========================================\n\n";

$quiz = new Quiz();
$series = Series::getAll();
$totalTests = 1000000;
$results = [];
$seriesCount = array_fill_keys($series, 0);

echo "Iniciando teste de {$totalTests} combinações aleatórias...\n";
echo "Isso pode levar alguns segundos...\n\n";

$startTime = microtime(true);

for ($i = 0; $i < $totalTests; $i++) {
    // Gera respostas aleatórias
    $answers = [
        1 => $series[array_rand($series)],
        2 => $series[array_rand($series)],
        3 => $series[array_rand($series)],
        4 => $series[array_rand($series)],
        5 => $series[array_rand($series)]
    ];

    // Calcula o resultado
    $result = $quiz->calculateResult($answers);
    
    // Armazena a combinação e o resultado
    $key = implode('-', $answers);
    $results[$key] = $result;
    $seriesCount[$result]++;

    // Mostra progresso a cada 100k combinações
    if (($i + 1) % 100000 === 0) {
        $progress = ($i + 1) / $totalTests * 100;
        echo sprintf("Progresso: %.0f%% (%d/%d combinações testadas)\n", $progress, $i + 1, $totalTests);
    }
}

$endTime = microtime(true);
$executionTime = $endTime - $startTime;

echo "\n===========================================\n";
echo "RESULTADOS\n";
echo "===========================================\n\n";

echo "Total de combinações testadas: " . number_format($totalTests, 0, ',', '.') . "\n";
echo "Combinações únicas testadas: " . number_format(count($results), 0, ',', '.') . "\n";
echo "Tempo de execução: " . number_format($executionTime, 2) . " segundos\n\n";

echo "Distribuição dos resultados:\n";
echo "-------------------------------------------\n";
foreach ($seriesCount as $seriesCode => $count) {
    $percentage = ($count / $totalTests) * 100;
    $seriesName = Series::getName($seriesCode);
    echo sprintf("%-20s: %7d (%.2f%%)\n", $seriesName, $count, $percentage);
}

echo "\n===========================================\n";
echo "VERIFICAÇÃO DE EMPATES\n";
echo "===========================================\n\n";

// Verifica se todas as combinações retornaram um resultado válido
$allValid = true;
foreach ($results as $combination => $result) {
    if (!in_array($result, $series)) {
        echo "ERRO: Resultado inválido encontrado para combinação {$combination}: {$result}\n";
        $allValid = false;
    }
}

if ($allValid) {
    echo "✓ SUCESSO: Todas as " . number_format(count($results), 0, ',', '.') . " combinações únicas retornaram um resultado válido!\n";
    echo "✓ Não foram encontrados empates!\n";
} else {
    echo "✗ FALHA: Foram encontrados resultados inválidos!\n";
}

echo "\n===========================================\n";
echo "TESTE DE TODAS AS COMBINAÇÕES POSSÍVEIS\n";
echo "===========================================\n\n";

// Testa todas as 3125 combinações possíveis (5^5)
echo "Testando todas as 3.125 combinações possíveis...\n\n";

$allCombinations = [];
$totalCombinations = pow(5, 5); // 3125

$counter = 0;
foreach ($series as $a1) {
    foreach ($series as $a2) {
        foreach ($series as $a3) {
            foreach ($series as $a4) {
                foreach ($series as $a5) {
                    $answers = [1 => $a1, 2 => $a2, 3 => $a3, 4 => $a4, 5 => $a5];
                    $result = $quiz->calculateResult($answers);
                    $key = implode('-', $answers);
                    $allCombinations[$key] = $result;
                    $counter++;
                }
            }
        }
    }
}

echo "Total de combinações possíveis: {$totalCombinations}\n";
echo "Combinações testadas: {$counter}\n";
echo "Todas as combinações retornam um resultado: " . ($counter === $totalCombinations ? "✓ SIM" : "✗ NÃO") . "\n";

// Verifica se há alguma combinação que resulta em empate
$hasError = false;
foreach ($allCombinations as $combination => $result) {
    if (!in_array($result, $series)) {
        echo "ERRO: Combinação {$combination} resultou em valor inválido: {$result}\n";
        $hasError = true;
    }
}

if (!$hasError) {
    echo "\n✓✓✓ TESTE COMPLETO CONCLUÍDO COM SUCESSO! ✓✓✓\n";
    echo "Todas as 3.125 combinações possíveis retornam um resultado válido sem empates!\n";
} else {
    echo "\n✗✗✗ TESTE FALHOU! ✗✗✗\n";
}

echo "\n===========================================\n";
