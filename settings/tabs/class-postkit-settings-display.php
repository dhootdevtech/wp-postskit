<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostKit_Settings_Display {

	/**
	 * Render Display tab.
	 */
	public function render( $settings ) {

		?>

		<!-- Display Tab -->
<div
	class="postkit-tab-content"
	id="postkit-tab-display"
	
>

	<h2><?php esc_html_e( 'Display Settings', 'wp-postkit' ); ?></h2>

	<p class="description">
		<?php esc_html_e( 'Choose how PostKit metadata will be displayed on your posts.', 'wp-postkit' ); ?>
	</p>

	<div class="postkit-style-options">

		<!-- Style A -->
		<label class="postkit-style-card">

			<input
				type="radio"
				name="postkit_settings[display_style]"
				value="style_a"
				<?php checked(
					isset( $settings['display_style'] )
						? $settings['display_style']
						: 'style_a',
					'style_a'
				); ?>
			>

			<div class="postkit-style-card-content">

				<div class="postkit-style-card-header">
					<strong>
						<?php esc_html_e( 'Style A', 'wp-postkit' ); ?>
					</strong>

					<span class="postkit-style-name">
						<?php esc_html_e( 'Clean & Minimal', 'wp-postkit' ); ?>
					</span>
				</div>

				<div class="postkit-style-preview postkit-preview-a">

					<span>2 min read</span>

					<span class="postkit-preview-separator">·</span>

					<span>252 words</span>

					<span class="postkit-preview-separator">·</span>

					<span>1,245 views</span>

					<span class="postkit-preview-separator">·</span>

					<span>♡ Like 24</span>

				</div>

				<p class="postkit-style-description">
					<?php esc_html_e(
						'Simple and clean look with minimal separators.',
						'wp-postkit'
					); ?>
				</p>

			</div>

		</label>


		<!-- Style B -->
		<label class="postkit-style-card">

			<input
				type="radio"
				name="postkit_settings[display_style]"
				value="style_b"
				<?php checked(
					isset( $settings['display_style'] )
						? $settings['display_style']
						: 'style_a',
					'style_b'
				); ?>
			>

			<div class="postkit-style-card-content">

				<div class="postkit-style-card-header">
					<strong>
						<?php esc_html_e( 'Style B', 'wp-postkit' ); ?>
					</strong>

					<span class="postkit-style-name">
						<?php esc_html_e( 'Divided', 'wp-postkit' ); ?>
					</span>
				</div>

				<div class="postkit-style-preview postkit-preview-b">

					<span>2 min read</span>

					<span class="postkit-preview-separator">|</span>

					<span>252 words</span>

					<span class="postkit-preview-separator">|</span>

					<span>1,245 views</span>

					<span class="postkit-preview-separator">|</span>

					<span>♡ Like 24</span>

				</div>

				<p class="postkit-style-description">
					<?php esc_html_e(
						'A clear and structured style with vertical separators.',
						'wp-postkit'
					); ?>
				</p>

			</div>

		</label>


		<!-- Style C -->
		<label class="postkit-style-card">

			<input
				type="radio"
				name="postkit_settings[display_style]"
				value="style_c"
				<?php checked(
					isset( $settings['display_style'] )
						? $settings['display_style']
						: 'style_a',
					'style_c'
				); ?>
			>

			<div class="postkit-style-card-content">

				<div class="postkit-style-card-header">
					<strong>
						<?php esc_html_e( 'Style C', 'wp-postkit' ); ?>
					</strong>

					<span class="postkit-style-name">
						<?php esc_html_e( 'With Icons', 'wp-postkit' ); ?>
					</span>
				</div>

				<div class="postkit-style-preview postkit-preview-c">

					<span>◷ 2 min read</span>

					<span class="postkit-preview-separator">•</span>

					<span>▤ 252 words</span>

					<span class="postkit-preview-separator">•</span>

					<span>👁 1,245 views</span>

					<span class="postkit-preview-separator">•</span>

					<span>♡ 24</span>

				</div>

				<p class="postkit-style-description">
					<?php esc_html_e(
						'Modern style with icons for better visual appearance.',
						'wp-postkit'
					); ?>
				</p>

			</div>

		</label>

	</div>

</div>
<style>
	.postkit-style-options {
		max-width: 900px;
		margin-top: 25px;
	}

	.postkit-style-card {
		display: block;
		position: relative;
		margin-bottom: 18px;
		cursor: pointer;
	}

	.postkit-style-card > input {
		position: absolute;
		opacity: 0;
		pointer-events: none;
	}

	.postkit-style-card-content {
		border: 1px solid #dcdcde;
		border-radius: 6px;
		background: #fff;
		padding: 22px 24px;
		transition:
			border-color 0.15s ease,
			box-shadow 0.15s ease,
			background-color 0.15s ease;
	}

	.postkit-style-card:hover .postkit-style-card-content {
		border-color: #8c8f94;
	}

	.postkit-style-card > input:checked + .postkit-style-card-content {
		border-color: #2271b1;
		box-shadow: 0 0 0 1px #2271b1;
		background: #f6fbff;
	}

	.postkit-style-card-header {
		display: flex;
		align-items: center;
		gap: 10px;
		margin-bottom: 15px;
		font-size: 16px;
	}

	.postkit-style-card-header strong {
		font-size: 17px;
		color: #1d2327;
	}

	.postkit-style-name {
		color: #646970;
		font-size: 14px;
	}

	.postkit-style-preview {
		display: flex;
		align-items: center;
		flex-wrap: wrap;
		gap: 12px;
		min-height: 58px;
		padding: 0 22px;
		border: 1px solid #dcdcde;
		border-radius: 5px;
		background: #f6f7f7;
		color: #1d2327;
		font-size: 15px;
		line-height: 1.5;
	}

	.postkit-preview-a {
		gap: 10px;
	}

	.postkit-preview-b {
		gap: 14px;
	}

	.postkit-preview-c {
		gap: 12px;
	}

	.postkit-preview-separator {
		color: #8c8f94;
		font-weight: 400;
	}

	.postkit-style-description {
		margin: 12px 0 0;
		color: #646970;
		font-size: 13px;
	}

	@media screen and (max-width: 782px) {

		.postkit-style-preview {
			padding: 14px;
			gap: 8px;
			font-size: 14px;
		}

		.postkit-style-card-content {
			padding: 18px;
		}

	}
</style>
		<?php

	}

}