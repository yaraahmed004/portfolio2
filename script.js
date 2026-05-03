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

// ── Contact form ──
document.getElementById('contact-form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const name    = document.getElementById('contact-name');
    const email   = document.getElementById('contact-email');
    const message = document.getElementById('contact-message');
    const status  = document.getElementById('form-message');

    // Clear previous states
    [name, email, message].forEach(el => el.classList.remove('error'));
    status.className = 'form-message';
    status.textContent = '';

    // Basic validation
    let valid = true;
    if (!name.value.trim())                       { name.classList.add('error');    valid = false; }
    if (!email.value.trim() || !email.value.includes('@')) { email.classList.add('error');   valid = false; }
    if (!message.value.trim())                    { message.classList.add('error'); valid = false; }

    if (!valid) {
        status.textContent = 'Please fill in all fields correctly.';
        status.classList.add('error-msg');
        return;
    }

    // ── TODO: replace this block with your real fetch() to the backend ──
    // const res = await fetch('/api/contact', {
    //     method: 'POST',
    //     headers: { 'Content-Type': 'application/json' },
    //     body: JSON.stringify({ name: name.value, email: email.value, message: message.value })
    // });

    // Simulated success for now
    status.textContent = 'Message sent! I\'ll get back to you soon.';
    status.classList.add('success');
    e.target.reset();
});
