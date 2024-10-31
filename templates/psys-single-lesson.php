<?php get_header(); ?>
<div class="psys-container">
	<div class="psys-row">
		<div class="psys-sidebar-content psys-light-box">
			<h1><?php the_title(); ?></h1>
			<?php

			while(have_posts()){
				the_post();

				$lesson_id = get_the_ID();
		        $course_id = get_post_meta($lesson_id, 'psys-connected-lesson-to-course', true);
		        $tracking = new Psys_Tracking();
		        $tracking->psys_lesson_tracking( $lesson_id );
		        $tracking->psys_course_tracking();
		        $wp_lessons = new Psys_Lessons();
		        
		        $lesson_nav = $wp_lessons->psys_get_lesson_navigation($course_id);
		        $lesson_pag = $wp_lessons->psys_get_lesson_pagination($course_id);
		        $lesson_video = get_post_meta($lesson_id, 'lesson-video', true);
		        
		        $restriction = get_post_meta( $lesson_id, 'psys-lesson-restriction', true );

		        $custom_logged_out_message = get_option('psys_logged_out_message');

		        if($restriction == 'free-account' && !is_user_logged_in()){ ?>

		        	<p class="psys-content-restricted psys-free-account-required">

		        	<?php if(!empty($custom_logged_out_message)){

		        		echo $custom_logged_out_message;

		        	} else { ?>

		            	<a href="<?php echo wp_login_url( get_permalink() );?>"><?php echo __('Log in', 'wp-courses'); ?></a> <?php echo __('or', 'wp-courses'); ?> <a href="<?php echo wp_registration_url(); ?>"><?php echo __('Register', 'wp-courses'); ?></a> <?php echo __('to view this lesson.', 'wp-courses');

		        	} ?>

		            </p>

		        <?php } else { ?>

		           	<div class="psys-lesson-content"><?php the_content(); ?></div>
		           	<div class="psys-lesson-video">
						<?php 
						if($lesson_video!=''){
							echo $lesson_video; 	
						}
						?>
		           	</div>
		        <?php }
			} ?>
    	</div>
    	<div class="psys-sidebar psys-right-sidebar">
			<h5><strong>Lessons</strong></h5>
    		<div id="lesson-nav-wrapper">
    			<?php echo $lesson_nav; ?>
    		</div>
    	</div>
	</div>
	<div class="psys-row">
		<div class="pagination">
			<?php 
			$lession_by_key = array_flip($lesson_pag['main']);
			$pagination_html = '';
			if($lesson_pag['main'][0]!=$lesson_id){
				$prev_id = $lession_by_key[$lesson_id];
				$prev_id = $prev_id-1;
				$prev_less_id = $lesson_pag['main'][$prev_id];
				
				$pagination_html .= '<li class="prev"><a href="'.get_the_permalink($prev_less_id).'">Prev >></a></li>';
			}

			if(end($lesson_pag['main'])!=$lesson_id){
				$next_id = $lession_by_key[$lesson_id];
				$next_id = $next_id+1;
				$next_less_id = $lesson_pag['main'][$next_id];
				
				$pagination_html .= '<li class="next"><a href="'.get_the_permalink($next_less_id).'"> << Next</a></li>';
			}
			
			if($pagination_html!=''){
				echo '<ul>';
				echo $pagination_html;
				echo '</ul>';
			}
			?>
		</div>		
	</div>
</div>
<?php get_footer(); ?>
