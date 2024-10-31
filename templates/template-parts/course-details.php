<div class="course-excerpt">
	<h2 class="course-title">
		<a href="<?php echo get_the_permalink(); ?>">
			<?php echo get_the_title(); ?>
		</a>
	</h2>
	<?php 

		do_action('psys_after_course_title');

		if(is_archive()){
			the_excerpt();
		} else {
			the_content();
		}

	?>
</div>

<?php $psys_course = new Psys_Courses(); ?>
<?php echo $psys_course->psys_get_start_course_button(get_the_ID()); ?>
