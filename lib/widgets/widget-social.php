<?php

/**
 * Social Media Accounts Widget
 *
 * @package   acf-contact-widgets
 * @author    Michael W. Delaney
 * @link      
 * @copyright 2016 Michael W. Delaney
 * @license   MIT
 * @version   1.0
 */


/**
 * acf_social_widget to extend WP_Widget
 */
class acf_social_widget extends WP_Widget {

        function __construct() {
            $widget_ops = array(
                'classname' => 'acf_social_widget',
                'description' => 'Display social media accounts entered in Contact Info'
            );
            parent::__construct(
                'acf_social_widget',
                'Social Media Accounts',
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
            if( have_rows('social_accounts', 'option') ):
                $widget .= '<ul class="list-social-accounts">';
                while ( have_rows('social_accounts', 'option') ) : the_row();
                    $widget .= '<li>
                                    <a class="social-media-link muted" style="color: ' . get_sub_field('color') . '" href="' . get_sub_field('link') . '">
                                        <span class="fa-stack fa-lg">
                                            <i class="fa fa-square fa-stack-2x fa-inverse"></i>
                                            <i class="fa ' . get_sub_field('icon') . ' fa-stack-2x"></i>
                                        </span>
                                        <span class="account-name">' . get_sub_field('account_name') . '</span>
                                    </a>
                                </li>';
                endwhile;
                $widget .= '</ul>';

            endif;
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
                This widget will display social media accounts entered on the "Contact Info" options pages.
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
    create_function('','return register_widget("acf_social_widget");')
);