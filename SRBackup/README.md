# Sowmya Realestate Website – Iconic 6 Lead Ads Update

## Included files
- `index.html` – existing real-estate website with an improved enquiry form and Meta Pixel PageView integration.
- `style.css` – existing responsive styling plus enquiry form states.
- `script.js` – property listings, validation, qualification questions and lead submission.
- `config.js` – place your real Meta Pixel ID here.
- `thank-you.html` – successful submission confirmation and Meta Lead event.

## Lead submission setup (required)
The website is static HTML, so it needs a form-processing service to receive and store enquiries. This version uses FormSubmit's AJAX endpoint and emails submissions to the address already present in the original website: `smyravi@gmail.com`.

1. Upload all updated files to the same website folder.
2. Submit one real test enquiry from the live website.
3. FormSubmit will send an activation email to `smyravi@gmail.com` on first use. Open that email and activate the form.
4. Submit another test enquiry and confirm that the email arrives.
5. Check spam/junk if the activation or lead email is not in the inbox.

FormSubmit is an external service. This package does not create a private CRM/database or guarantee permanent lead storage. For a proper lead dashboard and stronger control, connect a dedicated backend/CRM later.

## Meta Pixel setup (required)
1. Open `config.js`.
2. Replace `PASTE_YOUR_META_PIXEL_ID_HERE` with your real numeric Meta Pixel ID.
3. Save and upload `config.js`.
4. In Meta Events Manager > Test Events, open the website and confirm `PageView`.
5. Submit a successful test enquiry. The browser redirects to `thank-you.html`; only after a successful FormSubmit response, the page fires the `Lead` event.
6. Verify the `Lead` event in Test Events.

Do not publish with the placeholder Pixel ID. No real Pixel ID was supplied with the ZIP.

## Meta Ad destination
Use the actual published Iconic 6 page URL with this query parameter:
`?project=iconic6`

Example:
`https://YOUR-DOMAIN/YOUR-WEBSITE-FOLDER/index.html?project=iconic6`

This automatically selects Iconic 6 in the enquiry form when the visitor arrives from the ad.

## Important checks
- The original ZIP did not contain the referenced `images/` directory or videos. Keep your existing images/videos in their current relative folders when uploading; this update does not recreate missing media.
- The project information has been retained from the supplied website source. Verify approvals, price and availability with the project owner before advertising.
- The enquiry form requires name, phone, property, interest, purchase purpose and buying timeline. Site visit preference and message are also collected.
- A successful email submission is not the same as a CRM database. For lead export, team access, deduplication and secure storage, add a backend/CRM integration.
