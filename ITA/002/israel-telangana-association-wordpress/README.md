# Israel Telangana Association – WordPress Website

Two parts:

| Part | Folder | What it does |
|---|---|---|
| **ITA Core** (plugin) | `wp-content/plugins/ita-core` | Events, Photo Albums, Committee, Enquiries (contact + membership), Site Settings, roles, security hardening, sample content |
| **ITA Theme** (theme) | `wp-content/themes/ita-theme` | Responsive design, home page, event/gallery/committee/news templates, lightbox, SEO & social meta |

Requires WordPress 6.4+ (tested design for 6.x) and PHP 7.4+ (PHP 8.x fine). PHP GD is used only to create the sample placeholder images.

## 1. Install

**Local (Local by Flywheel, XAMPP, WordPress Studio, etc.)**
1. Create a fresh WordPress site.
2. Copy `wp-content/plugins/ita-core` and `wp-content/themes/ita-theme` from this package into the site's `wp-content` folders.
3. Dashboard → Appearance → Themes → activate **ITA Theme**.
4. Dashboard → Plugins → activate **ITA Core**.

**Any WordPress (upload)**
1. Plugins → Add New → Upload → `ita-core.zip` → Activate.
2. Appearance → Themes → Add New → Upload → `ita-theme.zip` → Activate.

On activation the plugin creates sample content: pages (Home, About Us, News & Announcements, Membership, Contact Us, Privacy Policy), a primary menu with **5 top-level items** (Home, About Us ▸ Our Committee / Membership, News & Announcements, Recent Events ▸ Photo Gallery, Contact Us), 4 news/announcement posts, 3 highlights, 3 upcoming + 3 past events (dates are relative to the activation day), 2 photo albums, 6 sample committee members, bundled illustrated sample images (festival scenes, hero banner, portraits – no real photos are included, so replace them with your own), permalinks (`/%postname%/`) and the Israel time zone. **Replace all sample text, names, e-mail and phone with real details.**

## 2. Run the daily admin tasks (no coding)

**Events** – left menu → *Events* → *Add New*
- Title, description (editor) and poster (*Featured image*).
- *Event details* box: start date/time (required), end date/time, location, registration link, status (Scheduled / Cancelled / Postponed / Registration closed).
- *Event photos* box: *Add / upload photos*, drag to reorder, × to remove.
- Publish, or **Save Draft / Schedule / Preview** with the standard buttons. To unpublish: set status to *Draft*. To delete: *Move to Trash*.
- An event shows under **Upcoming** until its end time (or start time, when no end is set) passes, then moves to **Recent Events** automatically. Newest past events appear first.

**News & announcements** – *Posts* → *Add New*. Pick category *News* or *Announcements*, add featured image, excerpt, publish/schedule. Category pages, search and pagination work automatically. Posts in *Community Highlights* appear in the home page highlights section instead of the news list.

**Photo gallery** – *Photo Gallery* → *Add New* album: title, description, cover (featured image) and *Album photos* (add, reorder, remove). Captions: *Media → Library* → click photo → Caption. To replace a photo, remove it from the album and add the new one (or use *Replace media* if you use a media-replace plugin). Photos open in a lightbox (arrow keys / Esc work).

**Committee** – *Committee* → *Add New*: name (title), designation (box on the right), photo (Featured image), short bio (Excerpt), order (Page Attributes → Order, lowest first).

**About Us / other pages** – *Pages* → edit *About Us* (history, mission, vision, objectives, achievements).

**Homepage banner, introduction, contact details, social links, notification e-mail, footer text** – *ITA Settings*.

**Menus** – *Appearance → Menus*.

**Contact & membership submissions** – *Enquiries*. Each submission is also e-mailed to the address in *ITA Settings → Send form notifications to*. Delete entries you no longer need.

**Users & roles** – *Users*. 
- Administrator: everything. 
- Editor: manages all content, events, albums, committee and enquiries. 
- **Event Manager** (new role): create/edit/publish/delete only their own events and albums, upload photos.
- Author/Contributor: standard WordPress news writing.

## 3. Features included

- Custom post types: Events, Photo Albums, Committee, Enquiries (all editable in the dashboard; nothing hard-coded in templates).
- Events: upcoming vs. past split by date, paged past list, detail page, status badges, registration button (only for upcoming, scheduled events), Event JSON-LD for Google.
- Home page in the required order: hero → introduction → news → upcoming events → recent events → highlights → gallery → committee → contact/social → footer.
- Contact + Membership forms: nonce, honeypot, time trap, per-IP rate limit, validation, e-mail notification, stored in dashboard.
- SEO: clean URLs, title tag, meta description, Open Graph/Twitter tags (auto-disabled if Yoast/Rank Math/SEOPress/AIOSEO is active), WordPress core XML sitemap at `/wp-sitemap.xml` (includes events, albums, committee, pages, posts).
- Accessibility: skip link, keyboard navigation, focus styles, ARIA on menu/lightbox, reduced-motion support.
- Performance: no external fonts or libraries, deferred script, native lazy-loading images, responsive image sizes.
- Security hardening: XML-RPC off, user enumeration blocked, generic login errors, non-staff kept out of `/wp-admin`, capability-based access.
- `theme.json` colour palette and fluid typography available in the block editor.

## 4. Before going live (recommended)

| Need | Recommendation |
|---|---|
| HTTPS | Enable SSL at the host; Settings → General → both URLs `https://` |
| Backups | Install **UpdraftPlus** (free) → schedule daily DB + weekly files to Google Drive/Dropbox. Restore: Settings → UpdraftPlus → Restore. Also take a host-level backup |
| Caching | One cache plugin only (WP Super Cache, LiteSpeed Cache or host cache). Exclude pages with forms if you see "error" after sending (nonce caching) |
| Image optimisation | ShortPixel/Imagify/EWWW, or upload web-sized JPGs (≤ 1600 px wide) |
| Strong security | Wordfence or Solid Security: 2-factor for admins, login-attempt limits. Use strong admin passwords; do not use `admin` as username |
| Extra spam protection | Optional: Cloudflare Turnstile (free) in front of the site |
| E-mail delivery | Install **WP Mail SMTP** so notifications reach your inbox (hosts often block `mail()`) |
| SEO plugin | Optional: Rank Math or Yoast for per-page SEO title/description fields |
| Logo | Appearance → Customize → Site Identity → upload Logo, site title and tagline |

## 5. Acceptance checklist

- [ ] Log in at `/wp-admin` as administrator; edit settings, pages, menus.
- [ ] Add an event (title, date, location, description, several photos) → appears in *Upcoming* on `/events/` and the home page.
- [ ] Change its date to the past → moves to *Recent Events*. Edit/trash it → public site updates.
- [ ] Add, edit, schedule, unpublish and delete a news post.
- [ ] Add an album with photos; open the lightbox.
- [ ] Add/edit a committee member; check order.
- [ ] Change hero text, phone, e-mail and social links in *ITA Settings*.
- [ ] Submit contact and membership forms; check e-mail and *Enquiries*.
- [ ] Log in as an Event Manager test user: can manage only own events, cannot see settings/users.
- [ ] View `/wp-sitemap.xml`; test on a phone.

## Notes
- Sample images are illustrations created for this package (no copyright issues); replace them with real event photos via Media Library / the event, album and committee screens.
- Menu: Appearance → Menus. Drag an item slightly right under another to make it a submenu; keep 5 top-level items for a tidy header. If you installed an earlier version of this package, re-activating the plugin rebuilds the menu into this 5-item structure (existing content is kept).
- Deactivating the plugin keeps your content in the database; reactivating restores everything (sample content is created only once).
