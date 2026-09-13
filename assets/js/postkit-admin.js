document.addEventListener('DOMContentLoaded', function () {

	const showIcons = document.getElementById(
		'postkit-show-icons'
	);

	const iconSize = document.getElementById(
		'postkit-icon-size'
	);

	const iconColor = document.getElementById(
		'postkit-icon-color'
	);

	if (
		! showIcons ||
		! iconSize ||
		! iconColor
	) {
		return;
	}

	const iconSizeRow = iconSize.closest('tr');
	const iconColorRow = iconColor.closest('tr');

	function updateIconFields() {

		const enabled = showIcons.checked;

		if (iconSizeRow) {
			iconSizeRow.style.display = enabled
				? ''
				: 'none';
		}

		if (iconColorRow) {
			iconColorRow.style.display = enabled
				? ''
				: 'none';
		}
	}

	showIcons.addEventListener(
		'change',
		updateIconFields
	);

	updateIconFields();

});