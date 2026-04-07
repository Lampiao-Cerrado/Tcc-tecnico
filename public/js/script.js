document.addEventListener("DOMContentLoaded", () => {

    const hamburguer = document.querySelector(".menu-hamburguer");
    const navMenu = document.querySelector(".cabecalho-principal nav ul");

    // Abre/fecha menu mobile
    if (hamburguer && navMenu) {
        hamburguer.addEventListener("click", () => {
            navMenu.classList.toggle("menu-aberto");
        });
    }

    const menuItems = document.querySelectorAll(".menu-item");

    menuItems.forEach(item => {

        const link = item.querySelector("a");
        const submenu = item.querySelector("ul");

        if (!submenu) return;

        // 📌 SOMENTE NO MOBILE abre no clique
        link.addEventListener("click", (e) => {
            if (window.innerWidth < 900) {
                e.preventDefault();
                submenu.classList.toggle("submenu-aberto");
            }
        });

    });

    // Fechar menu e submenus ao clicar fora
    document.addEventListener('click', (e) => {

        const menu = document.querySelector('.cabecalho-principal nav ul');
        const clicouForaMenu = !e.target.closest('.menu-navegacao');
        const clicouForaHamburguer = !e.target.closest('.menu-hamburguer');

        // FECHA MENUS (hamburguer + submenus)
        if (clicouForaMenu && clicouForaHamburguer) {

            // Fecha submenus
            const allSubmenus = document.querySelectorAll('.submenu, .submenu1');
            allSubmenus.forEach(sub => sub.classList.remove('submenu-aberto'));

            // Fecha o menu hamburguer
            menu.classList.remove('menu-aberto');
        }
    });

});
