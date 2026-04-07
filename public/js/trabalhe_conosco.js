document.addEventListener("DOMContentLoaded", function () {

    /* ========== MÁSCARA DE TELEFONE ========= */
    const telInput = document.getElementById("telefone");

    if (telInput) {
        telInput.addEventListener("input", function () {
            let v = telInput.value.replace(/\D/g, ""); // somente números

            if (v.length > 11) v = v.slice(0, 11);

            if (v.length >= 7) {
                telInput.value = `(${v.slice(0, 2)}) ${v.slice(2, 7)}-${v.slice(7)}`;
            } 
            else if (v.length > 2) {
                telInput.value = `(${v.slice(0, 2)}) ${v.slice(2)}`;
            }
            else if (v.length > 0) {
                telInput.value = `(${v}`;
            }
        });
    }

    /* ========== VALIDAÇÃO DO CHECKBOX ========= */
    const form = document.getElementById("curriculoForm");
    const checkbox = document.getElementById("aceite_privacidade");
    const erro = document.getElementById("termoErro");

    if (form && checkbox && erro) {
        form.addEventListener("submit", function (e) {
            if (!checkbox.checked) {
                e.preventDefault();
                erro.style.display = "block";
                checkbox.focus();
                return false;
            }
        });

        checkbox.addEventListener("change", () => {
            erro.style.display = checkbox.checked ? "none" : "block";
        });
    }

});
