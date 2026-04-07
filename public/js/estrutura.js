/* Modal de ampliação de imagens da página Estrutura */

document.addEventListener("DOMContentLoaded", () => {
    const imagens = document.querySelectorAll('.galeria img');
    const modal = document.getElementById("modal");
    const modalImg = document.getElementById("imgAmpliada");
    const caption = document.getElementById("caption");
    const fechar = document.querySelector(".fechar");

    if (!modal) return; // segurança caso o modal não esteja presente

    imagens.forEach(img => {
        img.addEventListener("click", () => {
            modal.style.display = "block";
            modalImg.src = img.src;
            caption.textContent = img.alt;
        });
    });

    fechar.addEventListener("click", () => {
        modal.style.display = "none";
    });

    modal.addEventListener("click", (event) => {
        if (event.target === modal) modal.style.display = "none";
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") modal.style.display = "none";
    });
});
