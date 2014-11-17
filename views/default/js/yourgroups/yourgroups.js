// <script>

/**
 * Javascript for the yourgroups plugin
 */
define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');

	/**
	 * Repositions the yourgroups popup
	 *
	 * @param {String} hook    'getOptions'
	 * @param {String} type    'ui.popup'
	 * @param {Object} params  An array of info about the target and source.
	 * @param {Object} options Options to pass to
	 *
	 * @return {Object}
	 */
	var popupGroupsHandler = function(hook, type, params, options) {
		if (params.target.hasClass('elgg-groups-popup')) {
			options.my = 'left top';
			options.at = 'left bottom';
			options.collision = 'fit none';
			return options;
		}
		return null;
	};

	/**
	 * Fetch notifications and display them in the popup module.
	 *
	 * @param {Object} e
	 * @return void
	 */
	var popup = function(e) {
		elgg.get('yourgroups/popup', {
			success: function(output) {
				if (output) {
					// refresh the list
					$('#groups-popup > .elgg-body').html(output);
                    var t_options = new Array();
                    t_options[0] = $(output).find('li').length;
					// refresh the tooltip
					$('#groups-popup-link').attr('title',elgg.echo('yourgroups:tooltip', t_options));
			     }
			}
		});

		e.preventDefault();
	};

	$('#groups-popup-link').live('click', popup);

	elgg.register_hook_handler('getOptions', 'ui.popup', popupGroupsHandler);
});
