<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostKit_Settings_General {

	/**
	 * Render General tab.
	 */
	public function render( $settings ) {

		?>

		<!-- Post Features -->

		<h2>
			<?php esc_html_e(
				'Post Features',
				'wp-postkit'
			); ?>
		</h2>

		<table class="form-table" role="presentation">

			<tbody>


				<!-- Reading Time -->

				<tr>

					<th scope="row">
						<label for="postkit-reading-time">
							<?php esc_html_e(
								'Reading Time',
								'wp-postkit'
							); ?>
						</label>
					</th>

					<td>

						<label>

							<input
								type="checkbox"
								id="postkit-reading-time"
								name="postkit_settings[reading_time]"
								value="1"
								<?php checked(
									! empty(
										$settings['reading_time']
									)
								); ?>
							>

							<?php esc_html_e(
								'Enable reading time',
								'wp-postkit'
							); ?>

						</label>

					</td>

				</tr>


				<!-- Word Count -->

				<tr>

					<th scope="row">
						<label for="postkit-word-count">
							<?php esc_html_e(
								'Word Count',
								'wp-postkit'
							); ?>
						</label>
					</th>

					<td>

						<label>

							<input
								type="checkbox"
								id="postkit-word-count"
								name="postkit_settings[word_count]"
								value="1"
								<?php checked(
									! empty(
										$settings['word_count']
									)
								); ?>
							>

							<?php esc_html_e(
								'Enable word count',
								'wp-postkit'
							); ?>

						</label>

					</td>

				</tr>


				<!-- Table of Contents -->

				<tr>

					<th scope="row">
						<label for="postkit-toc">
							<?php esc_html_e(
								'Table of Contents',
								'wp-postkit'
							); ?>
						</label>
					</th>

					<td>

						<label>

							<input
								type="checkbox"
								id="postkit-toc"
								name="postkit_settings[toc]"
								value="1"
								<?php checked(
									! empty(
										$settings['toc']
									)
								); ?>
							>

							<?php esc_html_e(
								'Enable table of contents',
								'wp-postkit'
							); ?>

						</label>

					</td>

				</tr>


				<!-- Views -->

				<tr>

					<th scope="row">
						<label for="postkit-views">
							<?php esc_html_e(
								'Post Views',
								'wp-postkit'
							); ?>
						</label>
					</th>

					<td>

						<label>

							<input
								type="checkbox"
								id="postkit-views"
								name="postkit_settings[views]"
								value="1"
								<?php checked(
									! empty(
										$settings['views']
									)
								); ?>
							>

							<?php esc_html_e(
								'Enable post views',
								'wp-postkit'
							); ?>

						</label>

					</td>

				</tr>


				<!-- Likes -->

				<tr>

					<th scope="row">
						<label for="postkit-likes">
							<?php esc_html_e(
								'Likes',
								'wp-postkit'
							); ?>
						</label>
					</th>

					<td>

						<label>

							<input
								type="checkbox"
								id="postkit-likes"
								name="postkit_settings[likes]"
								value="1"
								<?php checked(
									! empty(
										$settings['likes']
									)
								); ?>
							>

							<?php esc_html_e(
								'Enable likes',
								'wp-postkit'
							); ?>

						</label>

					</td>

				</tr>

			</tbody>

		</table>


		<!-- Reading Speed -->

		<h2>
			<?php esc_html_e(
				'Reading Settings',
				'wp-postkit'
			); ?>
		</h2>

		<table class="form-table" role="presentation">

			<tbody>

				<tr>

					<th scope="row">

						<label for="postkit-reading-speed">

							<?php esc_html_e(
								'Reading Speed',
								'wp-postkit'
							); ?>

						</label>

					</th>

					<td>

						<input
							type="number"
							id="postkit-reading-speed"
							name="postkit_settings[reading_speed]"
							value="<?php echo esc_attr(
								$settings['reading_speed']
							); ?>"
							min="1"
							max="1000"
							class="small-text"
						>

						<span>
							<?php esc_html_e(
								'words per minute',
								'wp-postkit'
							); ?>
						</span>

						<p class="description">

							<?php esc_html_e(
								'Used to calculate estimated reading time.',
								'wp-postkit'
							); ?>

						</p>

					</td>

				</tr>

			</tbody>

		</table>


		<!-- Automatic Post Meta -->

		<h2>
			<?php esc_html_e(
				'Automatic Post Meta',
				'wp-postkit'
			); ?>
		</h2>

		<table class="form-table" role="presentation">

			<tbody>

				<tr>

					<th scope="row">

						<?php esc_html_e(
							'Display metadata',
							'wp-postkit'
						); ?>

					</th>

					<td>


						<label>

							<input
								type="radio"
								name="postkit_settings[meta_display]"
								value="disabled"
								<?php checked(
									$settings['meta_display'],
									'disabled'
								); ?>
							>

							<?php esc_html_e(
								"Don't display automatically",
								'wp-postkit'
							); ?>

						</label>

						<br>


						<label>

							<input
								type="radio"
								name="postkit_settings[meta_display]"
								value="before"
								<?php checked(
									$settings['meta_display'],
									'before'
								); ?>
							>

							<?php esc_html_e(
								'Display before post content',
								'wp-postkit'
							); ?>

						</label>

						<br>


						<label>

							<input
								type="radio"
								name="postkit_settings[meta_display]"
								value="after"
								<?php checked(
									$settings['meta_display'],
									'after'
								); ?>
							>

							<?php esc_html_e(
								'Display after post content',
								'wp-postkit'
							); ?>

						</label>


						<p class="description">

							<?php esc_html_e(
								'This controls automatic metadata placement. The [postkit] shortcode works independently.',
								'wp-postkit'
							); ?>

						</p>

					</td>

				</tr>

			</tbody>

		</table>

		<?php

	}

}