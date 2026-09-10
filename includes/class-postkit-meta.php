<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostKit_Meta {

	public function init() {

		/**
		 * Combined PostKit shortcode.
		 */
		add_shortcode(
			'postkit',
			array( $this, 'shortcode' )
		);

		/**
		 * Automatic metadata.
		 */
		add_filter(
			'the_content',
			array( $this, 'automatic_meta' ),
			20
		);

	}

	/**
	 * Combined [postkit] shortcode.
	 */
	public function shortcode( $atts = array() ) {

		$atts = shortcode_atts(
			array(
				'post_id' => 0,
			),
			$atts,
			'postkit'
		);

		$post_id = absint(
			$atts['post_id']
		);

		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		if ( ! $post_id ) {
			$post_id = get_queried_object_id();
		}

		if ( ! $post_id ) {
			return '';
		}

		return $this->build_meta(
			$post_id
		);

	}

	/**
	 * Automatically display PostKit metadata.
	 */
	public function automatic_meta( $content ) {

	if ( is_admin() ) {
		return $content;
	}

	if ( ! is_singular( 'post' ) ) {
		return $content;
	}

	if ( is_feed() ) {
		return $content;
	}

	/**
	 * Get settings.
	 */
	$settings = get_option(
		'postkit_settings',
		array()
	);

	/**
	 * Get automatic display setting.
	 */
	$meta_display = isset(
		$settings['meta_display']
	)
		? $settings['meta_display']
		: 'disabled';

	/**
	 * Do not display automatically.
	 */
	if ( 'disabled' === $meta_display ) {
		return $content;
	}

	/**
	 * Prevent duplicate output when
	 * [postkit] is manually used.
	 */
	if ( has_shortcode( $content, 'postkit' ) ) {
		return $content;
	}

	/**
	 * Build metadata.
	 */
	$meta = $this->build_meta(
		get_the_ID()
	);

	if ( empty( $meta ) ) {
		return $content;
	}

	/**
	 * Display after content.
	 */
	if ( 'after' === $meta_display ) {
		return $content . $meta;
	}

	/**
	 * Default: display before content.
	 */
	return $meta . $content;

}

	/**
	 * Build combined metadata output.
	 */
	private function build_meta( $post_id ) {

		$settings = get_option(
			'postkit_settings',
			array()
		);

		$meta_items = array();

		/**
		 * Reading Time.
		 */
		if ( ! empty( $settings['reading_time'] ) ) {

			$reading_time = do_shortcode(
				'[postkit_reading_time post_id="' . $post_id . '"]'
			);

			if ( ! empty( $reading_time ) ) {
				$meta_items[] = $reading_time;
			}

		}

		/**
		 * Word Count.
		 */
		if ( ! empty( $settings['word_count'] ) ) {

			$word_count = do_shortcode(
				'[postkit_word_count post_id="' . $post_id . '"]'
			);

			if ( ! empty( $word_count ) ) {
				$meta_items[] = $word_count;
			}

		}

		/**
		 * Post Views.
		 */
		if ( ! empty( $settings['views'] ) ) {

			$views = do_shortcode(
				'[postkit_views post_id="' . $post_id . '"]'
			);

			if ( ! empty( $views ) ) {
				$meta_items[] = $views;
			}

		}

		/**
		 * Likes.
		 */
		if ( ! empty( $settings['likes'] ) ) {

			$likes = do_shortcode(
				'[postkit_likes post_id="' . $post_id . '"]'
			);

			if ( ! empty( $likes ) ) {
				$meta_items[] = $likes;
			}

		}

		/**
		 * Nothing enabled.
		 */
		if ( empty( $meta_items ) ) {
			return '';
		}

		/**
		 * Metadata separator.
		 */
		$meta_output = implode(
			' <span class="postkit-meta-separator">·</span> ',
			$meta_items
		);

		/**
		 * Final wrapper.
		 */
		$meta = '<div class="postkit-meta">';
		$meta .= $meta_output;
		$meta .= '</div>';

		return $meta;

	}

}

