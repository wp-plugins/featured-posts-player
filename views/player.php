<div id="slides">
	<div class="slides_container">
		<?php
			$counter = 0;
			while(have_posts())
			{
				the_post();
				
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
                                
                                $image[0] = str_replace(get_bloginfo('siteurl'), '', $image[0]);
                                
				echo '<div class="slide">';
                                
                                echo '<img src="'.get_bloginfo('siteurl').'/wp-content/plugins/featured-posts-player/resize.php?w=1190&h=345&src='.$image[0].'" />';
                                
				echo '<div class="caption">';
                                $excerpt = get_the_excerpt();
				echo '<a href="'.get_permalink().'" title="'.get_the_title().'"><h1>'.get_the_title().'</h1></a>';
				echo '</div>';
				echo '</div>';
				$counter++;
			}	
		?>
	</div>
</div>
<style type="text/css">
	.pagination
	{
		width: <?php echo $counter*12; ?>px;
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
                                        pagination: false,
                                        generatePagination: false,
					preload: true,
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