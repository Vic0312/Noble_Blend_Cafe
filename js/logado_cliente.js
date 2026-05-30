document.addEventListener('DOMContentLoaded', () => {
    const botaoTopo = document.querySelector('.voltar-topo');
    const trilho = document.querySelector('[data-carousel-track]');
    const carrossel = document.querySelector('[data-carousel]');

    function atualizarBotaoTopo() {
        if (!botaoTopo) return;
        botaoTopo.classList.toggle('voltar-topo--visivel', window.scrollY > 420);
    }

    atualizarBotaoTopo();
    window.addEventListener('scroll', atualizarBotaoTopo);

    if (trilho && carrossel) {
        let indice = 0;
        const cards = Array.from(trilho.children);

        function itensVisiveis() {
            if (window.innerWidth <= 700) return 1;
            if (window.innerWidth <= 1050) return 2;
            return 4;
        }

        function moverCarrossel() {
            if (!cards.length) return;
            const visiveis = itensVisiveis();
            const maxIndice = Math.max(cards.length - visiveis, 0);
            indice = indice >= maxIndice ? 0 : indice + 1;
            const larguraCard = cards[0].getBoundingClientRect().width;
            const gap = parseFloat(getComputedStyle(trilho).gap) || 0;
            trilho.style.transform = `translateX(-${indice * (larguraCard + gap)}px)`;
        }

        let intervalo = setInterval(moverCarrossel, 2600);

        carrossel.addEventListener('mouseenter', () => clearInterval(intervalo));
        carrossel.addEventListener('mouseleave', () => {
            intervalo = setInterval(moverCarrossel, 2600);
        });

        window.addEventListener('resize', () => {
            indice = 0;
            trilho.style.transform = 'translateX(0)';
        });
    }
});
