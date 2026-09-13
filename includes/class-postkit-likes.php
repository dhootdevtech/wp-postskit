<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostKit_Likes {

	public function init() {

		add_shortcode(
			'postkit_likes',
			array( $this, 'shortcode' )
		);

		add_action(
			'wp_ajax_postkit_toggle_like',
			array( $this, 'toggle_like' )
		);

		add_action(
			'wp_ajax_nopriv_postkit_toggle_like',
			array( $this, 'toggle_like' )
		);

		add_action(
			'wp_enqueue_scripts',
			array( $this, 'enqueue_scripts' )
		);


	}

	/**
	 * Enqueue Like/Unlike JavaScript.
	 */
	public function enqueue_scripts() {

		if ( ! is_singular( 'post' ) ) {
			return;
		}

		wp_enqueue_script(
			'postkit-likes',
			POSTKIT_URL . 'assets/js/postkit-likes.js',
			array(),
			POSTKIT_VERSION,
			true
		);

		$settings = get_option(
	'postkit_settings',
	array()
);

$heart_icon = isset(
	$settings['heart_icon']
)
	? $settings['heart_icon']
	: 'outline';

$heart_size = isset(
	$settings['heart_size']
)
	? absint( $settings['heart_size'] )
	: 16;

$heart_color = isset(
	$settings['heart_color']
)
	? sanitize_hex_color(
		$settings['heart_color']
	)
	: '#666666';

$heart_liked_color = isset(
	$settings['heart_liked_color']
)
	? sanitize_hex_color(
		$settings['heart_liked_color']
	)
	: '#e0245e';

wp_localize_script(
	'postkit-likes',
	'postKitLikes',
	array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'postkit_like_nonce' ),

		'heart' => array(
			'icon'       => $heart_icon,
			'size'       => $heart_size,
			'color'      => $heart_color,
			'likedColor' => $heart_liked_color,
		),
	)
);

	}

	/**
	 * Get like count.
	 */
	public function get_likes( $post_id = 0 ) {

		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		if ( ! $post_id ) {
			return 0;
		}

		return absint(
			get_post_meta(
				$post_id,
				'_postkit_likes',
				true
			)
		);

	}

	/**
	 * Likes shortcode.
	 */
	public function shortcode( $atts = array() ) {

		$atts = shortcode_atts(
			array(
				'post_id' => 0,
				'label'   => 'Like',
			),
			$atts,
			'postkit_likes'
		);

		$post_id = absint(
			$atts['post_id']
		);

		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		if ( ! $post_id ) {
			return '';
		}

		$likes = $this->get_likes(
	$post_id
);

/**
 * Get Like button settings.
 */
$settings = get_option(
	'postkit_settings',
	array()
);

$heart_icon = isset(
	$settings['heart_icon']
)
	? $settings['heart_icon']
	: 'outline';

$heart_size = isset(
	$settings['heart_size']
)
	? absint(
		$settings['heart_size']
	)
	: 16;

$heart_color = isset(
	$settings['heart_color']
)
	? sanitize_hex_color(
		$settings['heart_color']
	)
	: '#666666';

$heart_liked_color = isset(
	$settings['heart_liked_color']
)
	? sanitize_hex_color(
		$settings['heart_liked_color']
	)
	: '#e0245e';

/**
 * Fallback values.
 */
if ( ! in_array(
	$heart_icon,
	array(
		'outline',
		'filled',
	),
	true
) ) {
	$heart_icon = 'outline';
}

if ( $heart_size < 12 || $heart_size > 32 ) {
	$heart_size = 16;
}

if ( ! $heart_color ) {
	$heart_color = '#666666';
}

if ( ! $heart_liked_color ) {
	$heart_liked_color = '#e0245e';
}

$cookie_name = 'postkit_liked_' . $post_id;

$is_liked = ! empty(
	$_COOKIE[ $cookie_name ]
);

		$output = '<button';
        $output .= ' type="button"';

        if ( $is_liked ) {
            $output .= ' class="postkit-like-button postkit-liked"';
        } else {
            $output .= ' class="postkit-like-button"';
        }

        $output .= ' data-post-id="' . esc_attr( $post_id ) . '"';
        $output .= '>';

		/**
 * Determine heart character.
 */
if ( 'filled' === $heart_icon ) {
	$heart_character = '♥';
} else {
	$heart_character = '♡';
}

$output .= '<span class="postkit-like-icon"';
$output .= ' style="font-size: ' . esc_attr( $heart_size ) . 'px;';
$output .= ' color: ' . esc_attr(
		$is_liked
			? $heart_liked_color
			: $heart_color
	) . ';">';

$output .= $heart_character;

$output .= '</span>';

        $output .= '<span class="postkit-like-label">';
        $output .= $is_liked ? 'Liked' : esc_html( $atts['label'] );
        $output .= '</span>';

		$output .= '<span class="postkit-like-count">';
		$output .= number_format_i18n( $likes );
		$output .= '</span>';

		$output .= '</button>';

		return $output;

	}

	/**
	 * AJAX Like/Unlike.
	 */
	public function toggle_like() {

		check_ajax_referer(
			'postkit_like_nonce',
			'nonce'
		);

		$post_id = isset( $_POST['post_id'] )
			? absint( $_POST['post_id'] )
			: 0;

		if ( ! $post_id ) {
			wp_send_json_error(
				array(
					'message' => 'Invalid post.',
				)
			);
		}

		if ( 'post' !== get_post_type( $post_id ) ) {
			wp_send_json_error(
				array(
					'message' => 'Invalid post type.',
				)
			);
		}

		$cookie_name = 'postkit_liked_' . $post_id;

		$already_liked = ! empty(
			$_COOKIE[ $cookie_name ]
		);

		$likes = $this->get_likes(
			$post_id
		);

		if ( $already_liked ) {

			$likes = max(
				0,
				$likes - 1
			);

			setcookie(
				$cookie_name,
				'',
				time() - 3600,
				COOKIEPATH,
				COOKIE_DOMAIN
			);

			$liked = false;

		} else {

			$likes++;

			setcookie(
				$cookie_name,
				'1',
				time() + YEAR_IN_SECONDS,
				COOKIEPATH,
				COOKIE_DOMAIN
			);

			$liked = true;

		}

		update_post_meta(
			$post_id,
			'_postkit_likes',
			$likes
		);

		wp_send_json_success(
			array(
				'likes' => number_format_i18n( $likes ),
				'liked' => $liked,
			)
		);

	}

    /**
 * Automatically display Like button above the post.
 *
 * @param string $content Post content.
 * @return string
 */
public function automatic_likes( $content ) {

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

	// Show only if Likes are enabled.
	if ( empty( $settings['likes'] ) ) {
		return $content;
	}

	// Prevent duplicate button if shortcode is already used.
	if ( has_shortcode( $content, 'postkit_likes' ) ) {
		return $content;
	}

	$button = $this->shortcode();

	return $button . $content;

}

}

