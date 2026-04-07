document.addEventListener("DOMContentLoaded", () => {

    function abrirAba(evt, aba) {
        evt.preventDefault();

        document.querySelectorAll(".tabcontent").forEach(el =>
            el.classList.remove("active")
        );

        document.querySelectorAll(".tablink").forEach(a =>
            a.classList.remove("active")
        );

        document.getElementById(aba).classList.add("active");
        evt.currentTarget.classList.add("active");
    }

    const botoes = document.querySelectorAll(".tablink");

    botoes.forEach(botao => {
        const aba = botao.dataset.aba;

        botao.addEventListener("click", (e) => {
            abrirAba(e, aba);
        });
    });

});
