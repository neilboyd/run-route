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

    $text_domain = 'run-route';

    $a = shortcode_atts( array(
        'endomondo' => '',
        'rk_user' => '',
        'rk_route' => '',
    ), $atts );

    $html = "<div class='run-route'>";

    if ($a['endomondo']) {
        $text = __( 'Show route in Endomondo', $text_domain );
        $img = plugins_url( 'endomondo.png', __FILE__ );
        $html .= "\n<span class='endomondo'><a href='http://endomondo.com/routes/" . esc_attr($a['endomondo']) . "'>${text}\n<img class='run-route-image' src='{$img}' alt='${text}' title='${text}' width='50' height='54' /></a></span>\n";
    }

    if ($a['rk_user'] && $a['rk_route']) {
        $text = __( 'Show route in RunKeeper', $text_domain );
        $img = plugins_url( 'runkeeper.png', __FILE__ );
        $html .= "\n<span class='runkeeper'><a href='http://runkeeper.com/user/" . esc_attr($a['rk_user']) . "/route/" . esc_attr($a['rk_route']) . "'>${text}\n<img class='run-route-image' src='{$img}' alt='${text}' title='${text}' width='34' height='54' /></a></span>\n";
    }

    return $html . "</div>";
}

add_action( 'wp_enqueue_scripts', 'run_route_loader' );
add_shortcode( 'run_route', 'run_route_func' );

 ?>
