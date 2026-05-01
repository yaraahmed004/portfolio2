// Fade out hero title on scroll
const title = document.querySelector(".luxurious");

window.addEventListener("scroll", () => {
  const fade = 1 - window.scrollY / 200;
  title.style.opacity = Math.max(0, fade);
});
// Fade in sections as you scroll down
const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
      }
    });
  },
  { threshold: 0.2 },
);

document.querySelectorAll(".about").forEach((el) => observer.observe(el));
