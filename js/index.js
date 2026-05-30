document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.querySelector('[data-carousel]');
    const track = document.querySelector('[data-carousel-track]');
    const botaoTopo = document.querySelector('.voltar-topo');

    const controlarBotaoTopo = () => {
        if (!botaoTopo) return;
        botaoTopo.classList.toggle('voltar-topo--visivel', window.scrollY > 320);
    };

    window.addEventListener('scroll', controlarBotaoTopo, { passive: true });
    controlarBotaoTopo();


    const modalUsuario = document.querySelector('[data-modal-usuario]');
    const botoesAbrirModalUsuario = document.querySelectorAll('[data-modal-usuario-abrir]');
    const botoesFecharModalUsuario = document.querySelectorAll('[data-modal-usuario-fechar]');

    const abrirModalUsuario = () => {
        if (!modalUsuario) return;
        modalUsuario.classList.add('modal-usuario--aberto');
        modalUsuario.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-aberto');
    };

    const fecharModalUsuario = () => {
        if (!modalUsuario) return;
        modalUsuario.classList.remove('modal-usuario--aberto');
        modalUsuario.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-aberto');
    };

    botoesAbrirModalUsuario.forEach((botao) => {
        botao.addEventListener('click', abrirModalUsuario);
    });

    botoesFecharModalUsuario.forEach((botao) => {
        botao.addEventListener('click', fecharModalUsuario);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            fecharModalUsuario();
        }
    });

    if (!carousel || !track) return;

    let index = 0;
    let intervalId = null;
    const cards = Array.from(track.children);

    const getVisibleCards = () => {
        const width = window.innerWidth;
        if (width <= 700) return 1;
        if (width <= 1050) return 2;
        return 4;
    };

    const getGap = () => {
        const styles = window.getComputedStyle(track);
        return parseFloat(styles.columnGap || styles.gap || 0) || 0;
    };

    const updateCarousel = () => {
        if (!cards.length) return;

        const visibleCards = getVisibleCards();
        const maxIndex = Math.max(cards.length - visibleCards, 0);

        if (index > maxIndex) index = 0;

        const cardWidth = cards[0].getBoundingClientRect().width;
        const gap = getGap();
        track.style.transform = `translateX(-${index * (cardWidth + gap)}px)`;
    };

    const nextSlide = () => {
        const visibleCards = getVisibleCards();
        const maxIndex = Math.max(cards.length - visibleCards, 0);
        index = index >= maxIndex ? 0 : index + 1;
        updateCarousel();
    };

    const startAutoPlay = () => {
        stopAutoPlay();
        intervalId = setInterval(nextSlide, 2800);
    };

    const stopAutoPlay = () => {
        if (intervalId) clearInterval(intervalId);
    };

    carousel.addEventListener('mouseenter', stopAutoPlay);
    carousel.addEventListener('mouseleave', startAutoPlay);

    window.addEventListener('resize', () => {
        updateCarousel();
        startAutoPlay();
    });

    updateCarousel();
    startAutoPlay();
});
