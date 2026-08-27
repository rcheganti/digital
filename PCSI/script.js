const menuButton = document.querySelector(".menu-toggle");
const navMenu = document.querySelector(".nav-menu");

menuButton.addEventListener("click", () => {
  const open = navMenu.classList.toggle("open");
  menuButton.setAttribute("aria-expanded", String(open));
  menuButton.textContent = open ? "✕" : "☰";
});

document.querySelectorAll(".nav-menu a").forEach(link => {
  link.addEventListener("click", () => {
    navMenu.classList.remove("open");
    menuButton.setAttribute("aria-expanded", "false");
    menuButton.textContent = "☰";
  });
});

const form = document.getElementById("enquiryForm");
const formMessage = document.getElementById("formMessage");

function setError(field, message) {
  field.parentElement.querySelector("small").textContent = message;
  field.setAttribute("aria-invalid", "true");
}

function clearError(field) {
  field.parentElement.querySelector("small").textContent = "";
  field.removeAttribute("aria-invalid");
}

form.addEventListener("submit", event => {
  event.preventDefault();

  const fields = [...form.querySelectorAll("[required]")];
  let valid = true;

  fields.forEach(field => {
    if (!field.value.trim()) {
      setError(field, "This field is required.");
      valid = false;
    } else {
      clearError(field);
    }
  });

  if (!valid) {
    formMessage.textContent = "Please complete all required fields.";
    return;
  }

  const name = document.getElementById("name").value.trim();
  const mobile = document.getElementById("mobile").value.trim();
  const reason = document.getElementById("reason").value;
  const description = document.getElementById("description").value.trim();

  const message = `New Enquiry - Prem Consultancy Services Israel

Name: ${name}
Mobile: ${mobile}
Reason for Contact: ${reason}
Description: ${description}`;

  const whatsappUrl = `https://wa.me/+972538657447?text=${encodeURIComponent(message)}`;

  formMessage.textContent = "Your enquiry is ready to be sent via WhatsApp. Please confirm the message in WhatsApp.";
  window.open(whatsappUrl, "_blank", "noopener");
});

form.querySelectorAll("input, select, textarea").forEach(field => {
  field.addEventListener("input", () => {
    if (field.value.trim()) clearError(field);
  });
});