<?php

/**
 * Phones Widget
 *
 * @package   acf-contact-widgets
 * @author    Michael W. Delaney
 * @link      
 * @copyright 2016 Michael W. Delaney
 * @license   MIT
 * @version   1.0
 */


/**
 * acf_phones_widget to extend WP_Widget
 */
class acf_phones_widget extends WP_Widget {

        function __construct() {
            $widget_ops = array(
                'classname' => 'acf_phones_widget',
                'description' => 'Display phone numbers entered in Contact Info'
            );
            parent::__construct(
                'acf_phones_widget',
                'Phone Numbers',
                $widget_ops
            );
        }
    
        /**
         * Create the actual widget
         * @param  $args
         * @param  $instance
         * @return string
         */
        function widget($args, $instance) { // widget sidebar output
            extract($args, EXTR_SKIP);
            $title 		= apply_filters('widget_title', $instance['title']);
            // Begin front-end widget output
            $widget = '$before_widget';   
            $widget .= ( $title ) ? $before_title . $title . $after_title : '';

            $widget .= '<address>';
            if( have_rows('phone_numbers', option) ):
                $widget .= '<ul class="list-phone-numbers">';
                while ( have_rows('phone_numbers', option) ) : the_row();
                    $widget .= '<li><span class="phone-label">' . get_sub_field('label') . '</span>' . get_sub_field('number') . '</li>';
                endwhile;
                $widget .= '</ul>';

            endif;
            $widget .= '</address>';
            $widget .=
            $widget .= '$after_widget';

            echo $widget; // Output the widget
        }
    

    
        /**
         * Update the widget
         * @param  [type]
         * @param  [type]
         * @return [type]
         */
        
        function update($new_instance, $old_instance) {		
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            return $instance;
        }
        
        

        /**
         * Create the widget's back-end form
         * @param  [type]
         * @return [type]
         */
        
        function form($instance) {
            $title 		 = isset( $instance['title'] ) ? esc_attr($instance['title']) : '';
            $widget_form = '
                <p>
                    <label 
                        for="' . $this->get_field_id('title') . '">' . 
                            __('Title:') 
                        . '</label> 
                    <input 
                        class="widefat" 
                        id="' .$this->get_field_id('title') . '" 
                        name="' . $this->get_field_name('title') . '" 
                        type="text" 
                        value="' . $title . '" />
            </p>
            <p>
                This widget will display phone numbers entered on the "Contact Info" options pages.
            </p>
            ';
            echo $widget_form;
        }    
}

/**
 * Add the Widget to WordPress
 */
add_action(
    'widgets_init',
    create_function('','return register_widget("acf_phones_widget");')
);