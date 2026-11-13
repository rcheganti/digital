(function () {
	// Mobile nav toggle.
	var btn = document.querySelector('.nav-toggle');
	var nav = document.getElementById('site-nav');
	if (btn && nav) {
		btn.addEventListener('click', function () {
			var open = nav.classList.toggle('open');
			btn.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	}

	// Lightbox for links with data-lightbox.
	var links = Array.prototype.slice.call(document.querySelectorAll('a[data-lightbox]'));
	if (!links.length) { return; }
	var box, img, cap, index = 0, opener = null;

	function build() {
		box = document.createElement('div');
		box.className = 'ita-lb';
		box.setAttribute('role', 'dialog');
		box.setAttribute('aria-modal', 'true');
		box.setAttribute('aria-label', 'Photo viewer');
		box.innerHTML = '<button class="lb-close" aria-label="Close">&times;</button><button class="lb-prev" aria-label="Previous photo">&#8249;</button><button class="lb-next" aria-label="Next photo">&#8250;</button><figure style="margin:0;text-align:center"><img alt=""><figcaption></figcaption></figure>';
		img = box.querySelector('img');
		cap = box.querySelector('figcaption');
		box.querySelector('.lb-close').addEventListener('click', close);
		box.querySelector('.lb-prev').addEventListener('click', function () { show(index - 1); });
		box.querySelector('.lb-next').addEventListener('click', function () { show(index + 1); });
		box.addEventListener('click', function (e) { if (e.target === box) { close(); } });
		document.body.appendChild(box);
	}
	function show(i) {
		index = (i + links.length) % links.length;
		img.src = links[index].href;
		img.alt = (links[index].querySelector('img') || {}).alt || '';
		cap.textContent = links[index].getAttribute('data-caption') || '';
	}
	function open(i, el) {
		opener = el;
		if (!box) { build(); }
		show(i);
		document.body.style.overflow = 'hidden';
		box.querySelector('.lb-close').focus();
		document.addEventListener('keydown', key);
	}
	function close() {
		if (box) { box.remove(); box = null; }
		document.body.style.overflow = '';
		document.removeEventListener('keydown', key);
		if (opener) { opener.focus(); }
	}
	function key(e) {
		if (e.key === 'Escape') { close(); }
		else if (e.key === 'ArrowLeft') { show(index - 1); }
		else if (e.key === 'ArrowRight') { show(index + 1); }
	}
	links.forEach(function (a, i) {
		a.addEventListener('click', function (e) { e.preventDefault(); open(i, a); });
	});
})();
