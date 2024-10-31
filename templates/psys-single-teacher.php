<?php get_header(); ?>

<div class="psys-container">
	<div class="psys-row">
		<div class="psys-sidebar psys-left-sidebar">
			<div class="psys-single-teacher-thumbnail">
    			<?php echo get_the_post_thumbnail(); ?>
    		</div>
    	</div>
		<div class="psys-sidebar-content psys-light-box">

			<h1><?php echo __('About', 'wp-courses'); ?> <?php the_title(); ?></h1>
			<?php 
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post(); 
						the_content();
					} // end while
				} // end if
			?>			
    	</div>
	</div>
</div>

<?php get_footer(); ?>