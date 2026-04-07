document.addEventListener("DOMContentLoaded", () => {

    const links = document.querySelectorAll(".tablink");
    const tabs = document.querySelectorAll(".tabcontent");

    links.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();

            // Remove active de todos
            links.forEach(l => l.classList.remove("active"));
            tabs.forEach(t => t.classList.remove("active"));

            // Ativa o selecionado
            const tabId = link.getAttribute("data-tab");
            const tab = document.getElementById(tabId);

            if (tab) {
                link.classList.add("active");
                tab.classList.add("active");
            }
        });
    });

});
