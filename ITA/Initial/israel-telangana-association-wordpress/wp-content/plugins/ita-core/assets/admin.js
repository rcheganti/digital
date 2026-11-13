jQuery(function ($) {
	function sync($box) {
		var ids = $box.find('li').map(function () { return $(this).data('id'); }).get();
		$box.find('input[type=hidden]').val(ids.join(','));
	}

	$('.ita-gallery-list').sortable({
		items: 'li',
		update: function () { sync($(this).closest('.ita-gallery-box')); }
	});

	$(document).on('click', '.ita-gallery-add', function (e) {
		e.preventDefault();
		var $box = $(this).closest('.ita-gallery-box');
		var frame = wp.media({
			title: 'Select photos',
			button: { text: 'Add to gallery' },
			multiple: true,
			library: { type: 'image' }
		});
		frame.on('select', function () {
			frame.state().get('selection').each(function (att) {
				var a = att.toJSON();
				if ($box.find('li[data-id="' + a.id + '"]').length) { return; }
				var src = (a.sizes && a.sizes.thumbnail) ? a.sizes.thumbnail.url : a.url;
				var $li = $('<li>').attr('data-id', a.id);
				$li.append($('<img>').attr({ src: src, alt: '' }));
				$li.append($('<button type="button" class="ita-gallery-remove" aria-label="Remove photo">&times;</button>'));
				$box.find('ul').append($li);
			});
			sync($box);
		});
		frame.open();
	});

	$(document).on('click', '.ita-gallery-remove', function () {
		var $box = $(this).closest('.ita-gallery-box');
		$(this).closest('li').remove();
		sync($box);
	});

	// Single image picker (settings page).
	$(document).on('click', '.ita-media-pick', function (e) {
		e.preventDefault();
		var $wrap = $(this).closest('.ita-media-field');
		var frame = wp.media({ title: 'Select image', multiple: false, library: { type: 'image' } });
		frame.on('select', function () {
			var a = frame.state().get('selection').first().toJSON();
			var src = (a.sizes && a.sizes.medium) ? a.sizes.medium.url : a.url;
			$wrap.find('input[type=hidden]').val(a.id);
			$wrap.find('.ita-media-preview').html('<img src="' + src + '" alt="">');
		});
		frame.open();
	});
	$(document).on('click', '.ita-media-clear', function (e) {
		e.preventDefault();
		var $wrap = $(this).closest('.ita-media-field');
		$wrap.find('input[type=hidden]').val('');
		$wrap.find('.ita-media-preview').empty();
	});
});
