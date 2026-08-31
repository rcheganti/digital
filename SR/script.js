const properties = [
  {id:1,name:"Medchal Standalone building",location:"Medchal, Hyderabad",type:"Apartment",purpose:"Buy",price:"₹60 Lakh",priceLakh:60,bedrooms:2,persft:"4999/-",area:"1,200 sq.ft.",image:"images/medchal2bhk1.jpeg",description:"A modern 2 BHK apartment designed for comfortable family living, with excellent access to everyday amenities and connectivity. Near Yashoda Nursing Training Center"},
  {id:2,name:"Luxury Garden Villa",location:"Kompally, Hyderabad",type:"Villa",purpose:"Buy",price:"₹1.65 Crore",priceLakh:165,bedrooms:3,bathrooms:3,area:"2,450 sq.ft.",image:"https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=900&q=85",description:"Spacious premium villa with elegant interiors, generous living spaces and a peaceful residential setting."},
  {id:3,name:"High Growth Investment Plot",location:"Shadnagar, Hyderabad",type:"Plot",purpose:"Buy",price:"₹32 Lakh",priceLakh:32,bedrooms:0,bathrooms:0,area:"200 sq.yd.",image:"https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=900&q=85",description:"A promising plot opportunity suited for long-term investment and future development in a growing corridor."},
  {id:4,name:"Skyline 3 BHK Residence",location:"Miyapur, Hyderabad",type:"Apartment",purpose:"Buy",price:"₹1.12 Crore",priceLakh:112,bedrooms:3,bathrooms:3,area:"1,850 sq.ft.",image:"https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?auto=format&fit=crop&w=900&q=85",description:"Well-planned 3 BHK residence with contemporary finishes and convenient urban connectivity."},
  {id:5,name:"Premium Commercial Space",location:"Bachupally, Hyderabad",type:"Commercial",purpose:"Buy",price:"₹2.35 Crore",priceLakh:235,bedrooms:0,bathrooms:2,area:"3,100 sq.ft.",image:"https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=900&q=85",description:"Professional commercial space suitable for offices, clinics, studios or other business requirements."},
  {id:6,name:"Family Villa Retreat",location:"Shamshabad, Hyderabad",type:"Villa",purpose:"Buy",price:"₹98 Lakh",priceLakh:98,bedrooms:3,bathrooms:3,area:"1,900 sq.ft.",image:"https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=900&q=85",description:"Comfortable family villa with a balanced layout, peaceful surroundings and convenient access to key areas."}
];

const grid = document.getElementById("propertyGrid");
const noResults = document.getElementById("noResults");
const modal = document.getElementById("propertyModal");


let selectedEnquiryProperty = null;

function startEnquiry(id){
  const p = properties.find(x => x.id === id);
  if(!p) return;
  selectedEnquiryProperty = p;
  document.getElementById("enquiryProperty").value = `${p.name} — ${p.location}`;
  document.getElementById("selectedProperty").textContent = `Enquiring about: ${p.name} (${p.location})`;
  document.getElementById("enquiryInterest").value = p.type;
  document.getElementById("enquiryMessage").value = `Hi, I am interested in ${p.name} in ${p.location}. Please share the price, availability and site visit details.`;
  document.getElementById("contact").scrollIntoView({behavior:"smooth", block:"start"});
  setTimeout(() => document.getElementById("enquiryName").focus(), 500);
}

function setFieldState(input, errorEl, valid, message=""){
  input.classList.toggle("invalid", !valid);
  input.classList.toggle("valid", valid);
  errorEl.textContent = valid ? "" : message;
}

function validateEnquiry(){
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

  if(!validateEnquiry()){
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

  window.open(`https://wa.me/919177440140?text=${encodeURIComponent(whatsappMessage)}`, "_blank");
});

["enquiryName","enquiryPhone","enquiryInterest","enquiryProperty","enquiryMessage"].forEach(id => {
  document.getElementById(id).addEventListener("input", () => validateEnquiry());
});

function renderProperties(list = properties){
  grid.innerHTML = list.map(p => `
    <article class="property-card">
      <div class="property-image">
        <img src="${p.image}" alt="${p.name}" loading="lazy">
        <span class="tag">${p.type}</span>
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
        <p>${p.description}</p>
        <div class="card-actions">
          <button class="btn btn-navy" onclick="openModal(${p.id})">View Details</button>
          <button class="btn btn-whatsapp" type="button" onclick="startEnquiry(${p.id})">WhatsApp</button>
        </div>
      </div>
    </article>`).join("");
  noResults.hidden = list.length !== 0;
}

function whatsappLink(p){
  const msg = `Hi Sowmya Realestate, I am interested in ${p.name} in ${p.location}. Please share more details.`;
  return `https://wa.me/919177440140?text=${encodeURIComponent(msg)}`;
}

function openModal(id){
  const p = properties.find(x => x.id === id);
  if(!p) return;
  document.getElementById("modalImage").src = p.image;
  document.getElementById("modalImage").alt = p.name;
  document.getElementById("modalType").textContent = p.type;
  document.getElementById("modalTitle").textContent = p.name;
  document.getElementById("modalLocation").textContent = "⌖ " + p.location;
  document.getElementById("modalPrice").textContent = p.price;
  document.getElementById("modalStats").innerHTML =
    `${p.bedrooms ? `<span>🛏 ${p.bedrooms} Bedrooms</span>` : ""}
     ${p.bathrooms ? `<span>◈ ${p.bathrooms} Bathrooms</span>` : ""}
     <span>▣ ${p.area}</span><span>● ${p.purpose}</span>`;
  document.getElementById("modalDescription").textContent = p.description;
  document.getElementById("modalWhatsapp").onclick = (e) => {
    e.preventDefault();
    closeModal();
    startEnquiry(p.id);
  };
  modal.classList.add("open");
  modal.setAttribute("aria-hidden","false");
  document.body.style.overflow = "hidden";
}
function closeModal(){
  modal.classList.remove("open");
  modal.setAttribute("aria-hidden","true");
  document.body.style.overflow = "";
}
document.getElementById("modalClose").addEventListener("click", closeModal);
document.getElementById("modalBackdrop").addEventListener("click", closeModal);
document.addEventListener("keydown", e => { if(e.key === "Escape") closeModal(); });

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
    if(budget === "50") budgetMatch = p.priceLakh < 50;
    if(budget === "100") budgetMatch = p.priceLakh >= 50 && p.priceLakh <= 100;
    if(budget === "200") budgetMatch = p.priceLakh > 100 && p.priceLakh <= 200;
    if(budget === "999") budgetMatch = p.priceLakh > 200;
    return locationMatch && typeMatch && purposeMatch && budgetMatch;
  });
  renderProperties(result);
  document.getElementById("properties").scrollIntoView({behavior:"smooth",block:"start"});
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
document.querySelectorAll(".nav a").forEach(a => a.addEventListener("click", () => nav.classList.remove("open")));


renderProperties();
