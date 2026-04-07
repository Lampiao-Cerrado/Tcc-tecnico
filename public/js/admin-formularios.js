document.addEventListener('DOMContentLoaded', function () {

    function formatarDataBR(dataIso) {
    if (!dataIso) return "-";
    const partes = dataIso.split("-");
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}

    // =====================================================
    // AUTO-DETECÇÃO DA URL BASE
    // =====================================================
    const BASE = window.location.origin.includes("8000")
        ? ""  // artisan serve → não tem /site-escola/public
        : "/site-escola/public"; // XAMPP → precisa do caminho

    console.log("BASE URL →", BASE);

    function carregarDados(url, tabelaBody, elementoSemRegistros, montarLinha) {

        fetch(BASE + url)
            .then(res => {
                if (!res.ok) throw new Error("HTTP " + res.status);
                return res.json();
            })
            .then(dados => {

                tabelaBody.innerHTML = "";

                if (!dados || dados.length === 0) {
                    elementoSemRegistros.style.display = "block";
                    return;
                }

                elementoSemRegistros.style.display = "none";

                dados.forEach(item => {
                    tabelaBody.innerHTML += montarLinha(item);
                });
            })
            .catch(err => console.error("ERRO AO CARREGAR:", err));
    }

    // =====================================================
    // Função para calcular idade (já corrigida)
    // =====================================================
    function calcularIdade(dataNasc) {
        if (!dataNasc) return "-";
        const hoje = new Date();
        const nasc = new Date(dataNasc);

        if (isNaN(nasc.getTime())) return "-";

        let idade = hoje.getFullYear() - nasc.getFullYear();
        const m = hoje.getMonth() - nasc.getMonth();
        if (m < 0 || (m === 0 && hoje.getDate() < nasc.getDate())) idade--;
        return idade;
    }

    // =====================================================
    // 1. CURRÍCULOS
    // =====================================================
    carregarDados(
        "/admin/formularios/curriculos",
        document.querySelector("#tabela-curriculos tbody"),
        document.getElementById("sem-curriculos"),

        (item) => `
            <tr>
                <td>${item.nome ?? "-"}</td>
                <td>${item.email ?? "-"}</td>
                <td>${item.telefone ?? "-"}</td>
                <td>${item.cargo ?? "-"}</td>
                <td>${item.mensagem ?? "-"}</td>
                <td>
                    <a href="/admin/formulario/curriculo/download/${item.id}"
                        target="_blank"
                        class="btn-verde">
                        Ver Currículo
                    </a>

                </td>
            </tr>
        `
    );

    // =====================================================
    // 2. PRÉ-MATRÍCULAS
    // =====================================================
    carregarDados(
        "/admin/formularios/prematriculas",
        document.querySelector("#tabela-prematriculas tbody"),
        document.getElementById("sem-prematriculas"),

        (p) => {
            const idade = calcularIdade(p.data_nasc);

            return `
                <tr>
                    <td>${p.responsavel ?? "-"}</td>
                    <td>${p.crianca ?? "-"}</td>
                    <td>${idade}</td>
                    <td>${p.turma ?? "-"}</td>
                    <td>${p.periodo ?? "-"}</td>
                    <td>${p.telefone ?? "-"}</td>
                    <td><button class="btn-ver" data-id="${p.id}" data-tipo="prematricula">Ver</button></td>
                </tr>
            `;
        }
    );

    // =====================================================
    // 3. AGENDAMENTOS
    // =====================================================
    carregarDados(
        "/admin/formularios/agendamentos",
        document.querySelector("#tabela-agendamentos tbody"),
        document.getElementById("sem-agendamentos"),

        (a) => `
            <tr>
                <td>${a.nome ?? "-"}</td>
                <td>${a.telefone ?? "-"}</td>
                <td>${formatarDataBR(a.data_visita) ?? "-"}</td>
                <td>${a.hora ?? "-"}</td>
                <td>${a.status ?? "Pendente"}</td>
                <td><button class="btn-ver" data-id="${a.id}" data-tipo="agendamento">Ver</button></td>
            </tr>
        `
    );

        // -------------------------------------------------------
    // 4. Modal Detalhes (FORMATADO)
    // -------------------------------------------------------
    const modal = document.getElementById("modal-detalhes");
    const conteudoModal = document.getElementById("conteudo-modal");

    document.addEventListener("click", function (e) {

        if (e.target.classList.contains("btn-ver")) {

            const id = e.target.dataset.id;
            const tipo = e.target.dataset.tipo;

            fetch(`/admin/formulario/${tipo}/${id}`)
                .then(res => res.json())
                .then(dados => {

                    if (tipo === "prematricula") {

                        conteudoModal.innerHTML = `
                            <h2>Pré-matrícula de ${dados.nome_crianca}</h2>

                            <p><strong>Responsável:</strong> ${dados.nome_responsavel}</p>
                            <p><strong>Telefone:</strong> ${dados.telefone}</p>
                            <p><strong>E-mail:</strong> ${dados.email}</p>

                            <p><strong>Nome da criança:</strong> ${dados.nome_crianca}</p>
                            <p><strong>Data de nascimento:</strong> ${formatarDataBR(dados.data_nascimento)}</p>


                            <p><strong>Turma:</strong> ${dados.turma}</p>
                            <p><strong>Período desejado:</strong> ${dados.periodo}</p>
                        `;

                    } else if (tipo === "agendamento") {
                        // formata a data enviada pela API (YYYY-MM-DD)
                        const dataBR = formatarDataBR(dados.data_visita);

                        conteudoModal.innerHTML = `
                            <h2>Agendamento de Visita</h2>

                            <p><strong>Nome:</strong> ${dados.nome}</p>
                            <p><strong>Telefone:</strong> ${dados.telefone}</p>
                            <p><strong>E-mail:</strong> ${dados.email}</p>
                            <p><strong>Data da visita:</strong> ${dataBR}</p>
                            <p><strong>Horário:</strong> ${dados.hora}</p>
                            <p><strong>Mensagem:</strong> ${dados.mensagem}</p>

                            <button id="confirmar-visita" data-id="${dados.id}" class="btn-confirmar">
                                Confirmar visita
                            </button>
                        `;

                    }
                    
                    modal.style.display = "block";
                });
        }
    });

    document.querySelector(".fechar").addEventListener("click", () => {
            modal.style.display = "none";
        });

        function formatarDataBR(data) {
        if (!data) return "-";
        const d = new Date(data);
        if (isNaN(d.getTime())) return data;

        const dia = String(d.getDate()).padStart(2, "0");
        const mes = String(d.getMonth() + 1).padStart(2, "0");
        const ano = d.getFullYear();

        return `${dia}/${mes}/${ano}`;
    }

    

        // ===============================
    // FECHAR MODAL AO CLICAR FORA
    // ===============================
    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });

    // ===============================
    // FECHAR MODAL COM ESC
    // ===============================
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            modal.style.display = "none";
        }
    });

    // =====================================================
    // 5. Confirmar visita (AJAX)
    // =====================================================
    document.addEventListener("click", async function (e) {

        if (e.target.id === "confirmar-visita") {

            let id = e.target.dataset.id;

            const resp = await fetch(BASE + `/admin/formularios/agendamentos/confirmar/${id}`, {

                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const json = await resp.json();

            if (json.success) {
                alert("Visita confirmada!");

                // Fecha modal
                document.getElementById("modal-detalhes").style.display = "none";

                // Recarrega tabela
                carregarDados(
                    "/admin/formularios/agendamentos",
                    document.querySelector("#tabela-agendamentos tbody"),
                    document.getElementById("sem-agendamentos"),
                    (a) => `
                        <tr>
                            <td>${a.nome ?? "-"}</td>
                            <td>${a.telefone ?? "-"}</td>
                            <td>${formatarDataBR(a.data_visita) ?? "-"}</td>
                            <td>${a.hora ?? "-"}</td>
                            <td>${a.status ?? "Pendente"}</td>
                            <td><button class="btn-ver" data-id="${a.id}" data-tipo="agendamento">Ver</button></td>
                        </tr>
                    `
                );
            }
        }

    });


});
