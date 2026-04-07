document.addEventListener("DOMContentLoaded", () => {

    // ============================================================
    // BASE URL – FUNCIONA EM LOCALHOST E EM PRODUÇÃO
    // ============================================================
    const BASE = window.location.origin.includes("8000")
        ? ""
        : "/site-escola/public";

    console.log("BASE EVENTOS →", BASE);

    // ============================================================
    // ELEMENTOS
    // ============================================================
    const listaEventos = document.getElementById("lista-eventos");
    const formEvento = document.getElementById("form-evento");
    const formEventoData = document.getElementById("form-evento-data");

    const btnAddEvento = document.getElementById("btn-add-evento");
    const btnFecharForm = document.getElementById("btn-fechar-form");

    const inputId = document.getElementById("evento-id");
    const inputTitulo = document.getElementById("evento-titulo");
    const inputDescricao = document.getElementById("evento-descricao");
    const inputData = document.getElementById("evento-data");

    const inputImagem = document.getElementById("evento-imagem");
    const inputGaleria = document.getElementById("evento-galeria");

    const tituloForm = document.getElementById("titulo-form-evento");
    const csrf = document.querySelector('meta[name="csrf-token"]').content;


    // ============================================================
    // ABRIR / FECHAR FORMULÁRIO
    // ============================================================
    function abrirFormEvento() {
        tituloForm.innerText = "Adicionar Novo Evento";
        formEventoData.reset();
        inputId.value = "";
        formEvento.style.display = "block";
    }

    function fecharFormEvento() {
        formEvento.style.display = "none";
    }

    btnAddEvento.addEventListener("click", abrirFormEvento);
    btnFecharForm.addEventListener("click", fecharFormEvento);


    // ============================================================
    // GERAR CARD DE EVENTO
    // ============================================================
    function gerarCard(event) {
        return `
            <div class="evento-card" data-id="${event.id}">
                <img src="${event.image_url ?? '/imagens/imagem-padrao.jpg'}" class="evento-imagem">

                <div class="evento-info">
                    <div class="evento-titulo">${event.title}</div>
                    <div class="evento-data">${event.date_br}</div>
                    <div class="evento-status">${event.active ? "Ativo" : "Inativo"}</div>
                </div>

                <div class="evento-acoes">
                    <button class="btn-editar" data-editar="${event.id}">Editar</button>
                    <button class="btn-status" data-status="${event.id}">
                        ${event.active ? "Desativar" : "Ativar"}
                    </button>
                    <button class="btn-excluir" data-excluir="${event.id}">Excluir</button>
                </div>
            </div>
        `;
    }


    // ============================================================
    // LISTAR EVENTOS
    // ============================================================
    async function carregarEventos() {
        listaEventos.innerHTML = "<p style='color:#777'>Carregando...</p>";

        const response = await fetch(`${BASE}/admin/events/json`, {
            headers: { "X-Requested-With": "XMLHttpRequest" }
        });

        const eventos = await response.json();

        listaEventos.innerHTML = "";
        eventos.forEach(ev => listaEventos.innerHTML += gerarCard(ev));
    }

    carregarEventos();


    // ============================================================
    // SALVAR (CRIAR / EDITAR)
    // ============================================================
    formEventoData.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData();

        // Campos normais
        formData.append("title", inputTitulo.value);
        formData.append("description", inputDescricao.value);

        let dataBr = inputData.value;
        if (dataBr.includes("/")) {
            let [d, m, a] = dataBr.split("/");
            dataBr = `${a}-${m}-${d}`;
        }
        formData.append("event_date", dataBr);

        // Imagem principal
        if (inputImagem.files.length > 0) {
            formData.append("main_image", inputImagem.files[0]);
        }

        // Galeria (todos os arquivos)
        for (let file of inputGaleria.files) {
            formData.append("gallery[]", file);
        }

        let id = inputId.value;
        let url = id
            ? `${BASE}/admin/events/${id}`
            : `${BASE}/admin/events`;

        if (id) {
            formData.append("_method", "PUT");
        }

        const response = await fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrf,
                "X-Requested-With": "XMLHttpRequest"
            },
            body: formData
        });

        const json = await response.json();

        if (json.success) {
            alert("Evento salvo com sucesso!");
            fecharFormEvento();
            carregarEventos();
        } else {
            alert("Erro ao salvar evento.");
            console.error(json);
        }
    });



    // ============================================================
    // EDITAR EVENTO
    // ============================================================
    document.addEventListener("click", async function (e) {
        if (e.target.dataset.editar) {

            let id = e.target.dataset.editar;

            const response = await fetch(`${BASE}/admin/events/${id}/edit`, {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            });

            const event = await response.json();

            tituloForm.innerText = "Editar Evento";

            inputId.value = event.id;
            inputTitulo.value = event.title;
            inputDescricao.value = event.description;
            inputData.value = event.event_date; // formato Y-m-d perfeito p/ input DATE

            formEvento.style.display = "block";
        }
    });



    // ============================================================
    // ATIVAR / DESATIVAR
    // ============================================================
    document.addEventListener("click", async function (e) {

        if (e.target.dataset.status) {

            let id = e.target.dataset.status;

            const response = await fetch(`${BASE}/admin/events/${id}/toggle-active`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    "X-Requested-With": "XMLHttpRequest"
                }
            });

            const json = await response.json();
            if (json.success) carregarEventos();
        }
    });



    // ============================================================
    // EXCLUIR EVENTO
    // ============================================================
    document.addEventListener("click", async function (e) {

        if (e.target.dataset.excluir) {

            if (!confirm("Deseja realmente excluir este evento?")) return;

            let id = e.target.dataset.excluir;

            const response = await fetch(`${BASE}/admin/events/${id}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    "X-Requested-With": "XMLHttpRequest",
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "_method=DELETE"
            });

            const json = await response.json();

            if (json.success) {
                alert("Evento excluído!");
                carregarEventos();
            }
        }
    });

});
