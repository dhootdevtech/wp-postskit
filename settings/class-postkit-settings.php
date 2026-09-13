<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostKit_Settings {

	/**
	 * Initialize settings.
	 */
	public function init() {

		/**
		 * Load settings tab classes.
		 */
		$this->load_dependencies();

		/**
		 * Register settings.
		 */
		add_action(
			'admin_init',
			array( $this, 'register_settings' )
		);

		/**
		 * Add settings page.
		 */
		add_action(
			'admin_menu',
			array( $this, 'add_settings_page' )
		);

		add_action(
			'admin_enqueue_scripts',
			array( $this, 'admin_assets' )
		);

	}

	private function load_dependencies() {

		require_once POSTKIT_DIR . 'settings/tabs/class-postkit-settings-general.php';

		require_once POSTKIT_DIR . 'settings/tabs/class-postkit-settings-display.php';

		require_once POSTKIT_DIR . 'settings/tabs/class-postkit-settings-shortcodes.php';

	}

public function admin_assets( $hook ) {

	if ( 'settings_page_wp-postkit' !== $hook ) {
		return;
	}

	wp_enqueue_style(
		'postkit-admin',
		POSTKIT_URL . 'assets/css/postkit-admin.css',
		array(),
		POSTKIT_VERSION
	);

	wp_enqueue_script(
		'postkit-admin',
		POSTKIT_URL . 'assets/js/postkit-admin.js',
		array(),
		POSTKIT_VERSION,
		true
	);
}
	/**
	 * Register plugin settings.
	 */
	public function register_settings() {

		register_setting(
			'postkit_settings_group',
			'postkit_settings',
			array(
				'sanitize_callback' => array(
					$this,
					'sanitize_settings'
				),
			)
		);

	}

		/**
	 * Add WP PostKit settings page.
	 */
	public function add_settings_page() {

		add_options_page(
			__( 'WP PostKit', 'wp-postkit' ),
			__( 'WP PostKit', 'wp-postkit' ),
			'manage_options',
			'wp-postkit',
			array(
				$this,
				'settings_page',
			)
		);

	}

	/**
 * Sanitize PostKit settings.
 *
 * Settings from different tabs are merged so saving one tab
 * does not reset values saved from another tab.
 *
 * @param array $input Submitted settings.
 * @return array
 */
public function sanitize_settings( $input ) {

	/**
	 * Get existing settings.
	 */
	$existing = get_option(
		'postkit_settings',
		array()
	);

	if ( ! is_array( $existing ) ) {
		$existing = array();
	}

	/**
	 * Start with existing settings.
	 */
	$sanitized = $existing;


	/**
	 * Checkbox settings.
	 *
	 * Important:
	 * A checkbox that is not submitted means unchecked,
	 * so we only process these when the General tab
	 * submitted them.
	 */
	$checkboxes = array(
		'reading_time',
		'word_count',
		'toc',
		'views',
		'likes',
		'show_icons',
	);

	foreach ( $checkboxes as $field ) {

		if ( isset( $input[ $field ] ) ) {

			$sanitized[ $field ] = ! empty(
				$input[ $field ]
			)
				? 1
				: 0;

		}

	}


	/**
	 * Reading speed.
	 */
	if ( isset( $input['reading_speed'] ) ) {

		$reading_speed = absint(
			$input['reading_speed']
		);

		if ( $reading_speed < 1 ) {
			$reading_speed = 1;
		}

		if ( $reading_speed > 1000 ) {
			$reading_speed = 1000;
		}

		$sanitized['reading_speed'] = $reading_speed;

	}


	/**
	 * Automatic metadata display.
	 */
	if ( isset( $input['meta_display'] ) ) {

		$allowed_meta_display = array(
			'disabled',
			'before',
			'after',
		);

		$meta_display = sanitize_key(
			$input['meta_display']
		);

		if (
			! in_array(
				$meta_display,
				$allowed_meta_display,
				true
			)
		) {
			$meta_display = 'disabled';
		}

		$sanitized['meta_display'] = $meta_display;

	}


	/**
 * Display style.
 */
if ( isset( $input['display_style'] ) ) {

	$allowed_styles = array(
		'style_a',
		'style_b',
		'style_c',
	);

	$display_style = sanitize_key(
		$input['display_style']
	);

	if (
		! in_array(
			$display_style,
			$allowed_styles,
			true
		)
	) {
		$display_style = 'style_a';
	}

	$sanitized['display_style'] = $display_style;

}


/**
 * Font size.
 */
if ( isset( $input['font_size'] ) ) {

	$font_size = absint(
		$input['font_size']
	);

	if ( $font_size < 8 ) {
		$font_size = 8;
	}

	if ( $font_size > 32 ) {
		$font_size = 32;
	}

	$sanitized['font_size'] = $font_size;

}


/**
 * Font weight.
 */
if ( isset( $input['font_weight'] ) ) {

	$allowed_weights = array(
		'400',
		'500',
		'600',
		'700',
	);

	$font_weight = sanitize_key(
		$input['font_weight']
	);

	if (
		! in_array(
			$font_weight,
			$allowed_weights,
			true
		)
	) {
		$font_weight = '400';
	}

	$sanitized['font_weight'] = $font_weight;

}


/**
 * Text color.
 */
if ( isset( $input['text_color'] ) ) {

	$text_color = sanitize_hex_color(
		$input['text_color']
	);

	if ( ! $text_color ) {
		$text_color = '#666666';
	}

	$sanitized['text_color'] = $text_color;

}

/**
 * Separator style.
 */
if ( isset( $input['separator_style'] ) ) {

	$allowed_separator_styles = array(
		'dot',
		'line',
		'bullet',
		'none',
	);

	$separator_style = sanitize_key(
		$input['separator_style']
	);

	if (
		! in_array(
			$separator_style,
			$allowed_separator_styles,
			true
		)
	) {
		$separator_style = 'dot';
	}

	$sanitized['separator_style'] = $separator_style;

}


/**
 * Separator color.
 */
if ( isset( $input['separator_color'] ) ) {

	$separator_color = sanitize_hex_color(
		$input['separator_color']
	);

	if ( ! $separator_color ) {
		$separator_color = '#b3b3b3';
	}

	$sanitized['separator_color'] = $separator_color;

}

/**
 * Heart icon.
 */
if ( isset( $input['heart_icon'] ) ) {

	$allowed_heart_icons = array(
		'outline',
		'filled',
	);

	$heart_icon = sanitize_key(
		$input['heart_icon']
	);

	if (
		! in_array(
			$heart_icon,
			$allowed_heart_icons,
			true
		)
	) {
		$heart_icon = 'outline';
	}

	$sanitized['heart_icon'] = $heart_icon;

}


/**
 * Heart size.
 */
if ( isset( $input['heart_size'] ) ) {

	$heart_size = absint(
		$input['heart_size']
	);

	if ( $heart_size < 12 ) {
		$heart_size = 12;
	}

	if ( $heart_size > 32 ) {
		$heart_size = 32;
	}

	$sanitized['heart_size'] = $heart_size;

}


/**
 * Heart color.
 */
if ( isset( $input['heart_color'] ) ) {

	$heart_color = sanitize_hex_color(
		$input['heart_color']
	);

	if ( ! $heart_color ) {
		$heart_color = '#666666';
	}

	$sanitized['heart_color'] = $heart_color;

}


/**
 * Liked heart color.
 */
if ( isset( $input['heart_liked_color'] ) ) {

	$heart_liked_color = sanitize_hex_color(
		$input['heart_liked_color']
	);

	if ( ! $heart_liked_color ) {
		$heart_liked_color = '#e0245e';
	}

	$sanitized['heart_liked_color'] = $heart_liked_color;

}

/**
 * Icon size.
 */
if ( isset( $input['icon_size'] ) ) {

	$icon_size = absint(
		$input['icon_size']
	);

	if ( $icon_size < 12 ) {
		$icon_size = 12;
	}

	if ( $icon_size > 24 ) {
		$icon_size = 24;
	}

	$sanitized['icon_size'] = $icon_size;

}


/**
 * Icon color.
 */
if ( isset( $input['icon_color'] ) ) {

	$icon_color = sanitize_hex_color(
		$input['icon_color']
	);

	if ( ! $icon_color ) {
		$icon_color = '#666666';
	}

	$sanitized['icon_color'] = $icon_color;

}

/**
 * TOC style.
 */
if ( isset( $input['toc_style'] ) ) {

	$allowed_toc_styles = array(
		'style_a',
		'style_b',
		'style_c',
	);

	$toc_style = sanitize_key(
		$input['toc_style']
	);

	if (
		! in_array(
			$toc_style,
			$allowed_toc_styles,
			true
		)
	) {
		$toc_style = 'style_a';
	}

	$sanitized['toc_style'] = $toc_style;
}


/**
 * TOC title.
 */
if ( isset( $input['toc_title'] ) ) {

	$toc_title = sanitize_text_field(
		$input['toc_title']
	);

	if ( '' === $toc_title ) {
		$toc_title = 'Table of Contents';
	}

	$sanitized['toc_title'] = $toc_title;
}


/**
 * TOC title font size.
 */
if ( isset( $input['toc_title_font_size'] ) ) {

	$toc_title_font_size = absint(
		$input['toc_title_font_size']
	);

	if ( $toc_title_font_size < 12 ) {
		$toc_title_font_size = 12;
	}

	if ( $toc_title_font_size > 32 ) {
		$toc_title_font_size = 32;
	}

	$sanitized['toc_title_font_size'] =
		$toc_title_font_size;
}


/**
 * TOC title font weight.
 */
if ( isset( $input['toc_title_font_weight'] ) ) {

	$allowed_toc_title_weights = array(
		'400',
		'500',
		'600',
		'700',
	);

	$toc_title_font_weight = sanitize_key(
		$input['toc_title_font_weight']
	);

	if (
		! in_array(
			$toc_title_font_weight,
			$allowed_toc_title_weights,
			true
		)
	) {
		$toc_title_font_weight = '600';
	}

	$sanitized['toc_title_font_weight'] =
		$toc_title_font_weight;
}


/**
 * TOC text font size.
 */
if ( isset( $input['toc_text_font_size'] ) ) {

	$toc_text_font_size = absint(
		$input['toc_text_font_size']
	);

	if ( $toc_text_font_size < 10 ) {
		$toc_text_font_size = 10;
	}

	if ( $toc_text_font_size > 24 ) {
		$toc_text_font_size = 24;
	}

	$sanitized['toc_text_font_size'] =
		$toc_text_font_size;
}


/**
 * TOC text color.
 */
if ( isset( $input['toc_text_color'] ) ) {

	$toc_text_color = sanitize_hex_color(
		$input['toc_text_color']
	);

	if ( ! $toc_text_color ) {
		$toc_text_color = '#333333';
	}

	$sanitized['toc_text_color'] =
		$toc_text_color;
}


/**
 * TOC background color.
 */
if ( isset( $input['toc_background_color'] ) ) {

	$toc_background_color = sanitize_hex_color(
		$input['toc_background_color']
	);

	if ( ! $toc_background_color ) {
		$toc_background_color = '#f8f8f8';
	}

	$sanitized['toc_background_color'] =
		$toc_background_color;
}


/**
 * TOC border color.
 */
if ( isset( $input['toc_border_color'] ) ) {

	$toc_border_color = sanitize_hex_color(
		$input['toc_border_color']
	);

	if ( ! $toc_border_color ) {
		$toc_border_color = '#e5e5e5';
	}

	$sanitized['toc_border_color'] =
		$toc_border_color;
}

/**
 * TOC title color.
 */
if ( isset( $input['toc_title_color'] ) ) {

	$toc_title_color = sanitize_hex_color(
		$input['toc_title_color']
	);

	if ( ! $toc_title_color ) {
		$toc_title_color = '#333333';
	}

	$sanitized['toc_title_color'] =
		$toc_title_color;
}


	return $sanitized;

}

	/**
	 * Get PostKit settings.
	 */
	public function get_settings() {

		$defaults = array(
			'reading_time'  => 0,
			'word_count'    => 0,
			'toc'           => 0,
			'views'         => 0,
			'likes'         => 0,
			'reading_speed' => 200,
			'meta_display'  => 'disabled',
			'display_style' => 'style_a',
			'font_size'   => 14,
			'font_weight' => '400',
			'text_color'  => '#666666',
			'separator_style'  => 'dot',
            'separator_color'  => '#b3b3b3',
			'heart_icon'       => 'outline',
            'heart_size'       => 16,
            'heart_color'      => '#666666',
            'heart_liked_color' => '#e0245e',
			'show_icons'       => 0,
			'icon_size'  => 16,
			'icon_color' => '#666666',
			'toc_style'           => 'style_a',
			'toc_title'           => 'Table of Contents',
			'toc_title_font_size' => 18,
			'toc_title_font_weight' => '600',
			'toc_text_font_size'  => 14,
			'toc_text_color'      => '#333333',
			'toc_background_color' => '#f8f8f8',
			'toc_border_color'    => '#e5e5e5',
			'toc_title_color' => '#333333',
		);

		$settings = get_option(
			'postkit_settings',
			array()
		);

		return wp_parse_args(
			$settings,
			$defaults
		);

	}


	/**
	 * Settings page.
	 */
	public function settings_page() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		/**
		 * Get settings.
		 */
		$settings = $this->get_settings();


		/**
		 * Current tab.
		 */
		$active_tab = isset(
			$_GET['tab']
		)
			? sanitize_key(
				$_GET['tab']
			)
			: 'general';

		?>

		<div class="wrap">

			<h1>
				<?php esc_html_e( 'WP PostKit', 'wp-postkit' ); ?>
			</h1>


			<!-- Tabs -->

			<nav class="nav-tab-wrapper">

				<a
					href="<?php echo esc_url(
						admin_url(
							'options-general.php?page=wp-postkit&tab=general'
						)
					); ?>"
					class="nav-tab <?php echo (
						'general' === $active_tab
					)
						? 'nav-tab-active'
						: ''; ?>"
				>
					<?php esc_html_e( 'General', 'wp-postkit' ); ?>
				</a>


				<a
					href="<?php echo esc_url(
						admin_url(
							'options-general.php?page=wp-postkit&tab=display'
						)
					); ?>"
					class="nav-tab <?php echo (
						'display' === $active_tab
					)
						? 'nav-tab-active'
						: ''; ?>"
				>
					<?php esc_html_e( 'Display', 'wp-postkit' ); ?>
				</a>

								<a
					href="<?php echo esc_url(
						admin_url(
							'options-general.php?page=wp-postkit&tab=shortcodes'
						)
					); ?>"
					class="nav-tab <?php echo (
						'shortcodes' === $active_tab
					)
						? 'nav-tab-active'
						: ''; ?>"
				>
					<?php esc_html_e( 'Shortcodes', 'wp-postkit' ); ?>
				</a>

			</nav>

		<?php if ( 'shortcodes' === $active_tab ) : ?>

			<?php

			/**
			 * Shortcodes tab.
			 */
			$shortcodes_tab = new PostKit_Settings_Shortcodes();

			$shortcodes_tab->render();

			?>

		<?php else : ?>
			<form
				method="post"
				action="options.php"
			>

				<?php

				settings_fields(
					'postkit_settings_group'
				);

				?>


				<?php

				/**
				 * General tab.
				 */
				if ( 'general' === $active_tab ) {

					$general_tab = new PostKit_Settings_General();

					$general_tab->render(
						$settings
					);

				}


				/**
				 * Display tab.
				 */
				if ( 'display' === $active_tab ) {

					$display_tab = new PostKit_Settings_Display();

					$display_tab->render(
						$settings
					);
				}

				?>


				<?php submit_button(
					__( 'Save Settings', 'wp-postkit' )
				); ?>

			</form>
			<?php endif; ?>

		</div>

		<?php

	}

}