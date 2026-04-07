document.addEventListener('DOMContentLoaded', () => {

    // Máscara telefone
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

    // VALIDAÇÃO DE HORÁRIO
    function validarHorario() {
        const horaInput = document.querySelector('input[name="hora"]');
        if (!horaInput) return true;

        const horaSelecionada = horaInput.value;

        if (horaSelecionada) {
            const [horas, minutos] = horaSelecionada.split(':').map(Number);
            const totalMinutos = horas * 60 + minutos;

            if (totalMinutos < 7 * 60 || totalMinutos > 17 * 60) {
                alert('Por favor, selecione um horário entre 07:00 e 17:00');
                horaInput.value = '';
                return false;
            }
        }
        return true;
    }

    // FORMULÁRIO
    const form = document.getElementById('formAgendarVisita');
    const carregando = document.getElementById('carregando');
    const termoErro = document.getElementById('termos-error-agendamento');

    if (carregando) carregando.style.display = 'none';
    if (!form) return;

    form.addEventListener('submit', function (e) {

        // Validação do checkbox LGPD
        const checkbox = document.getElementById('aceite_privacidade_agendamento');

        if (!checkbox.checked) {
            e.preventDefault();
            termoErro.style.display = 'block';
            termoErro.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        } else {
            termoErro.style.display = 'none';
        }

        // Validação de horário
        if (!validarHorario()) {
            e.preventDefault();
            return;
        }

        // Mostra o carregando ANTES de enviar ao backend
        carregando.style.display = 'block';

        // AQUI o submit continua normalmente! (SEM AJAX)
    });
});
