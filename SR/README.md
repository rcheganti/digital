# Sowmya Realestate Website

A responsive real estate website built with only HTML, CSS and vanilla JavaScript.

## Files
- `index.html` — complete website structure
- `style.css` — responsive styling and animations
- `script.js` — property data, filters, modal, mobile navigation and enquiry interactions

## Customize properties
Open `script.js` and edit the `properties` array. Each property includes:
- name
- location
- type
- purpose
- price
- priceLakh
- bedrooms
- bathrooms
- area
- image
- description

## Contact details
The demo uses WhatsApp number `+91 91774 40140` and a placeholder email. Update these in `index.html` and `script.js` before publishing.

## Run
Double-click `index.html` or open it in any modern browser. No build tools are required.

## Publish
Upload the three files to any static hosting service such as GitHub Pages, Netlify, Vercel, or your existing hosting provider.


## Property WhatsApp Enquiry Flow
Clicking **WhatsApp** on any property no longer opens WhatsApp immediately. It:
1. Opens the website enquiry form.
2. Automatically selects the property and property type.
3. Requires name, valid 10-digit Indian mobile number, property, interest and requirement.
4. Validates the mandatory fields.
5. Opens WhatsApp with the completed enquiry details pre-filled.
