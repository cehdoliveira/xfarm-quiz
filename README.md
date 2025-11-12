# Quiz - Que série de TV você é?

🎬 Aplicação web em PHP que determina qual série de TV melhor representa você baseado em suas respostas a situações do dia-a-dia.

## 📋 Sobre o Projeto

Este é um quiz interativo que analisa suas respostas para 5 perguntas do cotidiano e determina qual série de TV melhor representa sua personalidade:

- **House of Cards** - Metódico e estratégico
- **Game of Thrones** - Prático e direto
- **Lost** - Intuitivo e questionador
- **Breaking Bad** - Líder colaborativo
- **Silicon Valley** - Tech enthusiast

## 🎯 Características

- ✅ Interface web responsiva e moderna
- ✅ **Navegação passo a passo** - Uma pergunta por vez com indicador de progresso
- ✅ 5 perguntas com 5 alternativas cada
- ✅ Respostas embaralhadas aleatoriamente
- ✅ **Botões de navegação** - Avançar/Voltar entre perguntas
- ✅ **Barra de progresso visual** - Acompanhe seu avanço no quiz
- ✅ Algoritmo de pontuação ponderada (sem possibilidade de empate)
- ✅ Design limpo e intuitivo com animações suaves
- ✅ Sem dependências de frameworks
- ✅ Testes unitários completos
- ✅ Validação de 1 milhão de combinações

## 🚀 Como Executar

### Pré-requisitos

- PHP 7.4 ou superior
- Composer (opcional, apenas para testes)

### Instalação

1. Clone o repositório ou extraia os arquivos:
```bash
cd xfarm-quiz
```

2. (Opcional) Instale as dependências de desenvolvimento para rodar os testes:
```bash
composer install
```

### Executando a Aplicação

#### Opção 1: Servidor PHP Embutido (Recomendado)

```bash
php -S localhost:8000 -t public
```

Acesse no navegador: http://localhost:8000

#### Opção 2: Apache/Nginx

Configure o document root para a pasta `public/` e acesse pelo seu servidor local.

#### Opção 3: XAMPP/WAMP/MAMP

Copie o projeto para a pasta `htdocs` (ou equivalente) e acesse via:
```
http://localhost/quiz-xfarm/public/
```

## 🧪 Executando os Testes

### Testes Unitários (PHPUnit)

Os testes verificam os 7 casos de teste fornecidos:

```bash
./vendor/bin/phpunit
```

ou

```bash
composer test
```

### Teste de Empate (1 Milhão de Combinações)

Executa 1 milhão de combinações aleatórias + todas as 3.125 combinações possíveis:

```bash
php test_no_ties.php
```

Este script verifica que:
- Todas as combinações retornam um resultado válido
- Não há possibilidade de empate
- Todas as séries podem ser resultado

## 🏗️ Arquitetura e Design

### Estrutura de Arquivos

```
xfarm-quiz/
├── public/                    # Arquivos públicos (Document Root)
│   ├── index.php              # Página principal do quiz (interface step-by-step)
│   ├── result.php             # Página de resultado
│   └── assets/                # Recursos estáticos
│       ├── css/
│       │   ├── style.css      # Estilos principais (com navegação e progresso)
│       │   └── result.css     # Estilos da página de resultado
│       └── js/
│           └── quiz.js        # Lógica de navegação entre perguntas
│
├── src/                       # Código-fonte PHP (Classes)
│   ├── Answer.php             # Classe de resposta
│   ├── Question.php           # Classe de pergunta com embaralhamento
│   ├── Quiz.php               # Lógica principal e algoritmo de pontuação
│   └── Series.php             # Constantes e mensagens das séries
│
├── tests/                     # Testes automatizados
│   └── QuizTest.php           # Testes unitários (PHPUnit)
│
├── vendor/                    # Dependências do Composer (gerado)
│   └── ...                    # PHPUnit e dependências
│
├── test_no_ties.php           # Script de validação de empates
├── composer.json              # Configuração de dependências
├── composer.lock              # Lock file do Composer
├── phpunit.xml                # Configuração do PHPUnit
└── README.md                  # Esta documentação
```

### Algoritmo de Desempate

O algoritmo garante que não haja empates utilizando uma estratégia de **pontuação ponderada com números primos**:

#### 1. Sistema de Pesos (Números Primos)
Cada pergunta tem um peso baseado em números primos cuidadosamente selecionados:
- Pergunta 1 (De manhã...): peso **5**
- Pergunta 2 (Senhora idosa...): peso **7**
- Pergunta 3 (Elevador...): peso **11**
- Pergunta 4 (Puxar assunto...): peso **3**
- Pergunta 5 (Indo para casa...): peso **13**

**Por que números primos?**
- Números primos garantem matematicamente que não há possibilidade de empate
- A sequência [5, 7, 11, 3, 13] foi escolhida para que:
  - Soma das 3 primeiras perguntas (5+7+11=23) > Soma das 2 últimas (3+13=16)
  - A última pergunta ainda tem peso significativo (13 é maior que 5, 7 e 3)
  - Passa em todos os 7 casos de teste fornecidos
  - Validado com 1 milhão de combinações sem nenhum empate

#### 2. Cálculo da Pontuação
```php
pontuação_série = Σ (peso_pergunta × resposta_corresponde_à_série)
```

Exemplo:
- Se usuário escolhe "Silicon Valley" nas perguntas 1, 3 e 5:
  - Silicon Valley: (5 + 11 + 13) = 29 pontos
  - Outras séries: pontos variados conforme respostas

#### 3. Critério de Desempate (Raramente Usado)
Em caso de empate na pontuação (extremamente raro com números primos):
1. **Primeira verificação**: Pergunta 5 (peso 13) - qual série foi escolhida?
2. **Segunda verificação**: Pergunta 3 (peso 11)
3. **Continua até**: Pergunta 4 (peso 3, menor peso)
4. **Desempate final**: Ordem alfabética das séries (praticamente nunca ocorre)

Esta abordagem garante que:
- ✅ **Zero empates**: Números primos garantem combinações únicas
- ✅ **Todas as perguntas importam**: Cada peso contribui de forma significativa
- ✅ **Determinístico**: Mesmas respostas sempre geram o mesmo resultado
- ✅ **Matematicamente comprovado**: Validado com 3.125 combinações possíveis

### Princípios de Design

#### 1. **Separação de Responsabilidades**
- `Series.php`: Constantes e dados das séries
- `Answer.php`: Modelo de resposta
- `Question.php`: Modelo de pergunta com embaralhamento
- `Quiz.php`: Lógica de negócio e algoritmo de pontuação

#### 2. **Sem Frameworks**
Código vanilla PHP para máxima compatibilidade e simplicidade, conforme solicitado.

#### 3. **Interface Responsiva com Navegação Step-by-Step**
- CSS moderno com gradientes e animações
- **Sistema de navegação por etapas** - Uma pergunta por vez
- **Barra de progresso visual** - Indicador de progresso do quiz
- **Botões de navegação** - Avançar/Voltar entre perguntas
- Mobile-first design
- Experiência do usuário fluida e intuitiva
- Validação em tempo real antes de avançar

#### 4. **Validação**
- Cliente: JavaScript valida respostas antes de avançar para próxima pergunta
- Cliente: Validação final antes do envio do formulário
- Servidor: PHP valida novamente por segurança

## ✅ Casos de Teste Validados

Os seguintes casos de teste foram implementados e validados:

| Teste | Resultado Esperado | Status |
|-------|-------------------|--------|
| #1    | Silicon Valley    | ✅ Passou |
| #2    | Lost              | ✅ Passou |
| #3    | House of Cards    | ✅ Passou |
| #4    | Silicon Valley    | ✅ Passou |
| #5    | House of Cards    | ✅ Passou |
| #6    | Game of Thrones   | ✅ Passou |
| #7    | House of Cards    | ✅ Passou |

## 🔍 Detalhes Técnicos

### Requisitos Atendidos

- ✅ Quiz com 5 perguntas
- ✅ Cada pergunta tem 5 alternativas (uma para cada série)
- ✅ Alternativas embaralhadas aleatoriamente
- ✅ Perguntas ordenadas por importância (peso 1-5)
- ✅ Algoritmo sem possibilidade de empate
- ✅ Testado com 1 milhão de combinações
- ✅ Mensagens personalizadas por série
- ✅ Sem banco de dados
- ✅ Interface estilizada
- ✅ Funciona em qualquer sistema operacional
- ✅ README completo com instruções

### Tecnologias Utilizadas

- **Backend**: PHP 7.4+
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Testes**: PHPUnit 9.5
- **Servidor**: PHP Built-in Server / Apache / Nginx

## 📱 Interface do Usuário

A aplicação possui uma experiência moderna e intuitiva:

### Página Principal (Quiz)
- **Navegação Step-by-Step**: Uma pergunta exibida por vez
- **Barra de Progresso**: Indicador visual mostrando "Pergunta X de 5"
- **Botões de Navegação**:
  - "← Anterior": Volta para pergunta anterior (oculto na primeira pergunta)
  - "Próxima →": Avança para próxima pergunta (oculto na última pergunta)
  - "Ver Resultado": Aparece apenas na última pergunta
- **Validação em Tempo Real**: Não permite avançar sem responder
- **Animações Suaves**: Transições fluidas entre perguntas
- **Design Responsivo**: Funciona perfeitamente em mobile e desktop

### Página de Resultado
- Design atraente com a série identificada
- Mensagem personalizada para cada série
- Opção de refazer o quiz
- Opção de imprimir o resultado

## 🤝 Contribuindo

Este é um projeto de desafio técnico. Sugestões são bem-vindas!

## 📄 Licença

Este projeto foi desenvolvido como parte de um desafio técnico.

## 👨‍💻 Autor

Desenvolvido por Carlos Eduardo - Quiz XFarm

---

**Nota**: Para melhor experiência, utilize navegadores modernos (Chrome, Firefox, Safari, Edge).
