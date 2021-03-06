<?php

/**
 * Address Widget
 *
 * @package   acf-contact-widgets
 * @author    Michael W. Delaney
 * @link      
 * @copyright 2016 Michael W. Delaney
 * @license   MIT
 * @version   1.0
 */


/**
 * acf_address_widget to extend WP_Widget
 */
class acf_address_widget extends WP_Widget {

        function __construct() {
            $widget_ops = array(
                'classname' => 'acf_address_widget',
                'description' => 'Display address information entered in Contact Info'
            );
            parent::__construct(
                'acf_address_widget',
                'Address Information',
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
            $widget = $before_widget;   
            $widget .= ( $title ) ? $before_title . $title . $after_title : '';

            $widget .= '<address>';
            $widget .= (get_field('company_name', 'option')) ? '<span class="contact-company-name"> ' .get_field('company_name', 'option') . '</span><br>' : '';
            $widget .= (get_field('address', 'option')) ? '<span class="contact-address"> ' .get_field('address', 'option') . '</span><br>' : '';
            $widget .= (get_field('address_line_2', 'option')) ? '<span class="contact-address-2"> ' .get_field('address_line_2', 'option') . '</span><br>' : '';
            $widget .= (get_field('city', 'option')) ? '<span class="contact-city"> ' .get_field('city', 'option') . '</span>, ' : '';
            $widget .= (get_field('state', 'option')) ? '<span class="contact-state"> ' .get_field('state', 'option') . '</span> ' : '';
            $widget .= (get_field('zip', 'option')) ? '<span class="contact-zip"> ' .get_field('zip', 'option') . '</span> ' : '';
            $widget .= (get_field('country', 'option')) ? '<span class="contact-country"> ' .get_field('country', 'option') . '</span>' : '';
            $widget .= '</address>';
            $widget .= $after_widget;

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
                This widget will display address information entered on the "Contact Info" options pages.
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
    create_function('','return register_widget("acf_address_widget");')
);
