// Variáveis de controle
let currentQuestion = 0;
const totalQuestions = parseInt(document.getElementById('quiz-form').dataset.questions);

// Elementos
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');
const submitBtn = document.getElementById('submit-btn');
const errorMessage = document.getElementById('error-message');
const progressBar = document.getElementById('progress-bar');
const progressText = document.getElementById('progress-text');

// Função para mostrar pergunta específica
function showQuestion(questionIndex) {
    // Esconder todas as perguntas
    for (let i = 0; i < totalQuestions; i++) {
        const questionElement = document.getElementById(`question-${i}`);
        if (questionElement) {
            questionElement.style.display = 'none';
        }
    }
    
    // Mostrar pergunta atual
    const currentQuestionElement = document.getElementById(`question-${questionIndex}`);
    if (currentQuestionElement) {
        currentQuestionElement.style.display = 'block';
    }
    
    // Atualizar botões de navegação
    prevBtn.style.display = questionIndex === 0 ? 'none' : 'inline-block';
    nextBtn.style.display = questionIndex === totalQuestions - 1 ? 'none' : 'inline-block';
    submitBtn.style.display = questionIndex === totalQuestions - 1 ? 'inline-block' : 'none';
    
    // Atualizar barra de progresso
    const progress = ((questionIndex + 1) / totalQuestions) * 100;
    progressBar.style.setProperty('--progress', `${progress}%`);
    progressBar.querySelector('::after') || (progressBar.style.background = `linear-gradient(to right, #667eea ${progress}%, #e0e0e0 ${progress}%)`);
    
    // Atualizar texto de progresso
    progressText.textContent = `Pergunta ${questionIndex + 1} de ${totalQuestions}`;
    
    // Esconder mensagem de erro
    errorMessage.style.display = 'none';
    
    // Scroll para o topo
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Função para verificar se a pergunta atual foi respondida
function isCurrentQuestionAnswered() {
    const radios = document.getElementsByName(`q${currentQuestion + 1}`);
    for (let radio of radios) {
        if (radio.checked) {
            return true;
        }
    }
    return false;
}

// Botão Próxima
nextBtn.addEventListener('click', function() {
    if (!isCurrentQuestionAnswered()) {
        errorMessage.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
    }
    
    if (currentQuestion < totalQuestions - 1) {
        currentQuestion++;
        showQuestion(currentQuestion);
    }
});

// Botão Anterior
prevBtn.addEventListener('click', function() {
    if (currentQuestion > 0) {
        currentQuestion--;
        showQuestion(currentQuestion);
    }
});

// Validação do formulário no submit
document.getElementById('quiz-form').addEventListener('submit', function(e) {
    if (!isCurrentQuestionAnswered()) {
        e.preventDefault();
        errorMessage.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
    }
    
    // Verificar se todas as perguntas foram respondidas
    let allAnswered = true;
    for (let i = 1; i <= totalQuestions; i++) {
        const radios = document.getElementsByName('q' + i);
        let isAnswered = false;
        
        for (let radio of radios) {
            if (radio.checked) {
                isAnswered = true;
                break;
            }
        }
        
        if (!isAnswered) {
            allAnswered = false;
            break;
        }
    }
    
    if (!allAnswered) {
        e.preventDefault();
        errorMessage.textContent = 'Por favor, responda todas as perguntas antes de continuar.';
        errorMessage.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } else {
        errorMessage.style.display = 'none';
    }
});

// Remover erro ao selecionar uma resposta
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        errorMessage.style.display = 'none';
    });
});

// Atualizar barra de progresso usando CSS custom property
const style = document.createElement('style');
style.textContent = `
    .progress-bar::after {
        width: var(--progress, 20%);
    }
`;
document.head.appendChild(style);

// Inicializar primeira pergunta
showQuestion(0);
