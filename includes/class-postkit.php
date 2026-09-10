<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostKit {

	public function init() {

		$this->load_dependencies();

		$settings = new PostKit_Settings();
		$settings->init();

		$reading_time = new PostKit_Reading_Time();
		$reading_time->init();

		$toc = new PostKit_TOC();
		$toc->init();

        $views = new PostKit_Views();
        $views->init();

        $likes = new PostKit_Likes();
        $likes->init();

        $meta = new PostKit_Meta();
        $meta->init();

	}

	private function load_dependencies() {

		require_once POSTKIT_DIR . 'settings/class-postkit-settings.php';

		require_once POSTKIT_DIR . 'includes/class-postkit-reading-time.php';

		require_once POSTKIT_DIR . 'includes/class-postkit-toc.php';

        require_once POSTKIT_DIR . 'includes/class-postkit-views.php';

        require_once POSTKIT_DIR . 'includes/class-postkit-likes.php';

        require_once POSTKIT_DIR . 'includes/class-postkit-meta.php';

	}

}