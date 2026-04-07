document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".btn-remover").forEach(button => {
        button.addEventListener("click", () => {

            document.getElementById("remover-turma").value = button.dataset.turma;
            document.getElementById("remover-arquivo").value = button.dataset.arquivo;

            document.getElementById("form-remover").submit();
        });
    });

});
