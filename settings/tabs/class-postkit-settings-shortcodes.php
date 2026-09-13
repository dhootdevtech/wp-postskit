<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostKit_Settings_Shortcodes {

	/**
	 * Render Shortcodes tab.
	 */
	public function render() {

		?>

		<div class="postkit-settings-section">

			<h2>
				<?php esc_html_e(
					'Shortcodes',
					'wp-postkit'
				); ?>
			</h2>

			<p class="description">
				<?php esc_html_e(
					'Use these shortcodes to manually display WP PostKit features in your content.',
					'wp-postkit'
				); ?>
			</p>


			<div class="postkit-shortcodes-list">


				<!-- Combined Metadata -->

				<div class="postkit-shortcode-card">

					<h3>
						<?php esc_html_e(
							'Post Metadata',
							'wp-postkit'
						); ?>
					</h3>

					<code>[postkit]</code>

					<p>
						<?php esc_html_e(
							'Displays the enabled WP PostKit metadata features together.',
							'wp-postkit'
						); ?>
					</p>

				</div>


				<!-- Reading Time -->

				<div class="postkit-shortcode-card">

					<h3>
						<?php esc_html_e(
							'Reading Time',
							'wp-postkit'
						); ?>
					</h3>

					<code>[postkit_reading_time]</code>

					<p>
						<?php esc_html_e(
							'Displays the estimated reading time of the post.',
							'wp-postkit'
						); ?>
					</p>

				</div>


				<!-- Word Count -->

				<div class="postkit-shortcode-card">

					<h3>
						<?php esc_html_e(
							'Word Count',
							'wp-postkit'
						); ?>
					</h3>

					<code>[postkit_word_count]</code>

					<p>
						<?php esc_html_e(
							'Displays the total word count of the post.',
							'wp-postkit'
						); ?>
					</p>

				</div>


				<!-- Post Views -->

				<div class="postkit-shortcode-card">

					<h3>
						<?php esc_html_e(
							'Post Views',
							'wp-postkit'
						); ?>
					</h3>

					<code>[postkit_views]</code>

					<p>
						<?php esc_html_e(
							'Displays the number of views for the post.',
							'wp-postkit'
						); ?>
					</p>

				</div>


				<!-- Likes -->

				<div class="postkit-shortcode-card">

					<h3>
						<?php esc_html_e(
							'Likes',
							'wp-postkit'
						); ?>
					</h3>

					<code>[postkit_likes]</code>

					<p>
						<?php esc_html_e(
							'Displays the Like button and current like count.',
							'wp-postkit'
						); ?>
					</p>

				</div>


				<!-- Table of Contents -->

				<div class="postkit-shortcode-card">

					<h3>
						<?php esc_html_e(
							'Table of Contents',
							'wp-postkit'
						); ?>
					</h3>

					<code>[postkit_toc]</code>

					<p>
						<?php esc_html_e(
							'Displays a table of contents generated from the post headings.',
							'wp-postkit'
						); ?>
					</p>

				</div>


			</div>

		</div>

		<?php
	}
}