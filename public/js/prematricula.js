document.addEventListener('DOMContentLoaded', () => {

    /** ==========================
     *  MÁSCARA DE TELEFONE
     * ========================== */
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function () {
            let valor = telefoneInput.value.replace(/\D/g, '');
            if (valor.length > 11) valor = valor.slice(0, 11);

            if (valor.length > 6) {
                telefoneInput.value = `(${valor.slice(0, 2)}) ${valor.slice(2, 7)}-${valor.slice(7)}`;
            } else if (valor.length > 2) {
                telefoneInput.value = `(${valor.slice(0, 2)}) ${valor.slice(2)}`;
            } else if (valor.length > 0) {
                telefoneInput.value = `(${valor}`;
            }
        });
    }

    /** ==========================
     *  VALIDAÇÃO DE IDADE
     * ========================== */
    function validarIdade() {
        const dataInput = document.querySelector('input[name="dataNascimento"]');
        if (!dataInput || !dataInput.value) return false;

        const hoje = new Date();
        const nascimento = new Date(dataInput.value);

        let idade = hoje.getFullYear() - nascimento.getFullYear();
        const m = hoje.getMonth() - nascimento.getMonth();

        if (m < 0 || (m === 0 && hoje.getDate() < nascimento.getDate())) {
            idade--;
        }

        if (idade < 0) {
            alert('A data de nascimento não pode ser no futuro.');
            return false;
        }

        if (idade > 18) {
            alert('A criança deve ter menos de 18 anos.');
            return false;
        }

        return true;
    }

    /** ==========================
     *  ELEMENTOS DO FORM
     * ========================== */
    const form = document.getElementById('formPreMatricula');
    const mensagemSucesso = document.getElementById('mensagemSucesso');
    const mensagemErro = document.getElementById('mensagemErro');
    const carregando = document.getElementById('carregando');

    if (mensagemSucesso) mensagemSucesso.style.display = 'none';
    if (mensagemErro) mensagemErro.style.display = 'none';
    if (carregando) carregando.style.display = 'none';

    if (!form) return;

    /** ==========================
     *  EVENTO DE ENVIO
     * ========================== */
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // VALIDAÇÃO CHECKBOX LGPD
        const checkbox = document.getElementById('aceite_privacidade_prematricula');
        const errorElement = document.getElementById('termos-error-prematricula');

        if (!checkbox.checked) {
            errorElement.style.display = 'block';
            errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        } else {
            errorElement.style.display = 'none';
        }

        // VALIDAÇÃO IDADE
        if (!validarIdade()) return;

        // Envio
        const formData = new FormData(form);
        carregando.style.display = 'block';

        fetch('/pre-matricula', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro no servidor: ' + response.status);
            }
            return response.text();
        })
        .then(data => {
            carregando.style.display = 'none';

            if (data.toLowerCase().includes('sucesso') || data.includes('ok')) {
                mensagemSucesso.style.display = 'block';
                mensagemSucesso.scrollIntoView({ behavior: 'smooth' });
                form.reset();
            } else {
                mensagemErro.style.display = 'block';
                mensagemErro.innerText = 'Erro ao enviar. Tente novamente.';
            }
        })
        .catch(() => {
            carregando.style.display = 'none';
            mensagemErro.style.display = 'block';
            mensagemErro.innerText = 'Erro de conexão. Tente novamente.';
        });
    });
});
