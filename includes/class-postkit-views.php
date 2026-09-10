<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostKit_Views {

	public function init() {

		add_shortcode(
			'postkit_views',
			array( $this, 'shortcode' )
		);

		add_action(
			'wp',
			array( $this, 'count_view' )
		);


	}

	/**
	 * Count post view.
	 */
	public function count_view() {

		if ( is_admin() ) {
			return;
		}

		if ( ! is_singular( 'post' ) ) {
			return;
		}

		if ( is_preview() ) {
			return;
		}

		$post_id = get_queried_object_id();

		if ( ! $post_id ) {
			return;
		}

		$views = get_post_meta(
			$post_id,
			'_postkit_views',
			true
		);

		$views = absint( $views );

		$views++;

		update_post_meta(
			$post_id,
			'_postkit_views',
			$views
		);

	}

	/**
	 * Get post views.
	 */
	public function get_views( $post_id = 0 ) {

		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		if ( ! $post_id ) {
			return 0;
		}

		return absint(
			get_post_meta(
				$post_id,
				'_postkit_views',
				true
			)
		);

	}

	/**
	 * Views shortcode.
	 */
	public function shortcode( $atts = array() ) {

		$atts = shortcode_atts(
			array(
				'post_id' => 0,
				'label'   => 'views',
			),
			$atts,
			'postkit_views'
		);

		$views = $this->get_views(
			absint( $atts['post_id'] )
		);

		$output = number_format_i18n( $views );

		if ( ! empty( $atts['label'] ) ) {

			$output .= ' ' . esc_html(
				$atts['label']
			);

		}

		return $output;

	}

    public function automatic_views( $content ) {

        if ( is_admin() ) {
            return $content;
        }

        if ( ! is_singular( 'post' ) ) {
            return $content;
        }

        if ( is_feed() ) {
            return $content;
        }

        $settings = get_option(
            'postkit_settings',
            array()
        );

        if ( empty( $settings['views'] ) ) {
            return $content;
        }

        $views = $this->get_views();

        $views_output = number_format_i18n( $views ) . ' views';

        $meta = '<div class="postkit-meta postkit-views">';
        $meta .= esc_html( $views_output );
        $meta .= '</div>';

        return $meta . $content;

    }

}