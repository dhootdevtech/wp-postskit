<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostKit_Reading_Time {

	/**
	 * Initialize the feature.
	 */
public function init() {

	add_shortcode(
		'postkit_reading_time',
		array( $this, 'reading_time_shortcode' )
	);

	add_shortcode(
		'postkit_word_count',
		array( $this, 'word_count_shortcode' )
	);

}

	/**
	 * Get the current post ID.
	 *
	 * @param int $post_id Post ID.
	 * @return int
	 */
	private function get_post_id( $post_id = 0 ) {

		if ( ! empty( $post_id ) ) {
			return absint( $post_id );
		}

		$queried_id = get_queried_object_id();

		if ( $queried_id ) {
			return absint( $queried_id );
		}

		$current_id = get_the_ID();

		if ( $current_id ) {
			return absint( $current_id );
		}

		return 0;
	}

	/**
	 * Get post content.
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	private function get_post_content( $post_id = 0 ) {

		$post_id = $this->get_post_id( $post_id );

		if ( ! $post_id ) {
			return '';
		}

		$content = get_post_field(
			'post_content',
			$post_id
		);

		if ( empty( $content ) ) {
			return '';
		}

		// Remove shortcodes.
		$content = strip_shortcodes( $content );

		// Remove HTML.
		$content = wp_strip_all_tags( $content );

		// Decode HTML entities.
		$content = html_entity_decode(
			$content,
			ENT_QUOTES,
			'UTF-8'
		);

		// Normalize whitespace.
		$content = preg_replace(
			'/\s+/u',
			' ',
			$content
		);

		return trim( $content );
	}

	/**
	 * Get word count.
	 *
	 * @param int $post_id Post ID.
	 * @return int
	 */
	public function get_word_count( $post_id = 0 ) {

	$content = $this->get_post_content( $post_id );

	if ( empty( $content ) ) {
		return 0;
	}

	preg_match_all(
		'/[\p{L}\p{N}]+(?:[\'’-][\p{L}\p{N}]+)*/u',
		$content,
		$matches
	);

	if ( empty( $matches[0] ) ) {
		return 0;
	}

	return count( $matches[0] );
}

	/**
	 * Get reading time.
	 *
	 * @param int $post_id Post ID.
	 * @return int
	 */
	public function get_reading_time( $post_id = 0 ) {

	$word_count = $this->get_word_count( $post_id );

	if ( $word_count <= 0 ) {
		return 0;
	}

	$settings = get_option(
		'postkit_settings',
		array()
	);

	$words_per_minute = ! empty( $settings['reading_speed'] )
		? absint( $settings['reading_speed'] )
		: 200;

	$words_per_minute = max(
		1,
		$words_per_minute
	);

	return max(
		1,
		(int) ceil(
			$word_count / $words_per_minute
		)
	);

}

	/**
	 * Reading Time shortcode.
	 *
	 * [postkit_reading_time]
	 */
	public function reading_time_shortcode(  $atts = array() ) {

		$atts = shortcode_atts(
			array(
				'label'   => '',
				'post_id' => 0,
			),
			$atts,
			'postkit_reading_time'
		);

		$reading_time = $this->get_reading_time(
			$atts['post_id']
		);

		if ( ! $reading_time ) {
			return '';
		}

		$output = '';

		if ( ! empty( $atts['label'] ) ) {
			$output .= esc_html( $atts['label'] ) . ' ';
		}

		$output .= $reading_time . ' min read';

		return $output;
	}

	/**
	 * Word Count shortcode.
	 *
	 * [postkit_word_count]
	 */
	public function word_count_shortcode(  $atts = array() ) {

	$atts = shortcode_atts(
		array(
			'label'   => '',
			'post_id' => 0,
		),
		$atts,
		'postkit_word_count'
	);

	$word_count = $this->get_word_count(
		$atts['post_id']
	);

	if ( ! $word_count ) {
		return '';
	}

	$output = '';

	if ( ! empty( $atts['label'] ) ) {
		$output .= esc_html( $atts['label'] ) . ' ';
	}

	$output .= number_format_i18n( $word_count ) . ' words';

	return $output;
}

/**
 * Automatically display Reading Time and Word Count.
 *
 * @param string $content Post content.
 * @return string
 */
public function automatic_output( $content ) {

	/*
	 * Only run on the frontend.
	 */
	if ( is_admin() ) {
		return $content;
	}

	/*
	 * Only run on a single post.
	 */
	if ( ! is_singular( 'post' ) ) {
		return $content;
	}

	/*
	 * Don't modify feeds.
	 */
	if ( is_feed() ) {
		return $content;
	}

	$settings = get_option(
		'postkit_settings',
		array()
	);

	$reading_time_enabled = ! empty(
		$settings['reading_time']
	);

	$word_count_enabled = ! empty(
		$settings['word_count']
	);

	/*
	 * If both features are disabled,
	 * return the original content.
	 */
	if (
		! $reading_time_enabled &&
		! $word_count_enabled
	) {
		return $content;
	}

	$post_id = get_the_ID();

	$items = array();

	/*
	 * Reading Time.
	 */
	if ( $reading_time_enabled ) {

		$reading_time = $this->get_reading_time(
			$post_id
		);


		if ( $reading_time ) {

			$items[] = sprintf(
				'%d min read',
				$reading_time
			);

		}

	}

	/*
	 * Word Count.
	 */
	if ( $word_count_enabled ) {

		$word_count = $this->get_word_count(
			$post_id
		);


		if ( $word_count ) {

			$items[] = sprintf(
				'%s words',
				number_format_i18n( $word_count )
			);

		}

	}

	/*
	 * Nothing to display.
	 */
	if ( empty( $items ) ) {
		return $content;
	}

	$output  = '<div class="postkit-meta">';
	$output .= esc_html(
		implode( ' · ', $items )
	);
	$output .= '</div>';

	return $output . $content;

}

}