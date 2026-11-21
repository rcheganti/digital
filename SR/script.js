
(function addReadMoreStyles() {
  if (document.getElementById("propertyReadMoreStyles")) return;
  const style = document.createElement("style");
  style.id = "propertyReadMoreStyles";
  style.textContent = `
    .read-more-btn {
      display: inline-block; margin: 2px 0 12px; padding: 0;
      border: 0; background: transparent; color: #b78a36;
      font: inherit; font-weight: 700; text-decoration: underline;
      cursor: pointer;
    }
    .read-more-btn:hover { opacity: .8; }
    .property-description-formatted { line-height: 1.7; color: #333; }
    .property-description-formatted h3 { margin: 20px 0 8px; color: #172b4d; font-size: 18px; }
    .property-description-formatted h4 { margin: 16px 0 6px; color: #172b4d; font-size: 16px; }
    .property-description-formatted p { margin: 0 0 12px; }
    .property-description-formatted ul { margin: 6px 0 16px; padding-left: 22px; }
    .property-description-formatted li { margin: 5px 0; }
    .property-description-formatted .description-tagline { font-weight: 700; color: #a47725; font-size: 17px; margin: 14px 0; }
  `;
  document.head.appendChild(style);
})();


(function addGalleryStyles() {
  if (document.getElementById("propertyGalleryStyles")) return;
  const style = document.createElement("style");
  style.id = "propertyGalleryStyles";
  style.textContent = `
    .modal-media { position: relative; width: 100%; background: #111; overflow: hidden; }
    .gallery-stage { display: flex; align-items: center; justify-content: center; width: 100%; min-height: 220px; }
    .gallery-stage img, .gallery-stage video {
      display: block; width: 100%; max-height: 75vh; object-fit: contain; margin: auto;
    }
    .gallery-nav {
      position: absolute; top: 50%; transform: translateY(-50%); z-index: 5;
      width: 42px; height: 52px; border: 0; border-radius: 8px;
      background: rgba(0,0,0,.68); color: #fff; font-size: 34px;
      line-height: 1; cursor: pointer;
    }
    .gallery-prev { left: 12px; }
    .gallery-next { right: 12px; }
    .gallery-counter {
      position: absolute; right: 12px; bottom: 12px; z-index: 5;
      padding: 6px 11px; border-radius: 16px; color: #fff;
      background: rgba(0,0,0,.72); font-size: 13px;
    }
    .gallery-nav[hidden], .gallery-counter[hidden] { display: none !important; }
  `;
  document.head.appendChild(style);
})();

const properties = [
  {
    id: 1,
    name: "Iconic 6 – Premium Highway Facing Open Plots",
    location: "Solipur, Near Shadnagar",
    type: "Plot",
    purpose: "Buy",
    price: "₹38 Lakh",
    priceLakh: 38,
    bedrooms: 0,
    persqrd: "25299/-",
    area: "150 sq.yd.",
    thumbnail: "images/iconic6Thumb.webp",
    gallery: [
      { type: "video", src: "images/Iconic6/video1.mp4" },
      { type: "video", src: "images/Iconic6/video2.mp4" },
      { type: "video", src: "images/Iconic6/video3.mp4" },
      // Add more photos/videos for this property below:
      // { type: "image", src: "images/medchal-interior.jpeg" },
      // { type: "video", src: "images/medchal-walkthrough.mp4" }
    ],
    description: `
Iconic 6 – Premium Highway Facing Open Plots

Your Dream Investment Destination on Bengaluru Highway!

Discover Iconic 6, a premium open plot project strategically located near Shadnagar at Solipur, along the Bengaluru Highway.

Project Highlights

• Project Name: Iconic 6
• Location: Solipur, Near Shadnagar
• Road Connectivity: Bengaluru Highway Facing
• Approval: HMDA Approved
• Registration: RERA Certified Project
• Plot Size: 150 Sq. Yards
• Price: ₹25,299 per Sq. Yard

Why Choose Iconic 6?

• Prime Bengaluru Highway-facing location
• HMDA-approved layout
• RERA-registered project
• Ideal plot size for residential construction
• Convenient connectivity to Shadnagar

Invest Today. Build Your Tomorrow!

Own your piece of land at Iconic 6 and take a step towards a brighter future.

For Site Visits & Enquiries
Contact Us Today!
`
  },
  {
    id: 2,
    name: "Dream Valley 3 – Premium Farm Land Plots",
    location: "Near Shadnagar, Nagulapally",
    type: "Plot",
    purpose: "Buy",
    price: "₹16 Lakh",
    priceLakh: 16,
    bedrooms: 0,
    persqrd: "13099/-",
    area: "121 sq.yd.",
    thumbnail: "images/dreamValley3Thumb.jpeg",
    gallery: [
      { type: "video", src: "images/DreamValley3/video1.mp4" },
      { type: "video", src: "images/DreamValley3/video2.mp4" },
      { type: "video", src: "images/DreamValley3/video3.mp4" },
      // Add more photos/videos for this property below:
      // { type: "image", src: "images/medchal-interior.jpeg" },
      // { type: "video", src: "images/medchal-walkthrough.mp4" }
    ],
    description: `Discover a peaceful lifestyle and a smart investment opportunity at Dream Valley 3, a premium farmland project located near Shadnagar, Nagulapally, along Bangalore Highway (NH-44).

Enjoy the beauty of nature with modern recreational facilities and a resort-style lifestyle.

Project Highlights

•⁠  ⁠Location: Shadnagar, Nagulapally – Bangalore Highway (NH-44)
•⁠  ⁠Project Type: Premium Farm Land
•⁠  ⁠Plot Size: 121 Sq. Yards
•⁠  ⁠Price: ₹13,099 per Sq. Yard
•⁠  ⁠Resort Membership: Complimentary Resort Membership
•⁠  ⁠Amenities: Swimming Pool, Play Area and Indoor & Outdoor Games
•⁠  ⁠Fruit Plants: Fruit-bearing plants in your individual plots
•⁠  ⁠Maintenance: 10 Years of Company Maintenance
•⁠  ⁠Link Documents: 30 Years of Link Documents

Additional Benefits

•⁠  ⁠Enjoy a resort-style experience with premium recreational amenities.
•⁠  ⁠Experience greenery and nature with fruit plants in your own plot.
•⁠  ⁠Hassle-free maintenance for 10 years.
•⁠  ⁠Plot Registration: Registration within 7 days after completion of full payment.
- 
Additional Charges

Please Note: The following charges are applicable separately and are not included in the basic plot cost.

•⁠  ⁠Registration Charges – Extra
•⁠  ⁠East Facing Plot Charges – Extra
•⁠  ⁠North-East Facing Plot Charges – Extra
•⁠  ⁠Corner Plot Charges – Extra

Note: Final plot cost will vary depending on plot facing, corner location and applicable registration charges.
Own Your Piece of Nature!

Invest in farmland, enjoy resort-style amenities and create beautiful memories with your family at Dream Valley 3.

Book Your Plot Today!`
  },
  {
    id: 3,
    name: "Abharana – Premium Open Plots",
    location: "Sadhuvelly, near Yadagirigutta",
    type: "Plot",
    purpose: "Buy",
    price: "₹13 Lakh",
    priceLakh: 13,
    bedrooms: 0,
    persqrd: "11799/-",
    area: "110 sq.yd.",
    thumbnail: "images/abharanaThumb.jpeg",
    gallery: [
      { type: "video", src: "images/Abharana/video1.mp4" },
      // Add more photos/videos for this property below:
      // { type: "image", src: "images/medchal-interior.jpeg" },
      // { type: "video", src: "images/medchal-walkthrough.mp4" }
    ],
    description: `Discover a great investment opportunity at Abharana, a premium residential open plot project located at Sadhuvelly, near Yadagirigutta, along Warangal Highway (NH-163).

With DTCP and RERA approvals, excellent connectivity and modern development, Abharana offers an ideal opportunity for your future investment and dream home.

Project Highlights

•⁠  ⁠Project Name: Abharana
•⁠  ⁠Location: Sadhuvelly, Yadagirigutta
•⁠  ⁠Road Connectivity: Warangal Highway (NH-163)
•⁠  ⁠Temple Distance: Just 8 KM from Yadagirigutta Temple
•⁠  ⁠Approvals: DTCP & RERA Approved
•⁠  ⁠Plot Size: 110 Sq. Yards
•⁠  ⁠Price: ₹11,799 per Sq. Yard
•⁠  ⁠Company EMI: Available

Project Development & Amenities

•⁠  ⁠Well-planned project development
•⁠  ⁠Outdoor Sports Facilities
•⁠  ⁠Recreational Activities
•⁠  ⁠Space for outdoor games and activities

Additional Charges

The following charges are applicable separately:

•⁠  ⁠Registration Charges
•⁠  ⁠East Facing Plot Charges
•⁠  ⁠North-East Facing Plot Charges
•⁠  ⁠Corner Plot Charges

Why Choose Abharana?

•⁠  ⁠DTCP & RERA Approved Project
•⁠  ⁠Excellent connectivity through NH-163
•⁠  ⁠Close to Yadagirigutta Temple
•⁠  ⁠Company EMI Facility Available
•⁠  ⁠Developed with outdoor sports and recreational facilities

Invest Today, Secure Your Tomorrow!

Choose Abharana for a promising investment opportunity and a better lifestyle near Yadagirigutta.

Contact Us Today for Plot Availability, EMI Details & Site Visit!`
  },
  {
    id: 4,
    name: "Iconic 2, 3, 4 & 5 – Premium DTCP & RERA Approved Open Plots at Shadnagar",
    location: "Annaram Village, Shadnagar",
    type: "Plot",
    purpose: "Buy",
    price: "₹28 Lakh",
    priceLakh: 28,
    bedrooms: 0,
    persqrd: "18699/-",
    area: "150 sq.yd.",
    thumbnail: "images/Iiconic12345Thumb.jpeg",
    gallery: [
      { type: "image", src: "images/iconic12345/iconic12345.jpeg" },
      // Add more photos/videos for this property below:
      // { type: "image", src: "images/medchal-interior.jpeg" },
      // { type: "video", src: "images/medchal-walkthrough.mp4" }
    ],
    description: `Your Perfect Destination for Smart Investment & Future Growth!

Discover Iconic 2, 3, 4 & 5, a premium open plot venture located at Annaram Village, Shadnagar. Spread across a vast 150-acre development, this project offers an excellent opportunity for those looking to invest in land or build their dream home.

With DTCP and RERA approvals, convenient bank loan facilities, and well-planned residential plots, Iconic 2, 3, 4 & 5 is an ideal choice for your future investment.

Project Highlights

•⁠  ⁠Project Name: Iconic 2, 3, 4 & 5
•⁠  ⁠Location: Annaram Village, Shadnagar
•⁠  ⁠Total Project Area: 150 Acres
•⁠  ⁠Approvals: DTCP & RERA Approved
•⁠  ⁠Plot Size: 150 Square Yards
•⁠  ⁠Price: ₹18,699 per Square Yard
•⁠  ⁠Bank Loan: IDBI Bank Loan Available

Why Choose Iconic 2, 3, 4 & 5?

•⁠  ⁠DTCP & RERA Approved Project
•⁠  ⁠Spacious 150 Sq. Yards Plots
•⁠  ⁠Located at Annaram Village, Shadnagar
•⁠  ⁠Large-Scale 150-Acre Development
•⁠  ⁠IDBI Bank Loan Facility Available
•⁠  ⁠Suitable for Investment and Future Home Construction

Book Your Plot Today!

Invest in a promising location and take a step towards securing your future with Iconic 2, 3, 4 & 5 at Shadnagar.

For Site Visits & More Details, Contact Us Today!`
  },
  {
    id: 5,
    name: "Spring City – Premium DTCP & RERA Approved Open Plots at Shadnagar",
    location: "Chinchod Village, Shadnagar",
    type: "Plot",
    purpose: "Buy",
    price: "₹16 Lakh",
    priceLakh: 16,
    bedrooms: 0,
    persqrd: "10899/-",
    area: "150 sq.yd.",
    thumbnail: "images/SpringCityThumb.jpeg",
    gallery: [
      { type: "image", src: "images/SpringCity/SpringCity.jpeg" },
      // Add more photos/videos for this property below:
      // { type: "image", src: "images/medchal-interior.jpeg" },
      // { type: "video", src: "images/medchal-walkthrough.mp4" }
    ],
    description: `Your Perfect Destination for Smart Investment & Future Growth!

Discover Iconic 2, 3, 4 & 5, a premium open plot venture located at Annaram Village, Shadnagar. Spread across a vast 150-acre development, this project offers an excellent opportunity for those looking to invest in land or build their dream home.

With DTCP and RERA approvals, convenient bank loan facilities, and well-planned residential plots, Iconic 2, 3, 4 & 5 is an ideal choice for your future investment.

Project Highlights

•⁠  ⁠Project Name: Iconic 2, 3, 4 & 5
•⁠  ⁠Location: Annaram Village, Shadnagar
•⁠  ⁠Total Project Area: 150 Acres
•⁠  ⁠Approvals: DTCP & RERA Approved
•⁠  ⁠Plot Size: 150 Square Yards
•⁠  ⁠Price: ₹18,699 per Square Yard
•⁠  ⁠Bank Loan: IDBI Bank Loan Available

Why Choose Iconic 2, 3, 4 & 5?

•⁠  ⁠DTCP & RERA Approved Project
•⁠  ⁠Spacious 150 Sq. Yards Plots
•⁠  ⁠Located at Annaram Village, Shadnagar
•⁠  ⁠Large-Scale 150-Acre Development
•⁠  ⁠IDBI Bank Loan Facility Available
•⁠  ⁠Suitable for Investment and Future Home Construction

Book Your Plot Today!

Invest in a promising location and take a step towards securing your future with Iconic 2, 3, 4 & 5 at Shadnagar.

For Site Visits & More Details, Contact Us Today!`
  }


  /*{
    id: 2,
    name: "Luxury Green Park Villa",
    location: "Girmapur, Hyderabad",
    type: "Villa",
    purpose: "Buy",
    price: "₹1.5 Crore",
    priceLakh: 150,
    bedrooms: 3,
    area: "120 sq.yrd. Total sft 1460",
    persft: "7500/-",
    thumbnail: "images/villa-thumb.jpeg",
    gallery: [
      { type: "image", src: "images/villaGirmapur.jpeg" },
      // Add more photos/videos for this property below:
      // { type: "image", src: "images/villa-bedroom.jpeg" },
      // { type: "video", src: "images/villa-tour.mp4" }
    ],
    description: "Spacious premium villa with elegant interiors, generous living spaces and a peaceful residential setting."
  },
  {
    id: 3,
    name: "High Growth Investment Plot",
    location: "Yadadri, Hyderabad",
    type: "Plot",
    purpose: "Buy",
    price: "₹13 Lakh",
    priceLakh: 13,
    bedrooms: 0,
    bathrooms: 0,
    area: "110 sq.yd.",
    thumbnail: "images/openPlot1-thumb.jpeg",
    gallery: [
      { type: "image", src: "images/openPlot1.jpeg" },
      // Add more photos/videos for this property below:
      // { type: "image", src: "images/openPlot1-road.jpeg" }
    ],
    description: "A promising plot opportunity suited for long-term investment and future development in a growing corridor."
  },
  {
    id: 4,
    name: "High Growth Investment Plot",
    location: "Shadnagar, Hyderabad",
    type: "Plot",
    purpose: "Buy",
    price: "₹16,09,179",
    priceLakh: 16.09179,
    bedrooms: 0,
    bathrooms: 0,
    area: "120 sq.yd. | ₹13,299 per sq.yd.",
    thumbnail: "images/openPlot2-thumb.jpeg",
    gallery: [
      { type: "image", src: "images/openPlot2.jpeg" },
      // Add more photos/videos for this property below:
      // { type: "video", src: "images/openPlot2-sitevideo.mp4" }
    ],
    description: "A promising plot opportunity suited for long-term investment and future development in a growing corridor."
  },
  {
    id: 5,
    name: "High Growth Investment Plot",
    location: "Shadnagar, Hyderabad",
    type: "Plot",
    purpose: "Buy",
    price: "₹13 Lakh",
    priceLakh: 13,
    bedrooms: 0,
    bathrooms: 0,
    area: "120 sq.yd.",
    thumbnail: "images/openPlot3-thumb.jpeg",
    gallery: [
      { type: "image", src: "images/openPlot3.jpeg" },
      // Add more photos/videos for this property below:
      // { type: "image", src: "images/openPlot3-layout.jpeg" }
    ],
    description: "A promising plot opportunity suited for long-term investment and future development in a growing corridor."
  }*/
];

const grid = document.getElementById("propertyGrid");
const noResults = document.getElementById("noResults");
const modal = document.getElementById("propertyModal");

let selectedEnquiryProperty = null;

function startEnquiry(id) {
  const p = properties.find(x => x.id === id);
  if (!p) return;

  selectedEnquiryProperty = p;
  document.getElementById("enquiryProperty").value = `${p.name} — ${p.location}`;
  document.getElementById("selectedProperty").textContent =
    `Enquiring about: ${p.name} (${p.location})`;
  document.getElementById("enquiryInterest").value = p.type;
  document.getElementById("enquiryMessage").value =
    `Hi, I am interested in ${p.name} in ${p.location}. Please share the price, availability and site visit details.`;

  document.getElementById("contact").scrollIntoView({ behavior: "smooth", block: "start" });
  setTimeout(() => document.getElementById("enquiryName").focus(), 500);
}

function setFieldState(input, errorEl, valid, message = "") {
  input.classList.toggle("invalid", !valid);
  input.classList.toggle("valid", valid);
  errorEl.textContent = valid ? "" : message;
}

function validateEnquiry() {
  const name = document.getElementById("enquiryName");
  const phone = document.getElementById("enquiryPhone");
  const interest = document.getElementById("enquiryInterest");
  const property = document.getElementById("enquiryProperty");
  const message = document.getElementById("enquiryMessage");

  const nameOk = name.value.trim().length >= 2;
  const phoneOk = /^[6-9]\d{9}$/.test(phone.value.trim());
  const interestOk = interest.value !== "";
  const propertyOk = property.value.trim() !== "";
  const messageOk = message.value.trim().length >= 5;

  setFieldState(name, document.getElementById("nameError"), nameOk, "Please enter your name.");
  setFieldState(phone, document.getElementById("phoneError"), phoneOk, "Enter a valid 10-digit Indian mobile number.");
  setFieldState(interest, document.getElementById("interestError"), interestOk, "Please select a property type.");
  setFieldState(property, document.getElementById("propertyError"), propertyOk, "Please select a property first.");
  setFieldState(message, document.getElementById("messageError"), messageOk, "Please enter your requirement.");

  return nameOk && phoneOk && interestOk && propertyOk && messageOk;
}

document.getElementById("contactForm").addEventListener("submit", e => {
  e.preventDefault();
  const note = document.getElementById("formNote");
  note.textContent = "";

  if (!validateEnquiry()) {
    note.textContent = "Please correct the highlighted fields.";
    note.style.color = "#c62828";
    return;
  }

  const name = document.getElementById("enquiryName").value.trim();
  const phone = document.getElementById("enquiryPhone").value.trim();
  const interest = document.getElementById("enquiryInterest").value;
  const property = document.getElementById("enquiryProperty").value.trim();
  const message = document.getElementById("enquiryMessage").value.trim();

  const whatsappMessage =
    `Hi Sowmya Realestate,

I would like to enquire about a property.

Name: ${name}
Phone: ${phone}
Interested In: ${interest}
Property: ${property}
Requirement: ${message}

Please contact me with more details.`;

  window.open(`https://wa.me/919177440140?text=${encodeURIComponent(whatsappMessage)}`, "_blank", "noopener");
});

["enquiryName", "enquiryPhone", "enquiryInterest", "enquiryProperty", "enquiryMessage"]
  .forEach(id => {
    document.getElementById(id).addEventListener("input", () => validateEnquiry());
  });


function escapeDescriptionHTML(value) {
  return String(value).replace(/[&<>"']/g, character => ({
    "&": "&amp;", "<": "&lt;", ">": "&gt;", "\"": "&quot;", "'": "&#39;"
  }[character]));
}

// Converts plain-text descriptions into styled paragraphs, headings and bullet lists.
// In the property data, put each heading or bullet on its own line.
function formatPropertyDescription(description) {
  const lines = String(description || "").split(/\r?\n/);
  const output = [];
  let bullets = [];

  const flushBullets = () => {
    if (!bullets.length) return;
    output.push(`<ul>${bullets.map(item => `<li>${escapeDescriptionHTML(item)}</li>`).join("")}</ul>`);
    bullets = [];
  };

  lines.forEach(rawLine => {
    const line = rawLine.trim();
    if (!line) {
      flushBullets();
      return;
    }

    const bulletMatch = line.match(/^(?:•|[-*])\s*(.+)$/);
    if (bulletMatch) {
      bullets.push(bulletMatch[1]);
      return;
    }

    flushBullets();
    if (/^(Project Highlights|Why Choose .+\?|Features|Amenities|Location Advantages|Investment Benefits|For Site Visits & Enquiries)$/i.test(line)) {
      output.push(`<h3>${escapeDescriptionHTML(line)}</h3>`);
    } else if (/^(Your Dream .+!|Invest Today\..+|Own .+!)$/i.test(line)) {
      output.push(`<p class="description-tagline">${escapeDescriptionHTML(line)}</p>`);
    } else if (/^.{1,90}:$/.test(line)) {
      output.push(`<h4>${escapeDescriptionHTML(line)}</h4>`);
    } else {
      output.push(`<p>${escapeDescriptionHTML(line)}</p>`);
    }
  });

  flushBullets();
  return `<div class="property-description-formatted">${output.join("")}</div>`;
}

function getDescriptionPreview(description, maxWords = 150) {
  const words = String(description || "").trim().split(/\s+/).filter(Boolean);
  if (words.length <= maxWords) {
    return { text: words.join(" "), hasMore: false };
  }
  return {
    text: words.slice(0, maxWords).join(" ") + "...",
    hasMore: true
  };
}

function renderProperties(list = properties) {
  grid.innerHTML = list.map(p => `
    <article class="property-card">
      <div class="property-image" role="button" tabindex="0"
           aria-label="Open ${p.name} media"
           onclick="openModal(${p.id})"
           onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openModal(${p.id})}">
        <img src="${p.thumbnail}" alt="${p.name}" loading="lazy">
        <span class="tag">${p.type}</span>
        <span class="media-preview">${(p.gallery || []).some(item => item.type === "video") ? "▶ View Photos & Videos" : "View Photos"}</span>
      </div>

      <div class="property-body">
        <h3>${p.name}</h3>
        <div class="location">⌖ ${p.location}</div>
        <div class="price">${p.price}</div>
        <div class="stats">
          ${p.bedrooms ? `<span>🛏 ${p.bedrooms} Beds</span>` : ""}
          ${p.bathrooms ? `<span>◈ ${p.bathrooms} Baths</span>` : ""}
          ${p.persft ? `<span>● ${p.persft} per sq.ft.</span>` : ""}
          <span>▣ ${p.area}</span>
        </div>
        <p>${getDescriptionPreview(p.description, 25).text}</p>
        ${p.description
      ? `<button class="read-more-btn" type="button" onclick="event.stopPropagation(); openModal(${p.id})">Read more</button>`
      : ""}
        <div class="card-actions">
          <button class="btn btn-navy" onclick="openModal(${p.id})">View Details</button>
          <button class="btn btn-whatsapp" type="button" onclick="startEnquiry(${p.id})">WhatsApp</button>
        </div>
      </div>
    </article>
  `).join("");

  noResults.hidden = list.length !== 0;
}

function whatsappLink(p) {
  const msg = `Hi Sowmya Realestate, I am interested in ${p.name} in ${p.location}. Please share more details.`;
  return `https://wa.me/919177440140?text=${encodeURIComponent(msg)}`;
}

let activeGalleryProperty = null;
let activeGalleryIndex = 0;

function getPropertyGallery(property) {
  // Backward compatibility: also supports the earlier single-media format.
  if (Array.isArray(property.gallery) && property.gallery.length) {
    return property.gallery;
  }
  if (property.media) {
    return [{ type: property.mediaType || "image", src: property.media }];
  }
  return [];
}

function showGalleryItem(index) {
  if (!activeGalleryProperty) return;

  const gallery = getPropertyGallery(activeGalleryProperty);
  if (!gallery.length) return;

  // Keep the selected index within the available gallery items.
  activeGalleryIndex = (index + gallery.length) % gallery.length;

  const mediaContainer = document.getElementById("modalMedia");
  const item = gallery[activeGalleryIndex];

  // Stop the previous video before replacing the media element.
  const previousVideo = mediaContainer.querySelector("video");
  if (previousVideo) {
    previousVideo.pause();
    previousVideo.removeAttribute("src");
    previousVideo.load();
  }

  const stage = mediaContainer.querySelector(".gallery-stage");
  stage.replaceChildren();

  if (item.type === "video") {
    const video = document.createElement("video");
    video.src = item.src;
    video.controls = true;
    video.playsInline = true;
    video.preload = "metadata";
    video.setAttribute("aria-label", `${activeGalleryProperty.name} video ${activeGalleryIndex + 1}`);
    stage.appendChild(video);
  } else {
    const image = document.createElement("img");
    image.src = item.src;
    image.alt = `${activeGalleryProperty.name} photo ${activeGalleryIndex + 1}`;
    image.loading = "eager";
    stage.appendChild(image);
  }

  const counter = mediaContainer.querySelector(".gallery-counter");
  counter.textContent = `${activeGalleryIndex + 1} / ${gallery.length}`;

  const previousButton = mediaContainer.querySelector(".gallery-prev");
  const nextButton = mediaContainer.querySelector(".gallery-next");
  const hasMultiple = gallery.length > 1;

  previousButton.hidden = !hasMultiple;
  nextButton.hidden = !hasMultiple;
  counter.hidden = !hasMultiple;
}

function openModal(id) {
  const p = properties.find(x => x.id === id);
  if (!p) return;

  activeGalleryProperty = p;
  activeGalleryIndex = 0;

  const mediaContainer = document.getElementById("modalMedia");
  mediaContainer.replaceChildren();

  const stage = document.createElement("div");
  stage.className = "gallery-stage";

  const previousButton = document.createElement("button");
  previousButton.type = "button";
  previousButton.className = "gallery-nav gallery-prev";
  previousButton.textContent = "‹";
  previousButton.setAttribute("aria-label", "Previous photo or video");
  previousButton.addEventListener("click", () => showGalleryItem(activeGalleryIndex - 1));

  const nextButton = document.createElement("button");
  nextButton.type = "button";
  nextButton.className = "gallery-nav gallery-next";
  nextButton.textContent = "›";
  nextButton.setAttribute("aria-label", "Next photo or video");
  nextButton.addEventListener("click", () => showGalleryItem(activeGalleryIndex + 1));

  const counter = document.createElement("span");
  counter.className = "gallery-counter";

  mediaContainer.append(stage, previousButton, nextButton, counter);

  document.getElementById("modalType").textContent = p.type;
  document.getElementById("modalTitle").textContent = p.name;
  document.getElementById("modalLocation").textContent = "⌖ " + p.location;
  document.getElementById("modalPrice").textContent = p.price;
  document.getElementById("modalStats").innerHTML =
    `${p.bedrooms ? `<span>🛏 ${p.bedrooms} Bedrooms</span>` : ""}
     ${p.bathrooms ? `<span>◈ ${p.bathrooms} Bathrooms</span>` : ""}
     <span>▣ ${p.area}</span>
     <span>● ${p.purpose}</span>`;
  document.getElementById("modalDescription").innerHTML = formatPropertyDescription(p.description);

  document.getElementById("modalWhatsapp").onclick = e => {
    e.preventDefault();
    closeModal();
    startEnquiry(p.id);
  };

  showGalleryItem(0);

  modal.classList.add("open");
  modal.setAttribute("aria-hidden", "false");
  document.body.style.overflow = "hidden";
}

function closeModal() {
  const mediaContainer = document.getElementById("modalMedia");
  const video = mediaContainer.querySelector("video");
  if (video) {
    video.pause();
    video.removeAttribute("src");
    video.load();
  }
  mediaContainer.replaceChildren();

  activeGalleryProperty = null;
  activeGalleryIndex = 0;

  modal.classList.remove("open");
  modal.setAttribute("aria-hidden", "true");
  document.body.style.overflow = "";
}

document.getElementById("modalClose").addEventListener("click", closeModal);
document.getElementById("modalBackdrop").addEventListener("click", closeModal);
document.addEventListener("keydown", e => {
  if (!modal.classList.contains("open")) return;
  if (e.key === "Escape") closeModal();
  if (e.key === "ArrowLeft" && activeGalleryProperty) showGalleryItem(activeGalleryIndex - 1);
  if (e.key === "ArrowRight" && activeGalleryProperty) showGalleryItem(activeGalleryIndex + 1);
});

document.getElementById("searchForm").addEventListener("submit", e => {
  e.preventDefault();
  const location = document.getElementById("locationFilter").value.trim().toLowerCase();
  const type = document.getElementById("typeFilter").value;
  const budget = document.getElementById("budgetFilter").value;
  const purpose = document.getElementById("purposeFilter").value;

  const result = properties.filter(p => {
    const locationMatch = !location || p.location.toLowerCase().includes(location);
    const typeMatch = !type || p.type === type;
    const purposeMatch = !purpose || p.purpose === purpose;
    let budgetMatch = true;
    if (budget === "15") budgetMatch = p.priceLakh < 15;
    if (budget === "20") budgetMatch = p.priceLakh < 20;
    if (budget === "50") budgetMatch = p.priceLakh < 50;
    if (budget === "100") budgetMatch = p.priceLakh >= 50 && p.priceLakh <= 100;
    if (budget === "200") budgetMatch = p.priceLakh > 100 && p.priceLakh <= 200;
    if (budget === "999") budgetMatch = p.priceLakh > 200;

    return locationMatch && typeMatch && purposeMatch && budgetMatch;
  });

  renderProperties(result);
  document.getElementById("properties").scrollIntoView({ behavior: "smooth", block: "start" });
});

document.getElementById("resetFilters").addEventListener("click", () => {
  document.getElementById("searchForm").reset();
  renderProperties();
});

const menuToggle = document.getElementById("menuToggle");
const nav = document.getElementById("nav");

menuToggle.addEventListener("click", () => {
  const open = nav.classList.toggle("open");
  menuToggle.setAttribute("aria-expanded", open);
});

document.querySelectorAll(".nav a").forEach(a => {
  a.addEventListener("click", () => nav.classList.remove("open"));
});

renderProperties();
