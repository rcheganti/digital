const PHONE = "919177440140";
const nav = document.querySelector(".primary-nav");
const menuToggle = document.querySelector(".menu-toggle");
const navLinks = [...document.querySelectorAll(".primary-nav a")];
const sections = [...document.querySelectorAll("main section[id]")];
const header = document.querySelector(".site-header");

menuToggle?.addEventListener("click", () => {
  const open = nav.classList.toggle("open");
  menuToggle.setAttribute("aria-expanded", String(open));
  menuToggle.setAttribute("aria-label", open ? "Close navigation menu" : "Open navigation menu");
});

navLinks.forEach(link => link.addEventListener("click", () => {
  nav.classList.remove("open");
  menuToggle?.setAttribute("aria-expanded", "false");
  menuToggle?.setAttribute("aria-label", "Open navigation menu");
}));

const setActiveNav = () => {
  const y = window.scrollY + (header?.offsetHeight || 76) + 90;
  let current = "home";
  sections.forEach(section => {
    if (y >= section.offsetTop) current = section.id;
  });
  navLinks.forEach(link => {
    const isActive = link.getAttribute("href") === `#${current}`;
    link.classList.toggle("active", isActive);
  });
};
window.addEventListener("scroll", setActiveNav, {passive:true});
window.addEventListener("load", setActiveNav);

document.querySelectorAll('a[href^="#"]').forEach(link => {
  link.addEventListener("click", event => {
    const id = link.getAttribute("href");
    if (!id || id === "#") return;
    const target = document.querySelector(id);
    if (!target) return;
    event.preventDefault();
    target.scrollIntoView({behavior:"smooth", block:"start"});
    history.pushState(null, "", id);
    setTimeout(setActiveNav, 500);
  });
});

document.querySelectorAll("[data-service]").forEach(button => {
  button.addEventListener("click", () => {
    const service = button.dataset.service;
    const select = document.querySelector("#serviceSelect");
    if (select && [...select.options].some(option => option.value === service)) {
      select.value = service;
    }
  });
});

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add("visible");
      observer.unobserve(entry.target);
    }
  });
}, {threshold:.12});
document.querySelectorAll(".reveal").forEach(el => observer.observe(el));

const counters = document.querySelectorAll("[data-count]");
const counterObserver = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;
    const el = entry.target;
    const target = Number(el.dataset.count || 0);
    let value = 0;
    const duration = 800;
    const start = performance.now();
    const tick = now => {
      const progress = Math.min((now - start) / duration, 1);
      value = Math.floor(target * (1 - Math.pow(1 - progress, 3)));
      el.textContent = value;
      if (progress < 1) requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
    counterObserver.unobserve(el);
  });
}, {threshold:.6});
counters.forEach(el => counterObserver.observe(el));

const filterButtons = document.querySelectorAll(".filter-btn");
const portfolioItems = document.querySelectorAll(".portfolio-item");
filterButtons.forEach(btn => {
  btn.addEventListener("click", () => {
    filterButtons.forEach(b => b.classList.remove("active"));
    btn.classList.add("active");
    const filter = btn.dataset.filter;
    portfolioItems.forEach(item => {
      const show = filter === "all" || item.dataset.category === filter;
      item.classList.toggle("is-hidden", !show);
    });
  });
});

const modal = document.querySelector("#projectModal");
const modalTitle = document.querySelector("#modalTitle");
const openModal = project => {
  modalTitle.textContent = project;
  modal.classList.add("open");
  modal.setAttribute("aria-hidden", "false");
  document.body.style.overflow = "hidden";
};
const closeModal = () => {
  modal.classList.remove("open");
  modal.setAttribute("aria-hidden", "true");
  document.body.style.overflow = "";
};
document.querySelectorAll(".project-btn").forEach(btn => btn.addEventListener("click", () => openModal(btn.dataset.project)));
document.querySelectorAll("[data-close-modal]").forEach(el => el.addEventListener("click", closeModal));
document.addEventListener("keydown", e => { if (e.key === "Escape") closeModal(); });

const form = document.querySelector("#contactForm");
const status = document.querySelector("#formStatus");
const setStatus = (message, type) => {
  status.textContent = message;
  status.className = `form-status ${type}`;
};
form?.addEventListener("submit", event => {
  event.preventDefault();
  setStatus("", "");
  const data = new FormData(form);
  const required = ["name","phone","email","business","service","message"];
  const missing = required.filter(key => !String(data.get(key) || "").trim());
  const email = String(data.get("email") || "").trim();
  const phone = String(data.get("phone") || "").replace(/\D/g, "");
  if (missing.length) {
    setStatus("Please complete all required fields before sending your enquiry.", "error");
    form.querySelector(`[name="${missing[0]}"]`)?.focus();
    return;
  }
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    setStatus("Please enter a valid email address.", "error");
    form.querySelector('[name="email"]')?.focus();
    return;
  }
  if (phone.length < 10) {
    setStatus("Please enter a valid phone number.", "error");
    form.querySelector('[name="phone"]')?.focus();
    return;
  }
  const message = [
    "Hello Ravi Digital Marketing,",
    "",
    `Name: ${data.get("name")}`,
    `Phone: ${data.get("phone")}`,
    `Email: ${data.get("email")}`,
    `Business: ${data.get("business")}`,
    `Service: ${data.get("service")}`,
    `Message: ${data.get("message")}`
  ].join("\n");
  const url = `https://wa.me/${PHONE}?text=${encodeURIComponent(message)}`;
  setStatus("Validation successful. Opening WhatsApp…", "success");
  window.open(url, "_blank", "noopener,noreferrer");
});

document.querySelector("#year").textContent = new Date().getFullYear();
