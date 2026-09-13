<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostKit_TOC {

	public function init() {

		add_shortcode(
			'postkit_toc',
			array( $this, 'shortcode' )
		);

		add_filter(
			'the_content',
			array( $this, 'automatic_toc' ),
			15
		);

        add_action(
	'wp_enqueue_scripts',
	array( $this, 'enqueue_scripts' )
);

	}

    public function enqueue_scripts() {

	if ( ! is_singular( 'post' ) ) {
		return;
	}

	wp_enqueue_script(
		'postkit-toc',
		POSTKIT_URL . 'assets/js/postkit-toc.js',
		array(),
		POSTKIT_VERSION,
		true
	);

}

	/**
	 * TOC shortcode.
	 */
	public function shortcode( $atts = array() ) {

	$post_id = get_the_ID();

	if ( ! $post_id ) {
		$post_id = get_queried_object_id();
	}

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

	$settings = get_option(
	'postkit_settings',
	array()
);

$result = $this->build_toc(
	$content,
	$settings
);

return $result['toc'];



}

	/**
	 * Automatic TOC.
	 */
	public function automatic_toc( $content ) {

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

	if ( empty( $settings['toc'] ) ) {
		return $content;
	}

	$result = $this->build_toc(
		$content,
		$settings
	);

	if ( empty( $result['toc'] ) ) {
		return $content;
	}

	/*
	 * If the manual TOC shortcode is already
	 * present, only use the modified content.
	 *
	 * This ensures heading IDs are added so
	 * manual TOC links work correctly.
	 */
	if ( has_shortcode( $content, 'postkit_toc' ) ) {
		return $result['content'];
	}

	return $result['toc'] . $result['content'];
}
	/**
	 * Build TOC and add IDs to headings.
	 */
	private function build_toc(
	$content,
	$settings = array()
) {

$toc_style = isset( $settings['toc_style'] )
	? $settings['toc_style']
	: 'style_a';

$toc_title = isset( $settings['toc_title'] )
	? $settings['toc_title']
	: 'Table of Contents';

$toc_title_font_size = isset(
	$settings['toc_title_font_size']
)
	? absint( $settings['toc_title_font_size'] )
	: 18;

$toc_title_font_weight = isset(
	$settings['toc_title_font_weight']
)
	? $settings['toc_title_font_weight']
	: '600';

$toc_text_font_size = isset(
	$settings['toc_text_font_size']
)
	? absint( $settings['toc_text_font_size'] )
	: 14;

$toc_text_color = isset(
	$settings['toc_text_color']
)
	? sanitize_hex_color(
		$settings['toc_text_color']
	)
	: '#333333';

$toc_title_color = isset(
	$settings['toc_title_color']
)
	? sanitize_hex_color(
		$settings['toc_title_color']
	)
	: '#333333';

$toc_background_color = isset(
	$settings['toc_background_color']
)
	? sanitize_hex_color(
		$settings['toc_background_color']
	)
	: '#f8f8f8';

$toc_border_color = isset(
	$settings['toc_border_color']
)
	? sanitize_hex_color(
		$settings['toc_border_color']
	)
	: '#e5e5e5';

if ( ! $toc_text_color ) {
	$toc_text_color = '#333333';
}
if ( ! $toc_title_color ) {
	$toc_title_color = '#333333';
}
if ( ! $toc_background_color ) {
	$toc_background_color = '#f8f8f8';
}

if ( ! $toc_border_color ) {
	$toc_border_color = '#e5e5e5';
}

		$headings = array();
		$used_ids = array();

		$pattern = '/<h([234])([^>]*)>(.*?)<\/h\1>/is';

		$content = preg_replace_callback(
			$pattern,
			function ( $matches ) use ( &$headings, &$used_ids ) {

				$level = absint( $matches[1] );
				$attributes = $matches[2];
				$title_html = $matches[3];

				$title = wp_strip_all_tags(
					$title_html
				);

				$title = trim(
					html_entity_decode(
						$title,
						ENT_QUOTES,
						'UTF-8'
					)
				);

				if ( empty( $title ) ) {
					return $matches[0];
				}

				/**
				 * Check if heading already has an ID.
				 */
				$existing_id = '';

				if (
					preg_match(
						'/\bid\s*=\s*([\'"])(.*?)\1/i',
						$attributes,
						$id_match
					)
				) {
					$existing_id = sanitize_title(
						$id_match[2]
					);
				}

				/**
				 * Generate ID if one does not exist.
				 */
				$id = $existing_id;

				if ( empty( $id ) ) {
					$id = sanitize_title( $title );
				}

				/**
				 * Fallback ID.
				 */
				if ( empty( $id ) ) {
					$id = 'postkit-heading';
				}

				/**
				 * Make ID unique.
				 */
				$base_id = $id;
				$count   = 2;

				while ( in_array( $id, $used_ids, true ) ) {

					$id = $base_id . '-' . $count;

					$count++;
				}

				$used_ids[] = $id;

				/**
				 * Add or replace heading ID.
				 */
				if (
					preg_match(
						'/\bid\s*=\s*([\'"])(.*?)\1/i',
						$attributes
					)
				) {

					$attributes = preg_replace(
						'/\bid\s*=\s*([\'"])(.*?)\1/i',
						'id="' . esc_attr( $id ) . '"',
						$attributes,
						1
					);

				} else {

					$attributes .= ' id="' . esc_attr( $id ) . '"';

				}

				/**
				 * Store heading for TOC.
				 */
				$headings[] = array(
					'level' => $level,
					'id'    => $id,
					'title' => $title,
				);

				/**
				 * Return modified heading.
				 */
				return sprintf(
					'<h%d%s>%s</h%d>',
					$level,
					$attributes,
					$title_html,
					$level
				);

			},
			$content
		);

		/**
		 * No headings found.
		 */
		if ( empty( $headings ) ) {

			return array(
				'toc'     => '',
				'content' => $content,
			);

		}

		/**
		 * Build TOC HTML.
		 */
		$toc = '';

$toc .= '<nav class="postkit-toc postkit-toc-' . esc_attr( $toc_style ) . '" aria-label="' . esc_attr( $toc_title ) . '" style="--postkit-toc-title-font-size: ' . esc_attr( $toc_title_font_size ) . 'px; --postkit-toc-title-font-weight: ' . esc_attr( $toc_title_font_weight ) . '; --postkit-toc-title-color: ' . esc_attr( $toc_title_color ) . '; --postkit-toc-text-font-size: ' . esc_attr( $toc_text_font_size ) . 'px; --postkit-toc-text-color: ' . esc_attr( $toc_text_color ) . '; --postkit-toc-background-color: ' . esc_attr( $toc_background_color ) . '; --postkit-toc-border-color: ' . esc_attr( $toc_border_color ) . ';">';

		$toc .= '<div class="postkit-toc-title">';
	$toc .= esc_html( $toc_title );
		$toc .= '</div>';

		$toc .= '<ol class="postkit-toc-list">';

		foreach ( $headings as $heading ) {

			$toc .= sprintf(
				'<li class="postkit-toc-level-%d postkit-toc-item h%d">',
				$heading['level'],
				$heading['level']
			);

			$toc .= sprintf(
				'<a href="#%s">%s</a>',
				esc_attr( $heading['id'] ),
				esc_html( $heading['title'] )
			);

			$toc .= '</li>';

		}

		$toc .= '</ol>';

		$toc .= '</nav>';

		return array(
			'toc'     => $toc,
			'content' => $content,
		);

	}

}

