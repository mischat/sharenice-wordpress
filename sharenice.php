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
        $sharenice_colour= apply_filters('sharenice_colour', $instance['sharenice_colour']);
        ?>
            <?php echo $before_widget; ?>
               <?php if ( $title )
                   echo $before_title . $title . $after_title; ?>
               <?php render_sharenice($sharenice_label,$sharenice_colour,$instance); ?>
            <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['sharenice_label'] = strip_tags($new_instance['sharenice_label']);
	$instance['sharenice_colour'] = strip_tags($new_instance['sharenice_colour']);
	return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
        $sharenice_label =esc_attr($instance['sharenice_label']);
        $sharenice_colour =esc_attr($instance['sharenice_colour']);

        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('sharenice_label'); ?>"><?php _e('Share Label:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('sharenice_label'); ?>" name="<?php echo $this->get_field_name('sharenice_label'); ?>" type="text" value="<?php echo $sharenice_label; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('sharenice_colour'); ?>"<?php _e('Color:'); ?></label>
          <select class="widefat" id="<?php echo $this->get_field_id('sharenice_colour'); ?>" name="<?php echo $this->get_field_name('sharenice_colour'); ?>" >
              <option <?php if ($sharenice_colour === "black") { echo 'selected="selected"';} ?> value="black">black</option>
              <option <?php if ($sharenice_colour === "blue") { echo 'selected="selected"';} ?> value="blue">blue</option>
              <option <?php if ($sharenice_colour === "green") { echo 'selected="selected"';} ?> value="green">green</option>
              <option <?php if ($sharenice_colour === "orange") { echo 'selected="selected"';} ?> value="orange">orange</option>
              <option <?php if ($sharenice_colour === "pink") { echo 'selected="selected"';} ?> value="pink">pink</option>
              <option <?php if ($sharenice_colour === "red") { echo 'selected="selected"';} ?> value="red">red</option>
          </select>
        </p>
        <?php
    }

} // class ShareNice

// register ShareNice widget
add_action('widgets_init', create_function('', 'return register_widget("ShareNice");'));

// main work function
function render_sharenice($sharenice_label,$sharenice_colour,$instance) {

    // just a bit of debugging code
    echo "<!-- Plugin Version: ".SMM_VERSION." -->";

    $plugin_dir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

    echo '<script src="http://sharenice.org/code.js" type="text/javascript"></script>';
    echo '<div id="shareNice" data-share-label="'.$sharenice_label.'" data-color-scheme="'.$sharenice_colour.'"></div>';
}

# vi:set expandtab sts=4 sw=4:
