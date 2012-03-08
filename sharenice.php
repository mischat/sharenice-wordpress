<?php
/*
Plugin Name: sharenice
Plugin URI: http://wordpress.org/extend/plugins/sharenice/
Description: Displays the <a href="http://sharenice.org/">sharenice</a> ethical social sharing widget
Author: Mischa Tuffield
Version: 0.1
Author URI: http://mmt.me.uk/blog/
*/

define ("SHARENICE_VERSION","0.1");

/*  Copyright 2012 Mischa Tuffield (email : mmt@mmt.me.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * ShareNice Class
 */
class ShareNice extends WP_Widget {
    /** constructor */
    function ShareNice() {
        parent::WP_Widget(false, $name = 'sharenice');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $sharenice_label= apply_filters('sharenice_label', $instance['sharenice_label']);
        ?>
            <?php echo $before_widget; ?>
               <?php if ( $title )
                   echo $before_title . $title . $after_title; ?>
               <?php render_sharenice($sharenice_label,$instance); ?>
            <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['sharenice_label'] = strip_tags($new_instance['sharenice_label']);
	return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
        $sharenice_label =esc_attr($instance['sharenice_label']);

        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('sharenice_label'); ?>"><?php _e('sharenice label'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('sharenice_label'); ?>" name="<?php echo $this->get_field_name('sharenice_label'); ?>" type="text" value="<?php echo $sharenice_label; ?>" />
          <br><i>Enter a sharenice label</i>
        </p>
        <?php
    }

} // class ShareNice

// register ShareNice widget
add_action('widgets_init', create_function('', 'return register_widget("ShareNice");'));

// main work function
function render_sharenice($sharenice_label,$instance) {

    // just a bit of debugging code
    echo "<!-- Plugin Version: ".SMM_VERSION." -->";

    $plugin_dir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

    echo '<script src="http://sharenice.org/code.js" type="text/javascript"></script>';
    echo '<div id="shareNice" data-share-label="'.$sharenice_label.'"></div>';

}

# vi:set expandtab sts=4 sw=4: