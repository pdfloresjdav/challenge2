<?php
/**
 * Twenty Twenty-Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Two
 * @since Twenty Twenty-Two 1.0
 */


if ( ! function_exists( 'twentytwentytwo_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

	}

endif;

add_action( 'after_setup_theme', 'twentytwentytwo_support' );

if ( ! function_exists( 'twentytwentytwo_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'twentytwentytwo-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'twentytwentytwo-style' );

	}

endif;

add_action( 'wp_enqueue_scripts', 'twentytwentytwo_styles' );

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';


add_action('rest_api_init', function () {
    register_rest_route('beer-ecommerce/v1', '/stock-price/(?P<code>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_stock_and_price',
        'args' => array(
            'code' => array(
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
        ),
    ));
});

function get_stock_and_price($data) {
    $code = intval($data['code']);
    $stock_price_data = include get_template_directory() . '/stock-price.js';

    if (isset($stock_price_data[$code])) {
        $result = array(
            'stock' => $stock_price_data[$code]['stock'],
            'price' => format_price($stock_price_data[$code]['price']),
        );
        return new WP_REST_Response($result, 200);
    } else {
        return new WP_Error('invalid_sku', 'Invalid SKU code', array('status' => 404));
    }
}

function format_price($price_in_cents) {
    return '$' . number_format($price_in_cents / 100, 2);
}

add_action('template_redirect', function () {
    $request_path = $_SERVER['REQUEST_URI'];
    $matches = [];

    if (preg_match('/^\/(\d+)-(.+)$/', $request_path, $matches)) {
        $productId = intval($matches[1]);
        $brand = urldecode($matches[2]);

        include get_template_directory() . '/product-detail-page.php';
        exit;
    }
});

function get_product_details($product_id, $product_brand) {
    // Implement logic to fetch data from products.js
    $products = include BEER_ECOMMERCE_PLUGIN_DIR . 'products.js';

    foreach ($products as $product) {
        if ($product['id'] == $product_id && sanitize_title($product['brand']) === $product_brand) {
            return $product;
        }
    }

    return array(); // Return an empty array if no matching product is found
}