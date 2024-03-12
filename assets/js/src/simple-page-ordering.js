import '../../css/scss/simple-page-ordering.scss';

import { decodeEntities } from '@wordpress/html-entities';

// eslint-disable-next-line import/no-unresolved
import 'jquery-ui-sortable';

const sortable_post_table = jQuery('.wp-list-table tbody');
function update_simple_ordering_callback(response) {
	if (response === 'children') {
		window.location.reload();
		return;
	}

	const changes = jQuery.parseJSON(response);

	const { new_pos } = changes;
	// eslint-disable-next-line no-restricted-syntax
	for (const key in new_pos) {
		if (key === 'next') {
			// eslint-disable-next-line no-continue
			continue;
		}

		const inline_key = document.getElementById(`inline_${key}`);
		// eslint-disable-next-line no-prototype-builtins
		if (inline_key !== null && new_pos.hasOwnProperty(key)) {
			const dom_menu_order = inline_key.querySelector('.menu_order');

			if (undefined !== new_pos[key].menu_order) {
				if (dom_menu_order !== null) {
					dom_menu_order.textContent = new_pos[key].menu_order;
				}

				const dom_post_parent = inline_key.querySelector('.post_parent');
				if (dom_post_parent !== null) {
					dom_post_parent.textContent = new_pos[key].post_parent;
				}

				let post_title = null;
				const dom_post_title = inline_key.querySelector('.post_title');
				if (dom_post_title !== null) {
					post_title = dom_post_title.innerHTML;
				}

				let dashes = 0;
				while (dashes < new_pos[key].depth) {
					post_title = `&mdash; ${post_title}`;
					dashes++;
				}
				const dom_row_title = inline_key.parentNode.querySelector('.row-title');
				if (dom_row_title !== null && post_title !== null) {
					dom_row_title.textContent = decodeEntities(post_title);
				}
			} else if (dom_menu_order !== null) {
				dom_menu_order.textContent = new_pos[key];
			}
		}
	}

	if (changes.next) {
		jQuery.post(
			window.ajaxurl,
			{
				action: 'simple_page_ordering',
				id: changes.next.id,
				previd: changes.next.previd,
				nextid: changes.next.nextid,
				start: changes.next.start,
				_wpnonce: window.simple_page_ordering_localized_data._wpnonce,
				excluded: JSON.stringify(changes.next.excluded),
			},
			update_simple_ordering_callback,
		);
	} else {
		jQuery('.spo-updating-row')
			.removeClass('spo-updating-row')
			.find('.check-column')
			.removeClass('spinner is-active');
		sortable_post_table.removeClass('spo-updating').sortable('enable');
	}
}

sortable_post_table.sortable({
	items: '> tr',
	cursor: 'move',
	axis: 'y',
	containment: 'table.widefat',
	cancel: 'input, textarea, button, select, option, .inline-edit-row',
	distance: 2,
	opacity: 0.8,
	tolerance: 'pointer',
	create() {
		jQuery(document).keydown(function (e) {
			const key = e.key || e.keyCode;
			if (key === 'Escape' || key === 'Esc' || key === 27) {
				sortable_post_table.sortable('option', 'preventUpdate', true);
				sortable_post_table.sortable('cancel');
			}
		});
	},
	start(e, ui) {
		if (typeof inlineEditPost !== 'undefined') {
			// eslint-disable-next-line no-undef
			inlineEditPost.revert();
		}
		ui.placeholder.height(ui.item.height());
		ui.placeholder.empty();
	},
	helper(e, ui) {
		const children = ui.children();
		for (let i = 0; i < children.length; i++) {
			const selector = jQuery(children[i]);
			selector.width(selector.width());
		}
		return ui;
	},
	stop(e, ui) {
		if (sortable_post_table.sortable('option', 'preventUpdate')) {
			sortable_post_table.sortable('option', 'preventUpdate', false);
		}

		// remove fixed widths
		ui.item.children().css('width', '');
	},
	update(e, ui) {
		if (sortable_post_table.sortable('option', 'preventUpdate')) {
			sortable_post_table.sortable('option', 'preventUpdate', false);
			return;
		}

		sortable_post_table.sortable('disable').addClass('spo-updating');
		ui.item.addClass('spo-updating-row');
		ui.item.find('.check-column').addClass('spinner is-active');

		const postid = ui.item[0].id.substr(5); // post id

		let prevpostid = false;
		const prevpost = ui.item.prev();
		if (prevpost.length > 0) {
			prevpostid = prevpost.attr('id').substr(5);
		}

		let nextpostid = false;
		const nextpost = ui.item.next();
		if (nextpost.length > 0) {
			nextpostid = nextpost.attr('id').substr(5);
		}

		// go do the sorting stuff via ajax
		jQuery.post(
			window.ajaxurl,
			{
				action: 'simple_page_ordering',
				id: postid,
				previd: prevpostid,
				nextid: nextpostid,
				_wpnonce: window.simple_page_ordering_localized_data._wpnonce,
			},
			update_simple_ordering_callback,
		);

		// fix cell colors
		const table_rows = document.querySelectorAll('tr.iedit');
		let table_row_count = table_rows.length;
		while (table_row_count--) {
			if (table_row_count % 2 === 0) {
				jQuery(table_rows[table_row_count]).addClass('alternate');
			} else {
				jQuery(table_rows[table_row_count]).removeClass('alternate');
			}
		}
	},
});

jQuery(function () {
	// set up click handler for order reset link
	jQuery('#simple-page-ordering-reset').on('click', function (e) {
		e.preventDefault();
		const post_type = jQuery(this).data('posttype');
		if (
			// eslint-disable-next-line no-alert
			window.confirm(window.simple_page_ordering_localized_data.confirmation_msg)
		) {
			jQuery.post(
				window.ajaxurl,
				{
					action: 'reset_simple_page_ordering',
					post_type,
					_wpnonce: window.simple_page_ordering_localized_data._wpnonce,
				},
				function () {
					window.location.reload();
				},
			);
		}
	});
});
