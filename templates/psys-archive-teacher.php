<?php get_header(); ?>

<div class="psys-container">
	<div class="psys-row">
		<?php

			if(have_posts()){
				while(have_posts()){
					the_post(); ?>

					<div class="course-container psys-light-box">
						<?php the_post_thumbnail(); ?>
						<?php $permalink = get_the_permalink(); ?>
						<h2 class="course-title"><a href="<?php echo $permalink; ?>"><?php the_title(); ?></a></h2>
						<?php the_excerpt(); ?>
						<a class="psys-button start-button" href="<?php echo $permalink; ?>">Read More</a>
					</div>
				<?php }
					echo '<br><div class="psys-paginate-links">' . paginate_links() . '</div>';
			} else {
				echo __("There are no teachers.", "wp-courses");
			}
			

		?>

	</div>
</div>

<?php get_footer(); ?>