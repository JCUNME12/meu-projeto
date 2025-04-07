// Validação do formulário
(function () {
    'use strict'
    
    // Selecionar todos os formulários que precisam de validação
    const forms = document.querySelectorAll('.needs-validation')
    
    // Loop sobre eles e prevenir envio
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            
            form.classList.add('was-validated')
        }, false)
    })
})()