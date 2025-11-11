document.getElementById('quiz-form').addEventListener('submit', function(e) {
    const questions = parseInt(this.dataset.questions);
    let answered = 0;
    
    for (let i = 1; i <= questions; i++) {
        const radios = document.getElementsByName('q' + i);
        let isAnswered = false;
        
        for (let radio of radios) {
            if (radio.checked) {
                isAnswered = true;
                break;
            }
        }
        
        if (isAnswered) {
            answered++;
        }
    }
    
    if (answered < questions) {
        e.preventDefault();
        document.getElementById('error-message').style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } else {
        document.getElementById('error-message').style.display = 'none';
    }
});

// Remove erro ao selecionar uma resposta
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('error-message').style.display = 'none';
    });
});
