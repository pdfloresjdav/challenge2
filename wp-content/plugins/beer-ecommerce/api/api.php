<?php
// api/api.php

function beer_ecommerce_api_init() {
    register_rest_route('beer-ecommerce/v1', '/stock-price/(?P<code>\d+)', array(
        'methods'  => 'GET',
        'callback' => 'beer_ecommerce_get_stock_price',
    ));
}

function beer_ecommerce_get_stock_price($data) {
    $code = $data['code'];
    // Implement logic to fetch data from stock-price.js and return the response
    $stock_price = get_stock_price($code);
    return rest_ensure_response($stock_price);
}

function get_stock_price($code) {
    // Implement logic to fetch data from stock-price.js
    $stock_prices = include BEER_ECOMMERCE_PLUGIN_DIR . 'stock-price.js';
    return isset($stock_prices[$code]) ? $stock_prices[$code] : array();
}

add_action('rest_api_init', 'beer_ecommerce_api_init');
