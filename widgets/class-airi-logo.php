<?php
/**
 * Logo widget
 *
 * @package Airi
 */

class Airi_Logo extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'description' => __('Display your site logo', 'airi') );
        parent::__construct( 'athemes_logo_widget', __('Airi: Logo', 'airi'), $widget_ops );
    }

    function widget($args, $instance) {
        echo $args['before_widget'], airi_site_logo(), $args['after_widget'];
    }

    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    function form( $instance ) {
        
    }
}