<?php
/**
 * Plugin Name: run-route
 * Version: 1.1
 * Author: Neil Boyd
 * Author URI: http://L6.org/
 * Description: Adds a shortcode to display links to routes in Endomondo and RunKeeper
 * License: GPLv2 or later
 */

function run_route_loader() {
    wp_register_style( 'run-route', plugins_url( 'run-route.css', __FILE__ ) );
    wp_enqueue_style( 'run-route' );
}

function run_route_func( $atts ) {
    $a = shortcode_atts( array(
        'endomondo' => '',
        'rk_user' => '',
        'rk_route' => '',
    ), $atts );

    $html = "<div class='run-route'>";

    if ($a['endomondo']) {
        $img = plugins_url( 'endomondo.png', __FILE__ );
        $html .= "<span class='endomondo'><a href='http://endomondo.com/routes/" . esc_attr($a['endomondo']) . "'>Show route in Endomondo\n<img class='run-route-image' src='{$img}' alt='Show route in Endomondo' title='Show route in Endomondo' width='50' height='54' /></a></span>\n";
    }

    if ($a['rk_user'] && $a['rk_route']) {
        $img = plugins_url( 'runkeeper.png', __FILE__ );
        $html .= "<span class='runkeeper'><a href='http://runkeeper.com/user/" . esc_attr($a['rk_user']) . "/route/" . esc_attr($a['rk_route']) . "'>Show route in RunKeeper\n<img class='run-route-image' src='{$img}' alt='Show route in RunKeeper' title='Show route in RunKeeper' width='34' height='54' /></a></span>\n";
    }

    return $html . "</div>";
}

add_action( 'wp_enqueue_scripts', 'run_route_loader' );
add_shortcode( 'run_route', 'run_route_func' );

 ?>
