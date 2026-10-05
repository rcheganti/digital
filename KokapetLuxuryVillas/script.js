const form = document.getElementById("leadForm");
const success = document.getElementById("successMessage");

form.addEventListener("submit", function(e){
  e.preventDefault();

  const data = new FormData(form);
  const name = data.get("name") || "";
  const phone = data.get("phone") || "";
  const email = data.get("email") || "";
  const budget = data.get("budget") || "Not specified";
  const plot = data.get("plot") || "Not specified";
  const purpose = data.get("purpose") || "Not specified";
  const contact = data.get("contact") || "Call";
  const message = data.get("message") || "No additional message";

  const text =
`Kokapet Luxury Villas Enquiry

Name: ${name}
Mobile: ${phone}
Email: ${email}
Budget: ${budget}
Plot Requirement: ${plot}
Purpose: ${purpose}
Preferred Contact: ${contact}
Message: ${message}`;

  const whatsappNumber = "917981920844";
  const url = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(text)}`;

  success.style.display = "block";
  success.textContent = "Enquiry details prepared. Opening WhatsApp…";
  window.open(url, "_blank");

  form.reset();
});

document.querySelectorAll('a[href^="#"]').forEach(link => {
  link.addEventListener("click", () => {
    const menu = document.querySelector(".nav-links");
    if (window.innerWidth <= 900 && menu) menu.classList.remove("mobile-open");
  });
});

const menuBtn = document.querySelector(".menu-btn");
const navLinks = document.querySelector(".nav-links");
if(menuBtn && navLinks){
  menuBtn.addEventListener("click", () => navLinks.classList.toggle("mobile-open"));
}
