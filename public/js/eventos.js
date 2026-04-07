document.addEventListener("DOMContentLoaded", () => {

    const modal = document.getElementById("modal-galeria");
    const fecharBtn = document.querySelector(".fechar-modal");
    const container = document.querySelector(".galeria-modal-container");

    let galeria = [];
    let indexAtual = 0;

    // ============================================================
    // ABRIR E FECHAR MODAL
    // ============================================================
    function abrirModal() {
        modal.style.display = "flex";
        document.body.style.overflow = "hidden";
    }

    function fecharModal() {
        modal.style.display = "none";
        container.innerHTML = "";
        document.body.style.overflow = "auto";
        galeria = [];
        indexAtual = 0;
    }

    fecharBtn.addEventListener("click", fecharModal);

    modal.addEventListener("click", (e) => {
        if (e.target === modal) fecharModal();
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") fecharModal();
    });

    // ============================================================
    // MODO 1 — MOSTRAR MINIATURAS
    // ============================================================
    function renderizarMiniaturas() {
        container.innerHTML = `
            <div class="grid-miniaturas">
                ${galeria.map((img, i) => `
                    <img src="${img.caminho}" class="thumb" data-index="${i}">
                `).join("")}
            </div>
        `;

        document.querySelectorAll(".thumb").forEach(thumb => {
            thumb.addEventListener("click", () => {
                indexAtual = parseInt(thumb.dataset.index);
                renderizarImagem();
            });
        });
    }

    // ============================================================
    // MODO 2 — IMAGEM AMPLIADA
    // ============================================================
    function renderizarImagem() {
        if (!galeria.length) return;

        const img = galeria[indexAtual];

        container.innerHTML = `
            <div class="navegacao-setas">
                <button id="seta-esq" class="seta">&lt;</button>
                
                <div class="foto-wrapper">
                    <img src="${img.caminho}" class="imagem-ampliada">
                    ${img.legenda ? `<div class="galeria-legenda">${img.legenda}</div>` : ""}
                </div>

                <button id="seta-dir" class="seta">&gt;</button>
            </div>
        `;

        document.getElementById("seta-esq").onclick = imagemAnterior;
        document.getElementById("seta-dir").onclick = proximaImagem;
    }

    function proximaImagem() {
        indexAtual = indexAtual < galeria.length - 1 ? indexAtual + 1 : 0;
        renderizarImagem();
    }

    function imagemAnterior() {
        indexAtual = indexAtual > 0 ? indexAtual - 1 : galeria.length - 1;
        renderizarImagem();
    }

    // ============================================================
    // NAVEGAÇÃO POR TECLADO
    // ============================================================
    document.addEventListener("keydown", (e) => {
        if (modal.style.display !== "flex") return;

        if (e.key === "ArrowLeft") imagemAnterior();
        if (e.key === "ArrowRight") proximaImagem();
    });

    // ============================================================
    // NAVEGAÇÃO PELO MOUSE (ROLAGEM)
    // ============================================================
    container.addEventListener("wheel", (e) => {
        if (modal.style.display !== "flex") return;

        if (e.deltaY > 0) {
            proximaImagem();
        } else {
            imagemAnterior();
        }
    });

    // ============================================================
    // BOTÃO "VER FOTOS"
    // ============================================================
    document.querySelectorAll(".btn-galeria").forEach(btn => {
        btn.addEventListener("click", async () => {
            const eventId = btn.dataset.eventId;

            try {
                const response = await fetch(`/eventos-json/${eventId}`);
                const data = await response.json();

                const fotos = data?.dados?.galeria ?? [];

                if (fotos.length === 0) {
                    container.innerHTML = "<p>Nenhuma imagem disponível.</p>";
                    abrirModal();
                    return;
                }

                galeria = fotos.map(f => ({
                    caminho: f.caminho_imagem,
                    legenda: f.legenda
                }));

                renderizarMiniaturas();
                abrirModal();

            } catch (error) {
                console.error(error);
                alert("Erro ao carregar a galeria.");
            }
        });
    });

});
