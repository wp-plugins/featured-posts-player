<?php
/*
Plugin Name: Featured Posts Player
Plugin URI: http://weabers.com/wordpress-plugins
Description: This plugin lets you create a player to display a list of entries marked as 'featured'.
Version: 3.3
Author: weabers
Author URI: http://www.weabers.com

License:
Create a player to display a list of entries marked as 'featured'.
Copyright (C) 2011  Diego Jesus Hincapie Espinal

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']))
{
    die('You are not allowed to call this page directly.');
}

if (!class_exists('Featuredpostsplayer'))
{
    class Featuredpostsplayer extends WP_Widget
    {
        public function __construct()
        {
			$widget_ops = array('classname' => 'widget_featuredpostsplayer', 'description' => __( "A player for featured posts") );
            if (is_admin())
            {
				add_action('add_meta_boxes', array($this, 'add_metaboxes'));
				add_action('save_post', array($this, 'savedata'));
			}
			parent::__construct('featuredpostsplayer', __('Featuredpostsplayer', 'featured-posts-player'), $widget_ops);
			add_theme_support( 'post-thumbnails', array( 'post' ) );
			
			wp_enqueue_script('jquery');
			
			wp_register_script('slidesjs', get_bloginfo('wpurl').'/wp-content/plugins/featured-posts-player/libs/js/slides.min.jquery.js');
			wp_enqueue_script('slidesjs');
			
			wp_register_style('slidescss', get_bloginfo('wpurl').'/wp-content/plugins/featured-posts-player/libs/css/global.css');
			wp_enqueue_style('slidescss');
		}

		function widget( $args, $instance ) 
		{	
			query_posts(array('posts_per_page' => $instance['quantity'], 'orderby' => $instance['orderby'], 'order' => $instance['order'], 'cat' => $instance['categorys'], 'meta_query' => array(array('key' => '_wp_post_featured', 'value' => 'on')), 'meta_key' => '_thumbnail_id'));
			
			require_once('views/player.php');
			
			wp_reset_query();
		}
		
		public function form($instance)
		{
			$instance = wp_parse_args((array)$instance, array('categorys' => '', 'quantity' => '', 'orderby' => '' , 'order' => ''));
			
			$width = strip_tags($instance['width']);
			$height = strip_tags($instance['height']);
			$categorys = strip_tags($instance['categorys']);
			$quantity = strip_tags($instance['quantity']);
			$orderby = strip_tags($instance['orderby']);
			$order = strip_tags($instance['order']);
			
			echo '<p><label for="'.$this->get_field_id('width').'">'.__('Width', 'featured-posts-player').': <input class="widefat" id="'.$this->get_field_id('width').'" name="'.$this->get_field_name('width').'" type="text" value="'.attribute_escape($width).'" /></label></p>';
			echo '<p><label for="'.$this->get_field_id('height').'">'.__('Height', 'featured-posts-player').': <input class="widefat" id="'.$this->get_field_id('height').'" name="'.$this->get_field_name('height').'" type="text" value="'.attribute_escape($height).'" /></label></p>';
			echo '<p><label for="'.$this->get_field_id('categorys').'">'.__('Categorys', 'featured-posts-player').': <input class="widefat" id="'.$this->get_field_id('categorys').'" name="'.$this->get_field_name('categorys').'" type="text" value="'.attribute_escape($categorys).'" /></label></p>';
			echo '<p><label for="'.$this->get_field_id('quantity').'">'.__('Quantity', 'featured-posts-player').': <input class="widefat" id="'.$this->get_field_id('quantity').'" name="'.$this->get_field_name('quantity').'" type="text" value="'.attribute_escape($quantity).'" /></label></p>';
			
			
			if($orderby=='post_date')
			{
				$selectedb = ' selected="selected" ';
				$selecteda = '';
				$selectedc = '';
				$selectedd = '';
			}
			else if($orderby=='guid')
			{
				$selectedc = ' selected="selected" ';
				$selecteda = '';
				$selectedb = '';
				$selectedd = '';
			}
			else if($orderby=='menu_order')
			{
				$selectedd = ' selected="selected" ';
				$selecteda = '';
				$selectedb = '';
				$selectedc = '';
			}
			else
			{
				$selecteda = ' selected="selected" ';
				$selectedb = '';
				$selectedc = '';
				$selectedd = '';
			}
			echo '<p><label for="'.$this->get_field_id('orderby').'">'.__('Order By', 'featured-posts-player').': 
			<select name="'.$this->get_field_name('orderby').'" id="'.$this->get_field_id('orderby').'">
			<option value="ID" '.$selecteda.'>'.__('ID', 'featured_posts_player').'</option>
			<option value="post_date" '.$selectedb.'>'.__('post_date', 'featured_posts_player').'</option>
			<option value="guid" '.$selectedc.'>'.__('guid', 'featured_posts_player').'</option>
			<option value="menu_order" '.$selectedd.'>'.__('menu_order', 'featured_posts_player').'</option>
			</select>
			</label></p>';
			
			if($order=='ASC')
			{
				$selecteda = ' selected="selected" ';
				$selectedb = '';
			}
			else
			{
				$selectedb = ' selected="selected" ';
				$selecteda = '';
			}
			echo '<p><label for="'.$this->get_field_id('order').'">'.__('Order', 'featured-posts-player').': 
			<select name="'.$this->get_field_name('order').'" id="'.$this->get_field_id('order').'">
			<option value="ASC" '.$selecteda.'>'.__('ASC', 'featured_posts_player').'</option>
			<option value="DESC" '.$selectedb.'>'.__('DESC', 'featured_posts_player').'</option>
			</select>
			</label></p>';
		}		
		
		function update($new_instance, $old_instance) 
		{
			$instance = $old_instance;
			$instance['categorys'] = strip_tags($new_instance['categorys']);
			$instance['quantity'] = strip_tags($new_instance['quantity']);
			$instance['orderby'] = strip_tags($new_instance['orderby']);
			$instance['order'] = strip_tags($new_instance['order']);
			$instance['width'] = strip_tags($new_instance['width']);
			$instance['height'] = strip_tags($new_instance['height']);
			return $instance;
		}
		
		public function add_metaboxes()
		{
			add_meta_box('wp_fpp_checkbox', __('Featured', 'featured-posts-player'), array($this, 'fpp_checkbox'), 'post', 'side');
		}
		
		public function fpp_checkbox()
		{
			global $post;
			
			$value = get_post_meta($post->ID, '_wp_post_featured', true);
			
			include('views/actfield.php');
		}
		
		public function savedata()
		{
			global $post;
			
			$post_id = $post->ID;
			
			
			
			
			if(($_SERVER['REQUEST_METHOD']=='POST') && ($_POST['action']=='editpost') && ($post->post_status=='publish'))
			{
				if(get_post_meta($post_id, '_wp_post_featured')!='')
				{
					update_post_meta($post_id, '_wp_post_featured', $_POST['_wp_post_featured']);
				}
				else
				{
					add_post_meta($post_id, '_wp_post_featured', $_POST['_wp_post_featured']);
				}
			}
		}
	}
	
	$fpp = new Featuredpostsplayer();
	
	add_action('widgets_init', 'register_fpp_widget');
	function register_fpp_widget() 
	{
    	register_widget('Featuredpostsplayer');
	}
} 