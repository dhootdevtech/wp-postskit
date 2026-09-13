=== WP PostKit ===
Contributors: rashpalbhardwaj
Tags: post metadata, reading time, word count, table of contents, post views, likes
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Essential tools for WordPress posts including reading time, word count, table of contents, post views, and likes.

== Description ==

WP PostKit adds useful post features to WordPress without requiring multiple separate plugins.

It provides tools for displaying post metadata, estimating reading time, counting words, generating a table of contents, tracking post views, and adding a like button.

Features can be enabled or disabled individually from the WP PostKit settings page.

### Features

* Reading Time
* Word Count
* Table of Contents
* Post Views
* Likes
* Combined Post Metadata
* Customizable metadata display styles
* Customizable typography and colors
* Customizable separators
* Customizable like button appearance
* Customizable TOC appearance
* Automatic or shortcode-based metadata display
* Automatic or shortcode-based table of contents

== Installation ==

1. Install and activate WP PostKit.
2. Go to Settings > WP PostKit.
3. Open the General tab and enable the features you want to use.
4. Configure Reading Speed if required.
5. Choose how automatic post metadata should be displayed.
6. Open the Display tab to customize the appearance.
7. Use the available shortcodes when you want to manually place a feature in your content.

== Shortcodes ==

### Post Metadata

`[postkit]`

Displays the enabled WP PostKit metadata features together.

### Reading Time

`[postkit_reading_time]`

Displays the estimated reading time of the post.

### Word Count

`[postkit_word_count]`

Displays the total word count of the post.

### Post Views

`[postkit_views]`

Displays the number of views for the post.

### Likes

`[postkit_likes]`

Displays the Like button and current like count.

### Table of Contents

`[postkit_toc]`

Displays a table of contents generated from the post headings.

== Frequently Asked Questions ==

= How do I enable WP PostKit features? =

Go to Settings > WP PostKit > General and enable the features you want to use.

= Can I display post metadata automatically? =

Yes. WP PostKit can automatically display the enabled metadata before or after the post content.

You can also disable automatic metadata display and use the `[postkit]` shortcode manually.

= Can I use individual shortcodes? =

Yes. Each feature has its own shortcode. See the Shortcodes section for the complete list.

= Can I customize the appearance? =

Yes. The Display tab allows you to customize metadata styles, typography, separators, icons, the like button, and the table of contents.

= Does the table of contents support different heading levels? =

Yes. The table of contents detects H2, H3, and H4 headings.

= Does WP PostKit require an external service? =

No. WP PostKit does not require an external service to provide its core features.

== Screenshots ==

1. WP PostKit General settings.
2. WP PostKit Display settings.
3. WP PostKit Shortcodes settings.
4. Post metadata displayed on a post.
5. Table of Contents displayed on a post.
6. Like button and post views displayed on a post.

== Changelog ==

= 1.0.0 =

* Initial release.
* Added reading time.
* Added word count.
* Added table of contents.
* Added post views.
* Added likes.
* Added combined post metadata shortcode.
* Added individual feature shortcodes.
* Added customizable metadata display styles.
* Added customizable typography and colors.
* Added customizable separators.
* Added customizable like button settings.
* Added customizable table of contents settings.
* Added automatic and manual display options.
