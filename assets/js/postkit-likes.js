document.addEventListener('DOMContentLoaded', function () {

	const likeButtons = document.querySelectorAll(
		'.postkit-like-button'
	);

	/**
	 * Get Like button settings.
	 */
	const heartSettings = postKitLikes.heart || {};

	const heartIcon = heartSettings.icon || 'outline';

	const heartSize = heartSettings.size || 16;

	const heartColor = heartSettings.color || '#666666';

	const heartLikedColor =
		heartSettings.likedColor || '#e0245e';


	/**
	 * Get heart character.
	 */
	function getHeartCharacter() {

		if (heartIcon === 'filled') {
			return '♥';
		}

		return '♡';

	}


	/**
	 * Update heart appearance.
	 */
	function updateHeart( button, liked ) {

	const icon = button.querySelector(
		'.postkit-like-icon'
	);

	if ( ! icon ) {
		return;
	}

	icon.textContent = getHeartCharacter();

	icon.style.setProperty(
		'font-size',
		heartSize + 'px',
		'important'
	);

	icon.style.setProperty(
		'color',
		liked
			? heartLikedColor
			: heartColor,
		'important'
	);

}


	likeButtons.forEach(function (button) {

		button.addEventListener('click', function () {

			if (button.disabled) {
				return;
			}

			const postId = button.getAttribute(
				'data-post-id'
			);

			if (!postId) {
				return;
			}

			button.disabled = true;

			const formData = new FormData();

			formData.append(
				'action',
				'postkit_toggle_like'
			);

			formData.append(
				'post_id',
				postId
			);

			formData.append(
				'nonce',
				postKitLikes.nonce
			);

			fetch(
				postKitLikes.ajaxUrl,
				{
					method: 'POST',
					body: formData
				}
			)
			.then(function (response) {
				return response.json();
			})
			.then(function (data) {

				if (
					! data.success ||
					! data.data
				) {
					return;
				}

				const icon = button.querySelector(
					'.postkit-like-icon'
				);

				const label = button.querySelector(
					'.postkit-like-label'
				);

				const count = button.querySelector(
					'.postkit-like-count'
				);


				/**
				 * Update count.
				 */
				if (count) {
					count.textContent = data.data.likes;
				}


				/**
				 * Liked state.
				 */
				if (data.data.liked) {

					button.classList.add(
						'postkit-liked'
					);

					updateHeart(
						button,
						true
					);

					if (label) {
						label.textContent = 'Liked';
					}

				}


				/**
				 * Unliked state.
				 */
				else {

					button.classList.remove(
						'postkit-liked'
					);

					updateHeart(
						button,
						false
					);

					if (label) {
						label.textContent = 'Like';
					}

				}

			})
			.catch(function () {

				console.error(
					'WP PostKit: Like request failed.'
				);

			})
			.finally(function () {

				button.disabled = false;

			});

		});

	});

});