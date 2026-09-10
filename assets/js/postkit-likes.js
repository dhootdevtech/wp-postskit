document.addEventListener('DOMContentLoaded', function () {

	const likeButtons = document.querySelectorAll(
		'.postkit-like-button'
	);

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

				if (count) {
					count.textContent = data.data.likes;
				}

				if (data.data.liked) {

					button.classList.add(
						'postkit-liked'
					);

					if (icon) {
						icon.textContent = '♥';
					}

					if (label) {
						label.textContent = 'Liked';
					}

				} else {

					button.classList.remove(
						'postkit-liked'
					);

					if (icon) {
						icon.textContent = '♡';
					}

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