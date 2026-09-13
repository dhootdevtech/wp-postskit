<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostKit_Settings_Display {

	/**
	 * Render Display tab.
	 *
	 * @param array $settings Current PostKit settings.
	 */
	public function render( $settings ) {

		$display_style = isset( $settings['display_style'] )
			? $settings['display_style']
			: 'style_a';

		/**
		 * Typography settings.
		 */
		$font_size = isset( $settings['font_size'] )
			? absint( $settings['font_size'] )
			: 14;

		$font_weight = isset( $settings['font_weight'] )
			? $settings['font_weight']
			: '400';

		$text_color = isset( $settings['text_color'] )
			? $settings['text_color']
			: '#666666';

			/**
          * Separator settings.
           */
        $separator_style = isset( $settings['separator_style'] )
	       ? $settings['separator_style']
	        : 'dot';

         $separator_color = isset( $settings['separator_color'] )
	       ? $settings['separator_color']
	      : '#b3b3b3';

	      /**
         * Heart settings.
             */
             $heart_icon = isset( $settings['heart_icon'] )
	         ? $settings['heart_icon']
	          : 'outline';

             $heart_size = isset( $settings['heart_size'] )
	          ? absint( $settings['heart_size'] )
	        : 16;

          $heart_color = isset( $settings['heart_color'] )
	      ? $settings['heart_color']
	         : '#666666';

           $heart_liked_color = isset( $settings['heart_liked_color'] )
	           ? $settings['heart_liked_color']
	          : '#e0245e';

			  /**
			 * Icon settings.
 				*/
			$show_icons = ! empty(
				$settings['show_icons']
			);

			/**
			 * Icon appearance settings.
			 */
			$icon_size = isset( $settings['icon_size'] )
				? absint( $settings['icon_size'] )
				: 16;

			$icon_color = isset( $settings['icon_color'] )
				? $settings['icon_color']
				: '#666666';

			/**
			 * Table of Contents settings.
			 */
			$toc_style = isset( $settings['toc_style'] )
				? $settings['toc_style']
				: 'style_a';

			$toc_title = isset( $settings['toc_title'] )
				? $settings['toc_title']
				: 'Table of Contents';

			$toc_title_font_size = isset( $settings['toc_title_font_size'] )
				? absint( $settings['toc_title_font_size'] )
				: 18;

			$toc_title_font_weight = isset( $settings['toc_title_font_weight'] )
				? $settings['toc_title_font_weight']
				: '600';

			$toc_text_font_size = isset( $settings['toc_text_font_size'] )
				? absint( $settings['toc_text_font_size'] )
				: 14;

			$toc_text_color = isset( $settings['toc_text_color'] )
				? $settings['toc_text_color']
				: '#333333';

			$toc_background_color = isset( $settings['toc_background_color'] )
				? $settings['toc_background_color']
				: '#f8f8f8';

			$toc_border_color = isset( $settings['toc_border_color'] )
				? $settings['toc_border_color']
				: '#e5e5e5';

			$toc_title_color = isset( $settings['toc_title_color'] )
			? $settings['toc_title_color']
			: '#333333';
		?>

		<div class="postkit-display-settings">

			<input
				type="hidden"
				name="postkit_settings[settings_tab]"
				value="display"
			>

			<h2>
				<?php esc_html_e(
					'Display Settings',
					'wp-postkit'
				); ?>
			</h2>

			<p class="description">
				<?php esc_html_e(
					'Choose the style used to display PostKit metadata on your posts.',
					'wp-postkit'
				); ?>
			</p>


			<!-- Metadata Styles -->

			<div class="postkit-style-options">

				<!-- Style A -->

				<label class="postkit-style-card">

					<input
						type="radio"
						name="postkit_settings[display_style]"
						value="style_a"
						<?php checked(
							$display_style,
							'style_a'
						); ?>
					>

					<span class="postkit-style-card-content">

						<span class="postkit-style-card-header">

							<span class="postkit-style-radio">
								<span></span>
							</span>

							<span class="postkit-style-title">

								<strong>
									<?php esc_html_e(
										'Style A',
										'wp-postkit'
									); ?>
								</strong>

								<small>
									<?php esc_html_e(
										'Clean & Minimal',
										'wp-postkit'
									); ?>
								</small>

							</span>

						</span>

						<span class="postkit-style-preview postkit-preview-a">

							<span>2 min read</span>

							<span class="postkit-preview-separator">
								·
							</span>

							<span>252 words</span>

							<span class="postkit-preview-separator">
								·
							</span>

							<span>1,245 views</span>

							<span class="postkit-preview-separator">
								·
							</span>

							<span>♡ Like 24</span>

						</span>

						<span class="postkit-style-description">

							<?php esc_html_e(
								'Simple metadata with subtle dot separators.',
								'wp-postkit'
							); ?>

						</span>

					</span>

				</label>


				<!-- Style B -->

				<label class="postkit-style-card">

					<input
						type="radio"
						name="postkit_settings[display_style]"
						value="style_b"
						<?php checked(
							$display_style,
							'style_b'
						); ?>
					>

					<span class="postkit-style-card-content">

						<span class="postkit-style-card-header">

							<span class="postkit-style-radio">
								<span></span>
							</span>

							<span class="postkit-style-title">

								<strong>
									<?php esc_html_e(
										'Style B',
										'wp-postkit'
									); ?>
								</strong>

								<small>
									<?php esc_html_e(
										'Divided',
										'wp-postkit'
									); ?>
								</small>

							</span>

						</span>

						<span class="postkit-style-preview postkit-preview-b">

							<span>2 min read</span>

							<span class="postkit-preview-separator">
								|
							</span>

							<span>252 words</span>

							<span class="postkit-preview-separator">
								|
							</span>

							<span>1,245 views</span>

							<span class="postkit-preview-separator">
								|
							</span>

							<span>♡ Like 24</span>

						</span>

						<span class="postkit-style-description">

							<?php esc_html_e(
								'Structured metadata using vertical separators.',
								'wp-postkit'
							); ?>

						</span>

					</span>

				</label>


				<!-- Style C -->

				<label class="postkit-style-card">

					<input
						type="radio"
						name="postkit_settings[display_style]"
						value="style_c"
						<?php checked(
							$display_style,
							'style_c'
						); ?>
					>

					<span class="postkit-style-card-content">

						<span class="postkit-style-card-header">

							<span class="postkit-style-radio">
								<span></span>
							</span>

							<span class="postkit-style-title">

								<strong>
									<?php esc_html_e(
										'Style C',
										'wp-postkit'
									); ?>
								</strong>

								<small>
									<?php esc_html_e(
										'With Icons',
										'wp-postkit'
									); ?>
								</small>

							</span>

						</span>

						<span class="postkit-style-preview postkit-preview-c">

							<span>◷ 2 min read</span>

							<span class="postkit-preview-separator">
								•
							</span>

							<span>▤ 252 words</span>

							<span class="postkit-preview-separator">
								•
							</span>

							<span>👁 1,245 views</span>

							<span class="postkit-preview-separator">
								•
							</span>

							<span>♡ 24</span>

						</span>

						<span class="postkit-style-description">

							<?php esc_html_e(
								'Modern metadata layout with visual icons.',
								'wp-postkit'
							); ?>

						</span>

					</span>

				</label>

			</div>


			<!-- Typography -->

			<h2>
				<?php esc_html_e(
					'Typography',
					'wp-postkit'
				); ?>
			</h2>

			<table class="form-table" role="presentation">

				<tr>

					<th scope="row">

						<label for="postkit-font-size">
							<?php esc_html_e(
								'Font Size',
								'wp-postkit'
							); ?>
						</label>

					</th>

					<td>

						<input
							type="number"
							id="postkit-font-size"
							name="postkit_settings[font_size]"
							value="<?php echo esc_attr( $font_size ); ?>"
							min="8"
							max="32"
							step="1"
							class="small-text"
						>

						<span>px</span>

						<p class="description">
							<?php esc_html_e(
								'Set the metadata text size.',
								'wp-postkit'
							); ?>
						</p>

					</td>

				</tr>


				<tr>

					<th scope="row">

						<label for="postkit-font-weight">
							<?php esc_html_e(
								'Font Weight',
								'wp-postkit'
							); ?>
						</label>

					</th>

					<td>

						<select
							id="postkit-font-weight"
							name="postkit_settings[font_weight]"
						>

							<option
								value="400"
								<?php selected(
									$font_weight,
									'400'
								); ?>
							>
								<?php esc_html_e(
									'Normal',
									'wp-postkit'
								); ?>
							</option>

							<option
								value="500"
								<?php selected(
									$font_weight,
									'500'
								); ?>
							>
								<?php esc_html_e(
									'Medium',
									'wp-postkit'
								); ?>
							</option>

							<option
								value="600"
								<?php selected(
									$font_weight,
									'600'
								); ?>
							>
								<?php esc_html_e(
									'Semi Bold',
									'wp-postkit'
								); ?>
							</option>

							<option
								value="700"
								<?php selected(
									$font_weight,
									'700'
								); ?>
							>
								<?php esc_html_e(
									'Bold',
									'wp-postkit'
								); ?>
							</option>

						</select>

						<p class="description">
							<?php esc_html_e(
								'Choose the metadata text weight.',
								'wp-postkit'
							); ?>
						</p>

					</td>

				</tr>


				<tr>

					<th scope="row">

						<label for="postkit-text-color">
							<?php esc_html_e(
								'Text Color',
								'wp-postkit'
							); ?>
						</label>

					</th>

					<td>

						<input
							type="color"
							id="postkit-text-color"
							name="postkit_settings[text_color]"
							value="<?php echo esc_attr( $text_color ); ?>"
						>

						<span class="postkit-color-value">
							<?php echo esc_html( $text_color ); ?>
						</span>

						<p class="description">
							<?php esc_html_e(
								'Choose the metadata text color.',
								'wp-postkit'
							); ?>
						</p>

					</td>

				</tr>

			</table>

			<!-- Separator -->

			<h2>
				<?php esc_html_e(
					'Separator',
					'wp-postkit'
				); ?>
			</h2>

			<table class="form-table" role="presentation">

				<tr>

					<th scope="row">

						<label for="postkit-separator-style">
							<?php esc_html_e(
								'Separator Style',
								'wp-postkit'
							); ?>
						</label>

					</th>

					<td>

						<select
							id="postkit-separator-style"
							name="postkit_settings[separator_style]"
						>

							<option
								value="dot"
								<?php selected(
									$separator_style,
									'dot'
								); ?>
							>
								<?php esc_html_e(
									'Dot (·)',
									'wp-postkit'
								); ?>
							</option>

							<option
								value="line"
								<?php selected(
									$separator_style,
									'line'
								); ?>
							>
								<?php esc_html_e(
									'Vertical Line (|)',
									'wp-postkit'
								); ?>
							</option>

							<option
								value="bullet"
								<?php selected(
									$separator_style,
									'bullet'
								); ?>
							>
								<?php esc_html_e(
									'Bullet (•)',
									'wp-postkit'
								); ?>
							</option>

							<option
								value="none"
								<?php selected(
									$separator_style,
									'none'
								); ?>
							>
								<?php esc_html_e(
									'None',
									'wp-postkit'
								); ?>
							</option>

						</select>

						<p class="description">
							<?php esc_html_e(
								'Choose the separator displayed between metadata items.',
								'wp-postkit'
							); ?>
						</p>

					</td>

				</tr>


				<tr>

					<th scope="row">

						<label for="postkit-separator-color">
							<?php esc_html_e(
								'Separator Color',
								'wp-postkit'
							); ?>
						</label>

					</th>

					<td>

						<input
							type="color"
							id="postkit-separator-color"
							name="postkit_settings[separator_color]"
							value="<?php echo esc_attr(
								$separator_color
							); ?>"
						>

						<span class="postkit-color-value">
							<?php echo esc_html(
								$separator_color
							); ?>
						</span>

						<p class="description">
							<?php esc_html_e(
								'Choose the separator color.',
								'wp-postkit'
							); ?>
						</p>

					</td>

				</tr>

			</table>

			<!-- Like / Heart -->

<h2>
	<?php esc_html_e(
		'Like Button',
		'wp-postkit'
	); ?>
</h2>

<table class="form-table" role="presentation">

	<tr>

		<th scope="row">

			<label for="postkit-heart-icon">
				<?php esc_html_e(
					'Heart Icon',
					'wp-postkit'
				); ?>
			</label>

		</th>

		<td>

			<select
				id="postkit-heart-icon"
				name="postkit_settings[heart_icon]"
			>

				<option
					value="outline"
					<?php selected(
						$heart_icon,
						'outline'
					); ?>
				>
					<?php esc_html_e(
						'Outline (♡)',
						'wp-postkit'
					); ?>
				</option>

				<option
					value="filled"
					<?php selected(
						$heart_icon,
						'filled'
					); ?>
				>
					<?php esc_html_e(
						'Filled (♥)',
						'wp-postkit'
					); ?>
				</option>

			</select>

			<p class="description">
				<?php esc_html_e(
					'Choose the heart icon style.',
					'wp-postkit'
				); ?>
			</p>

		</td>

	</tr>


	<tr>

		<th scope="row">

			<label for="postkit-heart-size">
				<?php esc_html_e(
					'Heart Size',
					'wp-postkit'
				); ?>
			</label>

		</th>

		<td>

			<input
				type="number"
				id="postkit-heart-size"
				name="postkit_settings[heart_size]"
				value="<?php echo esc_attr(
					$heart_size
				); ?>"
				min="12"
				max="32"
				step="1"
				class="small-text"
			>

			<span>px</span>

			<p class="description">
				<?php esc_html_e(
					'Set the heart icon size.',
					'wp-postkit'
				); ?>
			</p>

		</td>

	</tr>


	<tr>

		<th scope="row">

			<label for="postkit-heart-color">
				<?php esc_html_e(
					'Heart Color',
					'wp-postkit'
				); ?>
			</label>

		</th>

		<td>

			<input
				type="color"
				id="postkit-heart-color"
				name="postkit_settings[heart_color]"
				value="<?php echo esc_attr(
					$heart_color
				); ?>"
			>

			<span class="postkit-color-value">
				<?php echo esc_html(
					$heart_color
				); ?>
			</span>

			<p class="description">
				<?php esc_html_e(
					'Choose the heart color before the post is liked.',
					'wp-postkit'
				); ?>
			</p>

		</td>

	</tr>


	<tr>

		<th scope="row">

			<label for="postkit-heart-liked-color">
				<?php esc_html_e(
					'Liked Heart Color',
					'wp-postkit'
				); ?>
			</label>

		</th>

		<td>

			<input
				type="color"
				id="postkit-heart-liked-color"
				name="postkit_settings[heart_liked_color]"
				value="<?php echo esc_attr(
					$heart_liked_color
				); ?>"
			>

			<span class="postkit-color-value">
				<?php echo esc_html(
					$heart_liked_color
				); ?>
			</span>

			<p class="description">
				<?php esc_html_e(
					'Choose the heart color after the post is liked.',
					'wp-postkit'
				); ?>
			</p>

		</td>

	</tr>

</table>

<!-- Icons -->

<h2>
	<?php esc_html_e(
		'Icons',
		'wp-postkit'
	); ?>
</h2>

<table class="form-table" role="presentation">

	<tr>

		<th scope="row">
			<?php esc_html_e(
				'Show Icons',
				'wp-postkit'
			); ?>
		</th>

		<td>

			<label for="postkit-show-icons">

			<input
				type="hidden"
				name="postkit_settings[show_icons]"
				value="0"
			>

				<input
					type="checkbox"
					id="postkit-show-icons"
					name="postkit_settings[show_icons]"
					value="1"
					<?php checked(
						$show_icons,
						true
					); ?>
				>

				<?php esc_html_e(
					'Display icons with PostKit metadata.',
					'wp-postkit'
				); ?>

			</label>

			<p class="description">
				<?php esc_html_e(
					'Enable icons for reading time, word count, views and likes.',
					'wp-postkit'
				); ?>
			</p>

		</td>

	</tr>


	<tr>

		<th scope="row">

			<label for="postkit-icon-size">
				<?php esc_html_e(
					'Icon Size',
					'wp-postkit'
				); ?>
			</label>

		</th>

		<td>

			<input
				type="number"
				id="postkit-icon-size"
				name="postkit_settings[icon_size]"
				value="<?php echo esc_attr(
					$icon_size
				); ?>"
				min="12"
				max="24"
				step="1"
				class="small-text"
			>

			<span>px</span>

			<p class="description">
				<?php esc_html_e(
					'Set the size of the metadata icons.',
					'wp-postkit'
				); ?>
			</p>

		</td>

	</tr>


	<tr>

		<th scope="row">

			<label for="postkit-icon-color">
				<?php esc_html_e(
					'Icon Color',
					'wp-postkit'
				); ?>
			</label>

		</th>

		<td>

			<input
				type="color"
				id="postkit-icon-color"
				name="postkit_settings[icon_color]"
				value="<?php echo esc_attr(
					$icon_color
				); ?>"
			>

			<span class="postkit-color-value">
				<?php echo esc_html(
					$icon_color
				); ?>
			</span>

			<p class="description">
				<?php esc_html_e(
					'Choose the color of the metadata icons.',
					'wp-postkit'
				); ?>
			</p>

		</td>

	</tr>

</table>

		</div>
<!-- Table of Contents -->

<div class="postkit-settings-section">

	<h2>
		<?php esc_html_e(
			'Table of Contents',
			'wp-postkit'
		); ?>
	</h2>

	<p class="description">
		<?php esc_html_e(
			'Customize the appearance of the Table of Contents.',
			'wp-postkit'
		); ?>
	</p>

	<table class="form-table" role="presentation">

		<!-- TOC Style -->

		<tr>

			<th scope="row">

				<label for="postkit-toc-style">

					<?php esc_html_e(
						'TOC Style',
						'wp-postkit'
					); ?>

				</label>

			</th>

			<td>

				<select
					id="postkit-toc-style"
					name="postkit_settings[toc_style]"
				>

					<option
						value="style_a"
						<?php selected(
							$toc_style,
							'style_a'
						); ?>
					>
						<?php esc_html_e(
							'Style A — Clean',
							'wp-postkit'
						); ?>
					</option>

					<option
						value="style_b"
						<?php selected(
							$toc_style,
							'style_b'
						); ?>
					>
						<?php esc_html_e(
							'Style B — Bordered',
							'wp-postkit'
						); ?>
					</option>

					<option
						value="style_c"
						<?php selected(
							$toc_style,
							'style_c'
						); ?>
					>
						<?php esc_html_e(
							'Style C — Boxed',
							'wp-postkit'
						); ?>
					</option>

				</select>

			</td>

		</tr>


		<!-- TOC Title -->

		<tr>

			<th scope="row">

				<label for="postkit-toc-title">

					<?php esc_html_e(
						'Title',
						'wp-postkit'
					); ?>

				</label>

			</th>

			<td>

				<input
					type="text"
					id="postkit-toc-title"
					name="postkit_settings[toc_title]"
					value="<?php echo esc_attr(
						$toc_title
					); ?>"
					class="regular-text"
				>

			</td>

		</tr>


		<!-- Title Font Size -->

		<tr>

			<th scope="row">

				<label for="postkit-toc-title-font-size">

					<?php esc_html_e(
						'Title Font Size',
						'wp-postkit'
					); ?>

				</label>

			</th>

			<td>

				<input
					type="number"
					id="postkit-toc-title-font-size"
					name="postkit_settings[toc_title_font_size]"
					value="<?php echo esc_attr(
						$toc_title_font_size
					); ?>"
					min="12"
					max="32"
					step="1"
				>

				<span class="description">
					px
				</span>

			</td>

		</tr>

		<!-- Title Color -->

<tr>

	<th scope="row">

		<label for="postkit-toc-title-color">

			<?php esc_html_e(
				'Title Color',
				'wp-postkit'
			); ?>

		</label>

	</th>

	<td>

		<input
			type="color"
			id="postkit-toc-title-color"
			name="postkit_settings[toc_title_color]"
			value="<?php echo esc_attr(
				$toc_title_color
			); ?>"
		>

	</td>

</tr>


		<!-- Title Font Weight -->

		<tr>

			<th scope="row">

				<label for="postkit-toc-title-font-weight">

					<?php esc_html_e(
						'Title Font Weight',
						'wp-postkit'
					); ?>

				</label>

			</th>

			<td>

				<select
					id="postkit-toc-title-font-weight"
					name="postkit_settings[toc_title_font_weight]"
				>

					<option
						value="400"
						<?php selected(
							$toc_title_font_weight,
							'400'
						); ?>
					>
						400 — Normal
					</option>

					<option
						value="500"
						<?php selected(
							$toc_title_font_weight,
							'500'
						); ?>
					>
						500 — Medium
					</option>

					<option
						value="600"
						<?php selected(
							$toc_title_font_weight,
							'600'
						); ?>
					>
						600 — Semi Bold
					</option>

					<option
						value="700"
						<?php selected(
							$toc_title_font_weight,
							'700'
						); ?>
					>
						700 — Bold
					</option>

				</select>

			</td>

		</tr>


		<!-- Text Font Size -->

		<tr>

			<th scope="row">

				<label for="postkit-toc-text-font-size">

					<?php esc_html_e(
						'Text Font Size',
						'wp-postkit'
					); ?>

				</label>

			</th>

			<td>

				<input
					type="number"
					id="postkit-toc-text-font-size"
					name="postkit_settings[toc_text_font_size]"
					value="<?php echo esc_attr(
						$toc_text_font_size
					); ?>"
					min="10"
					max="24"
					step="1"
				>

				<span class="description">
					px
				</span>

			</td>

		</tr>


		<!-- Text Color -->

		<tr>

			<th scope="row">

				<label for="postkit-toc-text-color">

					<?php esc_html_e(
						'Text Color',
						'wp-postkit'
					); ?>

				</label>

			</th>

			<td>

				<input
					type="color"
					id="postkit-toc-text-color"
					name="postkit_settings[toc_text_color]"
					value="<?php echo esc_attr(
						$toc_text_color
					); ?>"
				>

			</td>

		</tr>


		<!-- Background Color -->

		<tr>

			<th scope="row">

				<label for="postkit-toc-background-color">

					<?php esc_html_e(
						'Background Color',
						'wp-postkit'
					); ?>

				</label>

			</th>

			<td>

				<input
					type="color"
					id="postkit-toc-background-color"
					name="postkit_settings[toc_background_color]"
					value="<?php echo esc_attr(
						$toc_background_color
					); ?>"
				>

			</td>

		</tr>


		<!-- Border Color -->

		<tr>

			<th scope="row">

				<label for="postkit-toc-border-color">

					<?php esc_html_e(
						'Border Color',
						'wp-postkit'
					); ?>

				</label>

			</th>

			<td>

				<input
					type="color"
					id="postkit-toc-border-color"
					name="postkit_settings[toc_border_color]"
					value="<?php echo esc_attr(
						$toc_border_color
					); ?>"
				>

			</td>

		</tr>

	</table>

</div>

		<?php

	}

}