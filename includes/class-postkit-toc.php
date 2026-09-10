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

	$result = $this->build_toc( $content );

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

		$result = $this->build_toc( $content );

		if ( empty( $result['toc'] ) ) {
			return $content;
		}

		return $result['toc'] . $result['content'];

	}

	/**
	 * Build TOC and add IDs to headings.
	 */
	private function build_toc( $content ) {

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

		$toc .= '<nav class="postkit-toc" aria-label="Table of Contents">';

		$toc .= '<div class="postkit-toc-title">';
		$toc .= 'Table of Contents';
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

