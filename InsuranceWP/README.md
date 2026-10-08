# Insurance WordPress Site (InsureCo theme + Insurance Suite plugin)

Two packages that work together:

| Package | What it does |
|---|---|
| `insurance-suite.zip` (plugin) | Insurance Products + Categories, FAQs, Testimonials, Team, multi-step enquiry form, secure leads database, lead dashboard, search/filter, status, notes, agent assignment, CSV/Excel export, email notifications, WhatsApp link, settings page, SEO meta + schema |
| `insureco.zip` (theme) | Responsive premium design, header/footer, homepage, product archive/detail pages, About, Why Choose Us, FAQ, Contact, Get Quote, floating WhatsApp/Call buttons, sticky mobile CTA |

All content is stored in WordPress. Nothing is hard-coded except the six "Why Choose Us" cards (edit `insureco_features()` in `insureco/functions.php`).

## 1. Run it locally

Easiest: **LocalWP** (https://localwp.com), free, one click WordPress with PHP, MySQL and a mail catcher.
Alternatives: XAMPP / MAMP, Laragon, or Docker (`wp-env`). Requirements: WordPress 6.0+, PHP 7.4+ (8.x recommended).

1. Create a new site in LocalWP (or install WordPress any other way) and log in to `/wp-admin`.
2. **Plugins > Add New > Upload Plugin** > choose `insurance-suite.zip > Install > **Activate**.
   Activation creates the leads tables, the "Insurance Agent" role and demo content (8 products, 10 categories, FAQs, testimonials, team).
3. **Appearance > Themes > Add New > Upload Theme** > choose `insureco.zip` > Install > **Activate**.
   Activation creates the pages (Home, About Us, Why Choose Us, FAQ, Contact, Get a Quote, Privacy Policy, Terms), sets the homepage and builds the menu.
4. **Settings > Permalinks** > choose "Post name" > Save (makes the pretty URLs work).
5. Open **Insurance Leads > Settings** and enter your company name, logo, phone, WhatsApp number (digits with country code, e.g. `919876543210`), email, address, social links and the notification email.
6. Visit the site, click **Get a Free Quote**, submit a test enquiry and check **Insurance Leads**.

## 2. Day-to-day management (no code)

| Task | Where in wp-admin |
|---|---|
| Add / edit / delete / duplicate / publish or unpublish products | Insurance Products (hover a row for *Duplicate*; Draft = unpublished) |
| Featured product, benefits, features, coverage, eligibility, documents, product FAQs, CTA text | Inside each product (Product details box) |
| Categories | Insurance Products > Categories |
| FAQs (with categories) | FAQs |
| Testimonials (name = title, photo = featured image, rating) | Testimonials |
| Team members | Team Members |
| Dashboard with KPIs and charts | Insurance Leads > Dashboard |
| Search, filter, sort, export leads | Insurance Leads > All Leads |
| Change status, add notes, assign agent, follow-up date, edit customer info, history | Click a lead ID |
| Contact info, logo, favicon, stats, hero text, About text, footer, email templates, WhatsApp number | Insurance Leads > Settings |
| Menus | Appearance > Menus |

Add more agents: **Users > Add New** with role **Insurance Agent**. They can open only the leads screens and appear in the *Assigned agent* dropdown.

## 3. Notes

* **Emails locally:** WordPress cannot send mail from a laptop by default. LocalWP includes Mailpit (open its mail tab to see messages). Otherwise install an SMTP plugin such as WP Mail SMTP. Enquiries are always saved even if mail fails.
* **Spam protection:** honeypot field, minimum fill time, 5 submissions per hour per IP, nonce, plus optional free Cloudflare Turnstile (keys in Settings).
* **Security:** leads live in a custom database table that is not exposed through REST or the front end. Admin screens require the `manage_insurance_leads` capability. All input is sanitised, queries are prepared, output is escaped, exports neutralise spreadsheet formulas.
* **Performance:** system font stack (no external fonts), no jQuery or libraries on the front end (~6 KB JS), lazy-loaded images, minified CSS (`main.min.css` loads unless `SCRIPT_DEBUG` is on), new JPEG uploads converted to WebP, emoji scripts removed. Add a caching plugin when you go live.
* **SEO:** semantic headings, breadcrumbs with schema, FAQ schema, InsuranceAgency (LocalBusiness) schema, meta description and Open Graph tags. If Yoast / Rank Math / AIOSEO is active the plugin steps aside for meta tags. The product *Excerpt* is used as the meta description.
* **Fonts:** the design uses `Inter` if installed, otherwise the device's system font. To self-host Inter, add the font files to the theme and an `@font-face` rule.
* **Future-ready:** leads are in their own tables (`ins_leads`, `ins_history`) with agent, follow-up and history columns, an Agent role and filters, so agent dashboards, reminders, CRM/SMS/WhatsApp API, document upload, payments and customer login can be added as separate modules without restructuring.
* **Tested status:** the code was written and statically checked in an environment without PHP/WordPress, so please run it once on your local site. If anything looks off, tell me the exact message or screenshot and I will fix it.
