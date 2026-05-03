const pages = document.querySelectorAll('#page-2, #page-3, #page-4');
const navButtons = document.querySelector('.nav-buttons');
const panelsSection = document.getElementById('panels');
let current = 0;

// Activate first panel on load
pages[0].classList.add('active');

window.addEventListener('scroll', () => {
    const panelsTop = panelsSection.getBoundingClientRect().top;

    if (panelsTop <= 10) {
        navButtons.classList.add('visible');
    } else {
        navButtons.classList.remove('visible');
        pages[current].classList.remove('active');
        current = 0;
        pages[0].classList.add('active');
    }
});

function goTo(index) {
    const prev = pages[current];
    const next = pages[index];

    // Fade out current, then fade in next
    prev.classList.remove('active');
    setTimeout(() => {
        current = index;
        next.classList.add('active');
    }, 50); // half the transition duration so they briefly overlap
}

document.getElementById('next-btn').addEventListener('click', () => {
    if (current < pages.length - 1) goTo(current + 1);
});

document.getElementById('prev-btn').addEventListener('click', () => {
    if (current > 0) {
        goTo(current - 1);
    } else {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});
