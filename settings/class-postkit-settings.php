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

	}

	private function load_dependencies() {

		require_once POSTKIT_DIR . 'settings/tabs/class-postkit-settings-general.php';

		require_once POSTKIT_DIR . 'settings/tabs/class-postkit-settings-display.php';

	}

	/**
	 * Add settings page.
	 */
	public function add_admin_menu() {

		add_options_page(
			'WP PostKit',
			'WP PostKit',
			'manage_options',
			'wp-postkit',
			array( $this, 'settings_page' )
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
	 * Sanitize settings.
	 */
	public function sanitize_settings( $input ) {

		$sanitized = array();

		/**
		 * Checkbox settings.
		 */
		$checkboxes = array(
			'reading_time',
			'word_count',
			'toc',
			'views',
			'likes',
		);

		foreach ( $checkboxes as $field ) {

			$sanitized[ $field ] = ! empty(
				$input[ $field ]
			)
				? 1
				: 0;

		}


		/**
		 * Reading speed.
		 */
		$sanitized['reading_speed'] = isset(
			$input['reading_speed']
		)
			? absint( $input['reading_speed'] )
			: 200;

		if (
			$sanitized['reading_speed'] < 1
		) {
			$sanitized['reading_speed'] = 1;
		}

		if (
			$sanitized['reading_speed'] > 1000
		) {
			$sanitized['reading_speed'] = 1000;
		}


		/**
		 * Automatic metadata display.
		 */
		$allowed_meta_display = array(
			'disabled',
			'before',
			'after',
		);

		$meta_display = isset(
			$input['meta_display']
		)
			? sanitize_key(
				$input['meta_display']
			)
			: 'disabled';

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


		/**
		 * Display style.
		 */
		$allowed_styles = array(
			'style_a',
			'style_b',
			'style_c',
		);

		$display_style = isset(
			$input['display_style']
		)
			? sanitize_key(
				$input['display_style']
			)
			: 'style_a';

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

			</nav>


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

		</div>

		<?php

	}

}