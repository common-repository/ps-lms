<?php $psys_course = new Psys_Courses(); ?>
<?php //$course_id = $post->ID; ?>
<?php $teacher_id = get_post_meta( $course_id, 'psys-connected-teacher-to-course', true ); ?>
<?php $teacher_link = get_the_permalink( $teacher_id, false ); ?>

<div class="course-meta-wrapper">
	<div class="cm-item teacher-meta-wrapper">
		<span>
			<?php echo __('Teacher: ', 'wp-courses'); ?>
				<a href="<?php echo $teacher_link; ?>">
					<?php echo get_the_title($teacher_id); ?>
				</a>
		</span>
	</div>
	<?php if(is_user_logged_in()){ ?>
		<div class="cm-item">
			<span>
				<?php echo __('Viewed: ', 'wp-courses') . $psys_course->psys_get_percent_viewed($course_id); ?>%
			</span>
		</div>
		<div class="cm-item">
			<span>
				<?php 

					$show_completed_button = get_option('psys_show_completed_lessons');

					if($show_completed_button == 'true') {
						//echo $psys_course->psys_get_progress_bar($course_id);
					}
					
				?>
			</span>
		</div>
	<?php } ?>
</div>
