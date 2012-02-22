<div id="slides">
	<div class="slides_container">
		<?php
			$counter = 0;
			while(have_posts())
			{
				the_post();
				
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
				
				echo '<div class="slide">';
				echo '<a href="'.get_permalink().'" title="'.get_the_title().'">';
				echo '<img src="'.get_bloginfo('wpurl').'/wp-content/plugins/featured-posts-player/libs/timthumb.php?w='.$instance['width'].'&h='.$instance['height'].'&q=100&zc=1&src='.str_replace(get_bloginfo('wpurl'), '', $image[0]).'" alt="'.get_the_title().'" width="'.$instance['width'].'" height="'.$instance['height'].'" />';
				echo '</a>';
				echo '<div class="caption">';
				echo '<p>'.get_the_title().'</p>';
				echo '<span>'.get_the_excerpt().'</span>';
				echo '<a href="'.get_permalink().'" title="'.__('View More').'">'.__('View More').'</a>';
				echo '</div>';
				echo '</div>';
				$counter++;
			}	
		?>
	</div>
	<a href="#" class="prev"><img src="<?php echo get_bloginfo('wpurl'); ?>/wp-content/plugins/featured-posts-player/libs/img/arrow-prev.png" alt="<?php echo __('Previous', 'featured-posts-player'); ?>"></a>
	<a href="#" class="next"><img src="<?php echo get_bloginfo('wpurl'); ?>/wp-content/plugins/featured-posts-player/libs/img/arrow-next.png" alt="<?php echo __('Next', 'featured-posts-player'); ?>"></a>
</div>
<style type="text/css">
	.pagination
	{
		width: <?php echo $counter*14; ?>px;
	}
</style>
<script type="text/javascript">
	jQuery(document).ready
	(
		function()
		{
			jQuery('#slides').slides
			(
				{
					preload: false,
					preloadImage: '<?php echo get_bloginfo('wpurl'); ?>/wp-content/plugins/featured-posts-player/libs/img/loading.gif',
					play: 5000,
					pause: 2500,
					hoverPause: true,
					slidesLoaded: function() 
					{
						jQuery('.caption').animate
						(
							{
								bottom:0
							},
							200
						);
					}
				}
			);
		}
	);
</script>