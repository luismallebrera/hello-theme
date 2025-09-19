<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '3.4.4' );
define( 'EHP_THEME_SLUG', 'hello-elementor' );

define( 'HELLO_THEME_PATH', get_template_directory() );
define( 'HELLO_THEME_URL', get_template_directory_uri() );
define( 'HELLO_THEME_ASSETS_PATH', HELLO_THEME_PATH . '/assets/' );
define( 'HELLO_THEME_ASSETS_URL', HELLO_THEME_URL . '/assets/' );
define( 'HELLO_THEME_SCRIPTS_PATH', HELLO_THEME_ASSETS_PATH . 'js/' );
define( 'HELLO_THEME_SCRIPTS_URL', HELLO_THEME_ASSETS_URL . 'js/' );
define( 'HELLO_THEME_STYLE_PATH', HELLO_THEME_ASSETS_PATH . 'css/' );
define( 'HELLO_THEME_STYLE_URL', HELLO_THEME_ASSETS_URL . 'css/' );
define( 'HELLO_THEME_IMAGES_PATH', HELLO_THEME_ASSETS_PATH . 'images/' );
define( 'HELLO_THEME_IMAGES_URL', HELLO_THEME_ASSETS_URL . 'images/' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		if ( apply_filters( 'hello_elementor_register_menus', true ) ) {
			register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello-elementor' ) ] );
		}

		if ( apply_filters( 'hello_elementor_post_type_support', true ) ) {
			add_post_type_support( 'page', 'excerpt' );
		}

		if ( apply_filters( 'hello_elementor_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
					'navigation-widgets',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);
			add_theme_support( 'align-wide' );
			add_theme_support( 'responsive-embeds' );

			/*
			 * Editor Styles
			 */
			add_theme_support( 'editor-styles' );
			add_editor_style( 'assets/css/editor-styles.css' );

			/*
			 * WooCommerce.
			 */
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', true ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_display_header_footer' ) ) {
	/**
	 * Check whether to display header footer.
	 *
	 * @return bool
	 */
	function hello_elementor_display_header_footer() {
		$hello_elementor_header_footer = true;

		return apply_filters( 'hello_elementor_header_footer', $hello_elementor_header_footer );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		if ( apply_filters( 'hello_elementor_enqueue_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor',
				HELLO_THEME_STYLE_URL . 'reset.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				HELLO_THEME_STYLE_URL . 'theme.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( hello_elementor_display_header_footer() ) {
			wp_enqueue_style(
				'hello-elementor-header-footer',
				HELLO_THEME_STYLE_URL . 'header-footer.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hello_elementor_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( ! function_exists( 'hello_elementor_add_description_meta_tag' ) ) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag() {
		if ( ! apply_filters( 'hello_elementor_description_meta_tag', true ) ) {
			return;
		}

		if ( ! is_singular() ) {
			return;
		}

		$post = get_queried_object();
		if ( empty( $post->post_excerpt ) ) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );

/**
 * Output Grid Lines CSS on frontend if enabled
 *
 * @return void
 */
function hello_elementor_grid_lines_css() {
	if ( ! hello_header_footer_experiment_active() ) {
		return;
	}

	$grid_lines_enable = hello_elementor_get_setting( 'hello_grid_lines_enable' );
	
	if ( 'yes' !== $grid_lines_enable ) {
		return;
	}

	$line_color = hello_elementor_get_setting( 'hello_grid_lines_line_color' );
	$column_color = hello_elementor_get_setting( 'hello_grid_lines_column_color' );
	$columns = hello_elementor_get_setting( 'hello_grid_lines_columns' );
	$columns_tablet = hello_elementor_get_setting( 'hello_grid_lines_columns_tablet' );
	$columns_mobile = hello_elementor_get_setting( 'hello_grid_lines_columns_mobile' );
	$outline = hello_elementor_get_setting( 'hello_grid_lines_outline' );
	$max_width = hello_elementor_get_setting( 'hello_grid_lines_max_width' );
	$max_width_tablet = hello_elementor_get_setting( 'hello_grid_lines_max_width_tablet' );
	$max_width_mobile = hello_elementor_get_setting( 'hello_grid_lines_max_width_mobile' );
	$width = hello_elementor_get_setting( 'hello_grid_lines_width' );
	$width_tablet = hello_elementor_get_setting( 'hello_grid_lines_width_tablet' );
	$width_mobile = hello_elementor_get_setting( 'hello_grid_lines_width_mobile' );
	$line_width = hello_elementor_get_setting( 'hello_grid_lines_line_width' );
	$line_width_tablet = hello_elementor_get_setting( 'hello_grid_lines_line_width_tablet' );
	$line_width_mobile = hello_elementor_get_setting( 'hello_grid_lines_line_width_mobile' );
	$direction = hello_elementor_get_setting( 'hello_grid_lines_direction' );
	$z_index = hello_elementor_get_setting( 'hello_grid_lines_z_index' );

	// Set defaults if empty
	$line_color = $line_color ?: '#e1e1e1';
	$column_color = $column_color ?: '#f0f0f0';
	$columns = $columns['size'] ?? 12;
	$columns_tablet = $columns_tablet['size'] ?? 8;
	$columns_mobile = $columns_mobile['size'] ?? 4;
	$outline = $outline ?: 'yes';
	$max_width = $max_width['size'] ?? 1200;
	$max_width_tablet = $max_width_tablet['size'] ?? 768;
	$max_width_mobile = $max_width_mobile['size'] ?? 480;
	$width = $width['size'] ?? 100;
	$width_tablet = $width_tablet['size'] ?? $width;
	$width_mobile = $width_mobile['size'] ?? $width;
	$line_width = $line_width['size'] ?? 1;
	$line_width_tablet = $line_width_tablet['size'] ?? $line_width;
	$line_width_mobile = $line_width_mobile['size'] ?? $line_width;
	$direction = $direction['size'] ?? 0;
	$z_index = $z_index ?? -1;

	$css = '<style id="hello-grid-lines-css">';
	$css .= '.hello-grid-lines-overlay {';
	$css .= 'position: fixed;';
	$css .= 'top: 0;';
	$css .= 'left: 50%;';
	$css .= 'transform: translateX(-50%);';
	$css .= 'height: 100vh;';
	$css .= 'pointer-events: none;';
	$css .= 'z-index: ' . esc_attr( $z_index ) . ';';
	$css .= 'max-width: ' . esc_attr( $max_width ) . 'px;';
	$css .= 'width: ' . esc_attr( $width ) . '%;';
	if ( 'yes' === $outline ) {
		$css .= 'border-left: ' . esc_attr( $line_width ) . 'px solid ' . esc_attr( $line_color ) . ';';
		$css .= 'border-right: ' . esc_attr( $line_width ) . 'px solid ' . esc_attr( $line_color ) . ';';
	}
	$css .= '}';

	$css .= '.hello-grid-lines-columns {';
	$css .= 'display: flex;';
	$css .= 'height: 100%;';
	$css .= 'transform: rotate(' . esc_attr( $direction ) . 'deg);';
	$css .= '}';

	$css .= '.hello-grid-lines-column {';
	$css .= 'flex: 1;';
	$css .= 'background-color: ' . esc_attr( $column_color ) . ';';
	$css .= 'border-right: ' . esc_attr( $line_width ) . 'px solid ' . esc_attr( $line_color ) . ';';
	$css .= '}';

	$css .= '.hello-grid-lines-column:last-child {';
	$css .= 'border-right: none;';
	$css .= '}';

	// Tablet styles
	$css .= '@media (max-width: 1024px) {';
	$css .= '.hello-grid-lines-overlay {';
	$css .= 'max-width: ' . esc_attr( $max_width_tablet ) . 'px;';
	$css .= 'width: ' . esc_attr( $width_tablet ) . '%;';
	if ( 'yes' === $outline ) {
		$css .= 'border-left-width: ' . esc_attr( $line_width_tablet ) . 'px;';
		$css .= 'border-right-width: ' . esc_attr( $line_width_tablet ) . 'px;';
	}
	$css .= '}';
	$css .= '.hello-grid-lines-column {';
	$css .= 'border-right-width: ' . esc_attr( $line_width_tablet ) . 'px;';
	$css .= '}';
	$css .= '}';

	// Mobile styles
	$css .= '@media (max-width: 767px) {';
	$css .= '.hello-grid-lines-overlay {';
	$css .= 'max-width: ' . esc_attr( $max_width_mobile ) . 'px;';
	$css .= 'width: ' . esc_attr( $width_mobile ) . '%;';
	if ( 'yes' === $outline ) {
		$css .= 'border-left-width: ' . esc_attr( $line_width_mobile ) . 'px;';
		$css .= 'border-right-width: ' . esc_attr( $line_width_mobile ) . 'px;';
	}
	$css .= '}';
	$css .= '.hello-grid-lines-column {';
	$css .= 'border-right-width: ' . esc_attr( $line_width_mobile ) . 'px;';
	$css .= '}';
	$css .= '}';

	$css .= '</style>';

	echo $css;
}
add_action( 'wp_head', 'hello_elementor_grid_lines_css' );

/**
 * Output Grid Lines HTML on frontend if enabled
 *
 * @return void
 */
function hello_elementor_grid_lines_html() {
	if ( ! hello_header_footer_experiment_active() ) {
		return;
	}

	$grid_lines_enable = hello_elementor_get_setting( 'hello_grid_lines_enable' );
	
	if ( 'yes' !== $grid_lines_enable ) {
		return;
	}

	$columns = hello_elementor_get_setting( 'hello_grid_lines_columns' );
	$columns_tablet = hello_elementor_get_setting( 'hello_grid_lines_columns_tablet' );
	$columns_mobile = hello_elementor_get_setting( 'hello_grid_lines_columns_mobile' );

	// Set defaults if empty
	$columns = $columns['size'] ?? 12;
	$columns_tablet = $columns_tablet['size'] ?? 8;
	$columns_mobile = $columns_mobile['size'] ?? 4;

	echo '<div class="hello-grid-lines-overlay">';
	echo '<div class="hello-grid-lines-columns">';
	
	// Use desktop columns as base, tablets and mobile will be handled by media queries and JavaScript if needed
	for ( $i = 0; $i < $columns; $i++ ) {
		echo '<div class="hello-grid-lines-column"></div>';
	}
	
	echo '</div>';
	echo '</div>';

	// Add responsive column adjustment script
	echo '<script>';
	echo 'document.addEventListener("DOMContentLoaded", function() {';
	echo 'function adjustGridColumns() {';
	echo 'var overlay = document.querySelector(".hello-grid-lines-columns");';
	echo 'if (!overlay) return;';
	echo 'var screenWidth = window.innerWidth;';
	echo 'var targetColumns = ' . esc_js( $columns ) . ';';
	echo 'if (screenWidth <= 767) { targetColumns = ' . esc_js( $columns_mobile ) . '; }';
	echo 'else if (screenWidth <= 1024) { targetColumns = ' . esc_js( $columns_tablet ) . '; }';
	echo 'var currentColumns = overlay.children.length;';
	echo 'if (currentColumns !== targetColumns) {';
	echo 'overlay.innerHTML = "";';
	echo 'for (var i = 0; i < targetColumns; i++) {';
	echo 'var column = document.createElement("div");';
	echo 'column.className = "hello-grid-lines-column";';
	echo 'overlay.appendChild(column);';
	echo '}';
	echo '}';
	echo '}';
	echo 'adjustGridColumns();';
	echo 'window.addEventListener("resize", adjustGridColumns);';
	echo '});';
	echo '</script>';
}
add_action( 'wp_footer', 'hello_elementor_grid_lines_html' );

// Settings page
require get_template_directory() . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor
require get_template_directory() . '/includes/elementor-functions.php';

if ( ! function_exists( 'hello_elementor_customizer' ) ) {
	// Customizer controls
	function hello_elementor_customizer() {
		if ( ! is_customize_preview() ) {
			return;
		}

		if ( ! hello_elementor_display_header_footer() ) {
			return;
		}

		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_elementor_customizer' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check whether to display the page title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		wp_body_open();
	}
}

require HELLO_THEME_PATH . '/theme.php';

HelloTheme\Theme::instance();
