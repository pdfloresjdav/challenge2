<?php
/**
 * Plugin Name: Beer E-Commerce
 * Description: Custom plugin for beer e-commerce challenge.
 * Version: 1.0
 * Author: Pedro Flores
 */

// Acciones o funciones del plugin

// Register Gutenberg Block
function register_pdp_block() {
    register_block_type(
        'beer-ecommerce-plugin/pdp-block',
        array(
            'editor_script' => 'beer-ecommerce-plugin-editor-script',
        )
    );
}
add_action('init', 'register_pdp_block');

function beer_ecommerce_custom_urls() {
    // Añadir reglas de reescritura para manejar las URL personalizadas
    add_rewrite_rule('^([0-9]+)-([^/]+)/?', 'index.php?beer_product_id=$matches[1]&beer_product_brand=$matches[2]', 'top');
}

// Enqueue editor script for the block
function enqueue_block_editor_script() {
    wp_enqueue_script(
        'beer-ecommerce-plugin-editor-script',
        plugins_url('dist/pdp-block.js', __FILE__),
        array('wp-blocks', 'wp-editor', 'wp-components', 'wp-data'),
        filemtime(plugin_dir_path(__FILE__) . 'dist/pdp-block.js')
    );
}
add_action('enqueue_block_editor_assets', 'enqueue_block_editor_script');

// API Endpoint para obtener información de stock y precio
function beer_ecommerce_api_init() {
    register_rest_route('beer-ecommerce-plugin/v1', '/stock-price/(?P<code>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_stock_price',
    ));
}
add_action('rest_api_init', 'beer_ecommerce_api_init');

function get_stock_price($data) {
    // Lógica para obtener información de stock y precio basada en $data['code']
    // (puedes utilizar la lógica que necesites)
    $code = $data['code'];
    $stock_price_data = include(plugin_dir_path(__FILE__) . 'stock-price.js');
    $response = isset($stock_price_data[$code]) ? $stock_price_data[$code] : array();
    return rest_ensure_response($response);
}

// Lógica para actualizar datos cada 5 segundos (esto podría ir en tu bloque de Gutenberg)
function schedule_data_update() {
    if (!wp_next_scheduled('beer_ecommerce_data_update')) {
        wp_schedule_event(time(), '5s', 'beer_ecommerce_data_update');
    }
}
add_action('init', 'schedule_data_update');

function beer_ecommerce_data_update() {
    // Lógica para actualizar datos (esto podría ir en tu bloque de Gutenberg)
    // (puedes utilizar la lógica que necesites)
    // Puedes utilizar transients para almacenar datos actualizados
}
add_action('beer_ecommerce_data_update', 'beer_ecommerce_data_update');

function beer_ecommerce_register_api_routes() {
    register_rest_route(
        'beer-ecommerce-plugin/v1',
        '/stock-price/(?P<code>\d+)',
        array(
            'methods' => 'GET',
            'callback' => 'beer_ecommerce_get_stock_price',
            'args' => array(
                'code' => array(
                    'validate_callback' => function($param, $request, $key) {
                        return is_numeric($param);
                    }
                ),
            ),
        )
    );
}

function beer_ecommerce_get_stock_price($data) {
    $code = $data['code'];

    // Lógica para obtener información de stock y precio según el código
    $stock_price_data = get_stock_price_data($code);

    if (isset($stock_price_data['price'])) {
        // Convertir el precio de centavos a dólares con 2 decimales
        $price_in_dollars = number_format($stock_price_data['price'] / 100, 2);

        // Actualizar el valor del precio en la respuesta
        $stock_price_data['price'] = $price_in_dollars;
    }

    return rest_ensure_response($stock_price_data);
}


function get_stock_price_data($code) {
    // Lógica para obtener información de stock y precio desde stock-price.js
    // Aquí puedes usar la información de stock-price.js o realizar llamadas a bases de datos u otros servicios

    // Ejemplo usando el stock-price.js proporcionado en la pregunta
    $stock_price_data = include('stock-price.js');
    
    if (isset($stock_price_data[$code])) {
        return $stock_price_data[$code];
    } else {
        return array('error' => 'Product not found');
    }
}

add_action('rest_api_init', 'beer_ecommerce_register_api_routes');

// Enqueue styles
function beer_ecommerce_enqueue_styles() {
    wp_enqueue_style('beer-ecommerce-styles', plugins_url('css/styles.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'beer_ecommerce_enqueue_styles');

// Shortcode para mostrar detalles del producto
function beer_ecommerce_product_details_shortcode($atts) {
    // Obtener el ID y la marca del producto desde los atributos del shortcode
    $product_id = $atts['id'];
    $product_brand = $atts['brand'];

    // Aquí deberías obtener la información del producto y el precio utilizando tus datos (products.js y stock-price.js)

    // ... Código para obtener información del producto y precio ...

    // Output del HTML con la información del producto
    ob_start(); ?>

    <div class="beer-product-details">
        <img src="<?php echo esc_url($product_image_url); ?>" alt="<?php echo esc_attr($product_brand); ?>">
        <div class="product-info">
            <h2><?php echo esc_html($product_brand); ?></h2>
            <p class="product-price">$<?php echo number_format($product_price / 100, 2); ?></p>
            <p><?php echo esc_html($product_information); ?></p>
        </div>
    </div>

    <?php
    return ob_get_clean();
}

add_shortcode('beer_ecommerce_product_details', 'beer_ecommerce_product_details_shortcode');