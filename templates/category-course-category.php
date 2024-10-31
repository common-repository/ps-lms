<?php get_header(); ?>
<?php $psys_course = new Psys_Courses(); ?>

<div class="psys-container">
	<div class="psys-row">
		<div class="psys-sidebar psys-left-sidebar">
			<?php echo $psys_course->psys_get_course_category_list(); ?>
		</div>
		<div id="courses-wrapper" class="psys-sidebar-content">

			<?php

				if(have_posts()){
					while(have_posts()){
						the_post();

						echo '<div class="course-container psys-light-box">';
							echo '<div class="psys-video-wrapper">';
								include 'template-parts/course-video.php';
							echo '</div>';
							include 'template-parts/course-details.php';
							include 'template-parts/course-meta.php';
						echo '</div>';

					}

					wp_reset_postdata();

					echo '<br><div class="psys-paginate-links">' . paginate_links() . '</div>';
				}

			?>

		</div>
	</div>
</div>

<?php get_footer(); ?>
