const menuToggle = document.querySelector('.menu-toggle');
const primaryNav = document.querySelector('.primary-nav');
const navLinks = document.querySelectorAll('.nav-link, .primary-nav .enroll-btn, .contact-points a');

menuToggle?.addEventListener('click', () => {
  const open = primaryNav.classList.toggle('open');
  menuToggle.setAttribute('aria-expanded', String(open));
  menuToggle.setAttribute('aria-label', open ? 'Close navigation' : 'Open navigation');
});

navLinks.forEach(link => {
  link.addEventListener('click', () => {
    primaryNav.classList.remove('open');
    menuToggle?.setAttribute('aria-expanded', 'false');
    menuToggle?.setAttribute('aria-label', 'Open navigation');
  });
});

const sections = [...document.querySelectorAll('main section[id]')];
const navItems = [...document.querySelectorAll('.nav-link')];

const updateActiveNav = () => {
  const scrollPoint = window.scrollY + 140;
  let current = sections[0]?.id || 'home';

  sections.forEach(section => {
    if (scrollPoint >= section.offsetTop) current = section.id;
  });

  navItems.forEach(item => {
    const href = item.getAttribute('href');
    item.classList.toggle('active', href === `#${current}`);
  });
};

window.addEventListener('scroll', updateActiveNav, { passive: true });
updateActiveNav();

const revealObserver = new IntersectionObserver((entries, observer) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.12 });

document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

const topButton = document.querySelector('.back-to-top');

window.addEventListener('scroll', () => {
  topButton.classList.toggle('show', window.scrollY > 500);
}, { passive: true });

topButton.addEventListener('click', () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
});

document.querySelectorAll('a[href^="#"]').forEach(link => {
  link.addEventListener('click', event => {
    const target = document.querySelector(link.getAttribute('href'));
    if (!target) return;
    event.preventDefault();
    const headerOffset = 110;
    const y = target.getBoundingClientRect().top + window.scrollY - headerOffset;
    window.scrollTo({ top: Math.max(0, y), behavior: 'smooth' });
  });
});


// Contact form: opens WhatsApp with the visitor's enquiry addressed to Timini.
const contactForm = document.querySelector('#contactForm');
const formStatus = document.querySelector('#formStatus');

contactForm?.addEventListener('submit', (event) => {
  event.preventDefault();

  if (!contactForm.checkValidity()) {
    contactForm.reportValidity();
    return;
  }

  const data = new FormData(contactForm);
  const name = String(data.get('name') || '').trim();
  const phone = String(data.get('phone') || '').trim();
  const email = String(data.get('email') || '').trim();
  const course = String(data.get('course') || 'General enquiry').trim();
  const message = String(data.get('message') || '').trim();

  const whatsappMessage =
`Hello Timini English Private Institute,

I would like to make an enquiry.

Name: ${name}
Phone: ${phone}
Email: ${email || 'Not provided'}
Interested in: ${course}

Message:
${message}`;

  const whatsappUrl = `https://wa.me/35799376036?text=${encodeURIComponent(whatsappMessage)}`;

  formStatus.textContent = 'Opening WhatsApp with your enquiry…';
  window.open(whatsappUrl, '_blank', 'noopener,noreferrer');
});
