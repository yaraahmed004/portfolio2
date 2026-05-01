const pages = document.querySelectorAll('#page-2, #page-3, #page-4');
const navButtons = document.querySelector('.nav-buttons');
const hero = document.getElementById('page-1');
let current = 0;
let locked = false;

// Watch for scrolling past the hero
window.addEventListener('scroll', () => {
    const heroBottom = hero.getBoundingClientRect().bottom;

    if (heroBottom <= 0 && !locked) {
        // User scrolled past hero — show first panel and buttons
        locked = true;
        pages[0].classList.add('active');
        navButtons.classList.add('visible');
        // Prevent further scrolling
        document.body.style.overflow = 'hidden';
    }
});

function goTo(index) {
    pages[current].classList.remove('active');
    current = index;
    pages[current].classList.add('active');
}

document.getElementById('next-btn').addEventListener('click', () => {
    if (current < pages.length - 1) {
        goTo(current + 1);
    }
});

document.getElementById('prev-btn').addEventListener('click', () => {
    if (current > 0) {
        goTo(current - 1);
    } else {
        // If on first panel, go back to hero
        pages[0].classList.remove('active');
        navButtons.classList.remove('visible');
        document.body.style.overflow = '';
        locked = false;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});
