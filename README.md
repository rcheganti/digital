# Ravi Digital Marketing — Production-Ready Static Website

## Files
- `index.html` — complete single-page website
- `styles.css` — responsive visual system and components
- `script.js` — navigation, active states, filters, modal, counters and form validation
- `assets/ravi-digital-marketing-logo.jpeg` — official uploaded logo, used unchanged
- `README.md` — deployment and customization notes

## Run locally
Open `index.html` in a browser, or serve the folder with any static web server.

Example:
```bash
python -m http.server 8000
```
Then open `http://localhost:8000`.

## Functional behavior
- Sticky responsive navigation with working section links.
- Mobile hamburger menu opens/closes.
- Active navigation updates while scrolling.
- Phone links use `tel:+919177440140`.
- WhatsApp links use `https://wa.me/919177440140`.
- Service CTAs scroll to the relevant detail section and preselect the service in the enquiry form.
- Portfolio filters work without a page reload.
- Portfolio "View Project" opens a working modal.
- Contact form validates required fields, email and phone, then opens WhatsApp with a pre-filled enquiry.
- Pricing is intentionally shown as "Starting From ₹ —" so no unverified prices are invented.
- Company statistics are neutral editable values set to zero until real figures are supplied.
- No `href="#"` placeholder links are used.

## Customization
1. Replace the six portfolio placeholder cards with real project content/images.
2. Update the `data-count` values in `index.html` when verified company statistics are available.
3. Replace the `₹ —` values with approved pricing.
4. Add the official company email address to the Contact and Footer areas when available.
5. For production SEO, update the Open Graph image URL to your deployed absolute URL.
