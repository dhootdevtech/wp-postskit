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

/**
 * Show icons setting.
 */
$show_icons = ! empty(
	$settings['show_icons']
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

	if ( $show_icons ) {

		$reading_time = $this->get_icon(
			'reading_time'
		) . $reading_time;

	}

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

	if ( $show_icons ) {

		$word_count = $this->get_icon(
			'word_count'
		) . $word_count;

	}

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

	if ( $show_icons ) {

		$views = $this->get_icon(
			'views'
		) . $views;

	}

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

	if ( $show_icons ) {

		/**
		 * Do not add the SVG directly
		 * before the Like button.
		 *
		 * The Like button already contains
		 * its own heart icon.
		 */

		$meta_items[] = $likes;

	} else {

		$meta_items[] = $likes;

	}

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
$separator_style = isset(
	$settings['separator_style']
)
	? $settings['separator_style']
	: 'dot';

$separator_map = array(
	'dot'    => '·',
	'line'   => '|',
	'bullet' => '•',
	'none'   => '',
);

if ( ! isset( $separator_map[ $separator_style ] ) ) {
	$separator_style = 'dot';
}

$separator = $separator_map[ $separator_style ];

if ( 'none' === $separator_style ) {

	$meta_output = implode(
		' ',
		$meta_items
	);

} else {

	$meta_output = implode(
		' <span class="postkit-meta-separator">'
		. esc_html( $separator )
		. '</span> ',
		$meta_items
	);

}

		/**
		 * Final wrapper.
		 */
/**
 * Get selected display style.
 */
$display_style = isset(
	$settings['display_style']
)
	? $settings['display_style']
	: 'style_a';

/**
 * Allowed display styles.
 */
$allowed_styles = array(
	'style_a',
	'style_b',
	'style_c',
);

/**
 * Fallback to Style A.
 */
if (
	! in_array(
		$display_style,
		$allowed_styles,
		true
	)
) {
	$display_style = 'style_a';
}

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
 * Icon appearance settings.
 */
$icon_size = isset( $settings['icon_size'] )
	? absint( $settings['icon_size'] )
	: 16;

if ( $icon_size < 12 || $icon_size > 24 ) {
	$icon_size = 16;
}

$icon_color = isset( $settings['icon_color'] )
	? sanitize_hex_color(
		$settings['icon_color']
	)
	: '#666666';

if ( ! $icon_color ) {
	$icon_color = '#666666';
}
/**
 * Separator color.
 */
$separator_color = isset(
	$settings['separator_color']
)
	? sanitize_hex_color(
		$settings['separator_color']
	)
	: '#b3b3b3';

if ( ! $separator_color ) {
	$separator_color = '#b3b3b3';
}
/**
 * Allowed font weights.
 */
$allowed_weights = array(
	'400',
	'500',
	'600',
	'700',
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

/**
 * Final wrapper.
 */
$meta = '<div class="postkit-meta postkit-' . esc_attr( $display_style ) . '" style="font-size: ' . esc_attr( $font_size ) . 'px; font-weight: ' . esc_attr( $font_weight ) . '; color: ' . esc_attr( $text_color ) . '; --postkit-separator-color: ' . esc_attr( $separator_color ) . '; --postkit-icon-size: ' . esc_attr( $icon_size ) . 'px; --postkit-icon-color: ' . esc_attr( $icon_color ) . ';">';
$meta .= $meta_output;

$meta .= '</div>';

return $meta;

	}
/**
 * Get SVG icon for a metadata item.
 *
 * @param string $type Icon type.
 * @return string
 */
private function get_icon( $type ) {

	$icons = array(

		'reading_time' => '
			<svg
				class="postkit-meta-icon"
				viewBox="0 0 24 24"
				aria-hidden="true"
				focusable="false"
			>
				<circle
					cx="12"
					cy="12"
					r="9"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
				/>
				<path
					d="M12 7v5l3 2"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
					stroke-linecap="round"
				/>
			</svg>
		',

		'word_count' => '
			<svg
				class="postkit-meta-icon"
				viewBox="0 0 24 24"
				aria-hidden="true"
				focusable="false"
			>
				<rect
					x="5"
					y="3"
					width="14"
					height="18"
					rx="2"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
				/>
				<path
					d="M8 8h8M8 12h8M8 16h5"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
					stroke-linecap="round"
				/>
			</svg>
		',

		'views' => '
			<svg
				class="postkit-meta-icon"
				viewBox="0 0 24 24"
				aria-hidden="true"
				focusable="false"
			>
				<path
					d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
				/>
				<circle
					cx="12"
					cy="12"
					r="2.5"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
				/>
			</svg>
		',

		'likes' => '
			<svg
				class="postkit-meta-icon"
				viewBox="0 0 24 24"
				aria-hidden="true"
				focusable="false"
			>
				<path
					d="M20.8 8.8c0-2.7-2-4.8-4.7-4.8-1.7 0-3.2.9-4.1 2.2C11.1 4.9 9.6 4 7.9 4 5.2 4 3.2 6.1 3.2 8.8c0 5 8.8 10.2 8.8 10.2s8.8-5.2 8.8-10.2z"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
					stroke-linejoin="round"
				/>
			</svg>
		',

	);

	if ( ! isset( $icons[ $type ] ) ) {
		return '';
	}

	return $icons[ $type ];
}
}

