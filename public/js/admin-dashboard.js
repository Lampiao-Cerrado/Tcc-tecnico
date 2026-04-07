// public/js/admin-dashboard.js

// Alternância entre seções do painel (home / eventos / contato / formulários)
document.addEventListener('DOMContentLoaded', function () {
    var links = document.querySelectorAll('.nav-link');
    links.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            // remove active
            document.querySelectorAll('.section').forEach(function(s) {
                s.classList.remove('active');
            });
            links.forEach(function(a) {
                a.classList.remove('active');
            });

            // ativa a seção clicada
            link.classList.add('active');
            var target = link.dataset.target;
            var el = document.getElementById(target);
            if (el) el.classList.add('active');
        });
    });

    
    const box = document.getElementById('notificacao-sucesso');

    if (box && box.dataset.show === "1") {

        // limpa inputs manualmente
        const form = document.querySelector('#home form');

        if (form) {
            form.querySelectorAll('input[type="text"], textarea').forEach(field => {
                field.value = "";
            });
        }

        // mostra aviso
        box.style.display = "block";
        box.style.opacity = "1";

        setTimeout(() => {
            box.style.opacity = "0";
            setTimeout(() => { box.style.display = "none"; }, 400);
        }, 3000);

        // limpar somente seção CONTATO

        if (box && box.dataset.show === "1") {

        // PEGA SOMENTE O FORMULÁRIO DA SEÇÃO CONTATO
        const form = document.querySelector('#contato form');

        if (form) {
            form.querySelectorAll('input[type="text"], input[type="email"], textarea')
                .forEach(field => field.value = "");
        }

        // mostra aviso
        box.style.display = "block";
        box.style.opacity = "1";

        setTimeout(() => {
            box.style.opacity = "0";
            setTimeout(() => { box.style.display = "none"; }, 400);
        }, 3000);
    }

    }

    const abas = document.querySelectorAll('.aba');
    const conteudos = document.querySelectorAll('.conteudo-aba');

    abas.forEach(aba => {

        aba.addEventListener('click', function () {

            // remove ativa
            abas.forEach(a => a.classList.remove('ativa'));
            conteudos.forEach(c => c.classList.remove('ativa'));

            // ativa clicada
            this.classList.add('ativa');
            const alvo = this.dataset.aba;

            document.getElementById(alvo).classList.add('ativa');
        });

    });


});


    
    
