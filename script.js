const pages = document.querySelectorAll("#page-2, #page-3, #page-4");
const navButtons = document.querySelector(".nav-buttons");
const panelsSection = document.getElementById("panels");
let current = 0;

// Activate first panel on load
pages[0].classList.add("active");

window.addEventListener("scroll", () => {
  const panelsTop = panelsSection.getBoundingClientRect().top;

  if (panelsTop <= 10) {
    navButtons.classList.add("visible");
  } else {
    navButtons.classList.remove("visible");
    pages[current].classList.remove("active");
    current = 0;
    pages[0].classList.add("active");
  }
});

function goTo(index) {
  const prev = pages[current];
  const next = pages[index];

  // Remove active from all to be safe
  pages.forEach((p) => p.classList.remove("active"));

  // Set the new one
  current = index;
  next.classList.add("active");
}

document.getElementById("next-btn").addEventListener("click", () => {
  if (current < pages.length - 1) goTo(current + 1);
});

document.getElementById("prev-btn").addEventListener("click", () => {
  if (current > 0) {
    goTo(current - 1);
  } else {
    window.scrollTo({ top: 0, behavior: "smooth" });
  }
});

// ── Contact form ──
document
  .getElementById("contact-form")
  .addEventListener("submit", async (e) => {
    e.preventDefault();

    const name = document.getElementById("contact-name");
    const email = document.getElementById("contact-email");
    const message = document.getElementById("contact-message");
    const status = document.getElementById("form-message");

    // Clear previous states
    [name, email, message].forEach((el) => el.classList.remove("error"));
    status.className = "form-message";
    status.textContent = "";

    // Basic validation
    let valid = true;
    if (!name.value.trim()) {
      name.classList.add("error");
      valid = false;
    }
    if (!email.value.trim() || !email.value.includes("@")) {
      email.classList.add("error");
      valid = false;
    }
    if (!message.value.trim()) {
      message.classList.add("error");
      valid = false;
    }

    if (!valid) {
      status.textContent = "Please fill in all fields correctly.";
      status.classList.add("error-msg");
      return;
    }

    const res = await fetch("submit.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        name: name.value,
        email: email.value,
        message: message.value,
      }),
    });
    const result = await res.json();

    if (result.success) {
      status.textContent = "Message sent! I'll get back to you soon.";
      status.classList.add("success");
      e.target.reset();
    } else {
      status.textContent = "Something went wrong. Please try again.";
      status.classList.add("error-msg");
    }
    // Simulated success for now
    status.textContent = "Message sent! I'll get back to you soon.";
    status.classList.add("success");
    e.target.reset();
  });

// ── Load projects from DB ──
async function loadProjects() {
  try {
    const res = await fetch("get_projects.php");
    const projects = await res.json();

    const grid = document.getElementById("project-grid");
    grid.innerHTML = "";

    projects.forEach((p) => {
      grid.innerHTML += `
                <div class="project-card">
                    <img src="${p.image}" class="card-img">
                    <div class="project-info">
                        <span class="project-tag">${p.tag}</span>
                        <h3>${p.title}</h3>
                        <p>${p.description}</p>
                        <a href="${p.github_url}" target="_blank" class="github-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
                            View on GitHub
                        </a>
                    </div>
                </div>
            `;
    });
  } catch (err) {
    console.error("Failed to load projects:", err);
  }
}

loadProjects();
