<?php
class Psys_Courses{
	public function psys_get_percent_viewed($course_id){
		$psys_lessons = new psys_Lessons();
		$all_lessons = $psys_lessons->psys_get_connected_lessons($course_id);
		$psys_tracking = new psys_Tracking;
		$viewed_lessons = $psys_tracking->get_psys_lesson_tracking();
		$matching_lessons = array_intersect($viewed_lessons, $all_lessons);
		$lesson_count = count($all_lessons);
		if( $lesson_count > 0 ) {
			$percent_viewed = count($matching_lessons) / count($all_lessons); 
			$percent_viewed = $percent_viewed * 100;
		} else {
			$percent_viewed = 0;
		}
		return round($percent_viewed);
	}
	public function psys_get_percent_completed($course_id){
		$psys_lessons = new psys_Lessons();
		$all_lessons = $psys_lessons->psys_get_connected_lessons($course_id);
		$completed_tracking = get_user_meta(get_current_user_id(), 'psys-completed-lesson-tracking', true);
		if(!empty($completed_tracking)){
			$matching_lessons = array_intersect($completed_tracking, $all_lessons);
		} else {
			$matching_lessons = NULL;
		}
		$lesson_count = count($all_lessons);
		if( $lesson_count > 0 ) {
			$percent_viewed = count($matching_lessons) / count($all_lessons); 
			$percent_viewed = $percent_viewed * 100;
		} else {
			$percent_viewed = 0;
		}
		return round($percent_viewed);
	}
	public function psys_get_progress_bar($course_id){
		$completed_percent = $this->psys_get_percent_completed($course_id);
		$data = '<div class="psys-progress-bar"><div class="psys-progress-bar-level" style="width:' . $completed_percent . '%;"><div class="psys-progress-bar-text"><i class="fa fa-check"></i> ' . $completed_percent . '% ' . __('Completed', 'ps-lms') . '</div></div></div>';
		return $data;
	}
	public function psys_get_course_category_list($get = '', $class = ''){
		$data = '';
		$categories = get_terms('ps_lms_category');
		$cat = get_queried_object();
		$cat = $cat->slug;
		$data .= '<div class="ps_lms_category-list">';
		$data .= '<h3>' . __('Course Categories', 'ps-lms') . '</h3>';
		$data .= '<ul>';
		if(!empty($categories)){
			foreach($categories as $category){
				$category->slug == $cat ?	$active = 'active' : $active = '';
				$data .= '<li><a href="' . home_url() . '/ps_lms_category/' . $category->slug . $get . '" class="psys-button ' . $class . ' ' . $active . '">' . $category->name . '</a></li>';
			}
		} else {
			return 'There are no course categories.';
		}
		$data .= '</ul>';
		$data .= '</div>';
		return $data;
	}
	public function psys_get_course_list($get = ''){
		do_action('psys_before_psys_get_course_list');
		$course_args = array(
			'post_type'			=> 'ps_lms_course',
			'nopaging' 			=> true,
			'order'				=> 'ASC',
			'orderby'			=> 'menu_order',
			'post_status'		=> 'publish',
		);
		$course_query = new WP_Query($course_args);
		$data = '';
		$data .= '<ul class="course-list">';
		while($course_query->have_posts()){
			$course_query->the_post();
			$data .= '<li class="lesson-button" data-id="' . get_the_ID() . '"><i class="fa fa-bars"></i> ' . get_the_title() . '</li>';
		}
		$data .= '</ul>';
		wp_reset_postdata();
		do_action('psys_after_psys_get_course_list');
		return $data;
	}
	public function psys_get_course_difficulty($post_id){
		$data = '';
		$terms = wp_get_post_terms($post_id, 'course-difficulty');
		foreach($terms as $term){
			$data .= $term->name;
		}
		if(!empty($term)){
			return '<span class="difficulty-' . $term->slug . ' course-difficulty">' . $data . '</span>';
		} else {
			return '';
		}
	}
	public function psys_get_start_course_button($course_id){
		$course_id = (empty($course_id)) ? get_the_ID() : $course_id;
		$args = array(
			'post_type'			=> 'ps_lms_lesson',
			'meta_value'		=> $course_id,
			'meta_key'			=> 'psys-connected-lesson-to-course',
			'posts_per_page'	=> 1,
			'paged'				=> false,
			'nopaging' 			=> true,
			'order'				=> 'ASC',
			'orderby'			=> 'menu_order'
		);
		$query = new WP_Query($args);
		$course_link = '';
		if($query->have_posts()){
			while($query->have_posts()){
				$query->the_post();

				$course_link = get_the_permalink();

				break;
			}
		}
		
		wp_reset_postdata();

		$button = '<a class="start-button psys-button" href="' . $course_link . '">' . __('Start Course ', 'ps-lms') . '<i class="fa fa-arrow-right"></i></a>';

		if(has_filter('psys_start_course_button')){
			$button = apply_filters( 'psys_start_course_button', $button );
		}

		return $button;

	}
}
class Psys_Lessons{
	public function __construct(){
		$this->post_id = get_the_ID();
	}
	public function psys_get_lesson_attachments($lesson_id){

		$attachments = array();
		for($i = 1; $i<=3; $i++){
			$url = get_post_meta( $lesson_id, 'psys-media-sections-' . $i, true );
			if(!empty($url)){
				array_push($attachments, $url);
			}

		}
		return $attachments;
	}
	public function psys_get_lesson_video($lesson_id, $show_title = true){
		do_action('psys_before_lesson_video');
		$data = '';
		$lesson_video = get_post_meta($lesson_id, 'lesson-video', true);
		if(strpos($lesson_video, 'iframe') === false && !empty($lesson_video)){
			if(preg_match("/[a-z]/i", $lesson_video) || preg_match("/[A-Z]/i", $lesson_video)){
				$lesson_video = '<iframe class="psys-video" id="video-iframe" width="560" height="315" src="https://www.youtube.com/embed/' . $lesson_video . '" frameborder="0" allowfullscreen></iframe>';
			} else {
				$lesson_video = '<iframe class="psys-video" id="video-iframe" src="https://player.vimeo.com/video/' . $lesson_video . '" width="500" height="216" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			}
		}
		if(has_filter( 'psys_lesson_video' )){
			$lesson_video = apply_filters( 'psys_lesson_video', $lesson_video );
		}
		if($show_title == true){
			$data .= '<h1>' . get_the_title() . '</h1>';
		}
		$course_id = get_post_meta($lesson_id, 'psys-connected-lesson-to-course', true);

		$data .= $lesson_video;
		do_action('psys_after_lesson_video');

		return $lesson_video;
		
	}
	// gets lessons that are connected to the same course as $lesson_id
	public function psys_get_connected_lessons($course_id){
		global $wpdb;
		$prefix = $wpdb->prefix;
		$lessons = $wpdb->get_results("SELECT post_id FROM {$prefix}postmeta WHERE meta_value = $course_id AND meta_key = 'psys-connected-lesson-to-course'");
		$lessons_array = array();
		foreach( $lessons as $lesson ){
			array_push($lessons_array, $lesson->post_id);
		}
		return $lessons_array;
	}
	public function psys_get_lesson_list($course_id){
		$data = '';
		$lessons = $this->psys_get_connected_lessons( $course_id );
		if(!empty($lessons)){
			$args = array(
				'post_type'			=> 'ps_lms_lesson',
				'post__in'			=> $lessons,
				'nopaging' 			=> true,
				'order'				=> 'ASC',
				'orderby'			=> 'menu_order'
			);
			$query = new WP_Query($args);
			$data .= '<ul class="lesson-list">';
			while($query->have_posts()){
				$query->the_post();
				$id = get_the_ID();
				$link = get_edit_post_link( $id );

				$data .= '<li data-id="' . $id . '"><a href="' . $link . '">' . get_the_title() . '</a></li>';
			
			}
			$data .= '</ul>';
			wp_reset_postdata();
		}
		return $data;
	}
	public function psys_get_lesson_navigation($course_id){
		$data = '';
		$count = 1;
		$lessons = $this->psys_get_connected_lessons($course_id);
		$tracking = new psys_Tracking();
		$tracking = $tracking->get_psys_lesson_tracking();
		$completed_tracking = get_user_meta(get_current_user_id(), 'psys-completed-lesson-tracking', true);
		if(is_array($completed_tracking) == false){
			$completed_tracking = array();
		}
		if(!empty($lessons)){
			$args = array(
				'post_type'			=> array('ps_lms_lesson'),
				'post__in'			=> $lessons,
				'nopaging' 			=> true,
				'order'				=> 'ASC',
				'orderby'			=> 'menu_order'
			);
			$query = new WP_Query($args);
			$data .= '<ul class="lesson-nav">';
			$this_post_id = get_the_ID();
			while($query->have_posts()){
				$query->the_post();
				$lesson_button_id = get_the_ID();
				$post_id = $lesson_button_id;
				$restriction = get_post_meta( $post_id, 'psys-lesson-restriction', true );
				$show_lesson_nav_icons = get_option('psys_show_lesson_nav_icons');								
				if($show_lesson_nav_icons == 'true'){
					if( is_user_logged_in() ){
						if(in_array($post_id, $completed_tracking)){
							$icon = '<i class="fa fa-check psys-default-status"></i>';
						} elseif(in_array($post_id, $tracking)){
							$icon = '<i class="fa fa-eye psys-default-status"></i>';
						} else {
							$icon = '<i class="fa fa-play psys-default-status"></i>';
						}
						
					} else {
						if($restriction == 'none'){
							$icon = '<i class="fa fa-play psys-default-status"></i>';
						} else {
							$icon = '<i class="fa fa-lock psys-default-status"></i>';
						}
					}
				} else {
					$icon = '';
				}
							
				if(has_filter( 'psys_lesson_button_icon' )){
					$icon = apply_filters( 'psys_lesson_button_icon', $icon, $lesson_id );
				}
				
				if($this->post_id == $lesson_button_id){
					$active = ' class="active-lesson-button"';
				} else{
					$active = '';
				}

				$data .= '<li' . $active . '><a data-lesson-button-id="' . $post_id . '" class="lesson-button" href="' . get_the_permalink() . '">' . $icon . $count . ' - ' . get_the_title() . '</a></li>';			

				$count++;
			}
			$data .= '</ul>';

			$module_exists = false;

			wp_reset_postdata();
		}
		return $data;
	}

	public function psys_get_lesson_pagination($course_id){
		$page_html = '';
		$count = 1;
		$lessons = $this->psys_get_connected_lessons($course_id);
		$cur_lesson_id = get_the_id();
		$page_Arr = array();
		$tracking = new psys_Tracking();
		$tracking = $tracking->get_psys_lesson_tracking();
		$completed_tracking = get_user_meta(get_current_user_id(), 'psys-completed-lesson-tracking', true);
		if(is_array($completed_tracking) == false){
			$completed_tracking = array();
		}
		if(!empty($lessons)){
			$args = array(
				'post_type'			=> array('ps_lms_lesson'),
				'post__in'			=> $lessons,
				'exclude'			=> array($cur_lesson_id),
				'nopaging' 			=> true,
				'order'				=> 'ASC',
				'orderby'			=> 'menu_order'
			);
			$query = new WP_Query($args);
			$this_post_id = get_the_ID();
			$page_Arr['current'][] = $this_post_id;
			while($query->have_posts()){
				$query->the_post();
				$lesson_button_id = get_the_ID();
				$post_id = $lesson_button_id;
				$page_Arr['main'][] = $post_id;
				$count++;
			}
			wp_reset_postdata();
		}
		return $page_Arr;
	}	
}
class Psys_Tracking{
	// call this function to initiate tracking.
	public function psys_lesson_tracking($post_id){
		$user_id = get_current_user_id();
		$viewed_lessons = get_user_meta($user_id, 'psys-lesson-tracking', true);
		if($viewed_lessons == '' || count($viewed_lessons) < 1){
			$viewed_lessons = array($post_id);
			update_user_meta($user_id, 'psys-lesson-tracking', $viewed_lessons );
		} else{
			//$viewed_lessons = array_unique($viewed_lessons);
			array_unshift($viewed_lessons, $post_id);
			$viewed_lessons = array_unique($viewed_lessons);
			update_user_meta($user_id, 'psys-lesson-tracking', $viewed_lessons);
		}
		return;
	}
	// return array of viewed lesson ids
	public function get_psys_lesson_tracking(){
		$user_id = get_current_user_id();
		$lessons = get_user_meta($user_id, 'psys-lesson-tracking', true);
		if(empty($lessons)){
			$lessons = array();
		}
		return $lessons;
	}
	// This function checks if course is completed and updates user meta accordingly
	public function psys_course_tracking(){
		$user_id = get_current_user_id();
		$psys_courses = new psys_Courses();
		$lesson_id = get_the_ID();
		$course_id = get_post_meta($lesson_id, 'psys-connected-lesson-to-course', true);
		$percent = $psys_courses->psys_get_percent_viewed($course_id);
		$completed_courses = get_user_meta($user_id, 'psys-completed-courses', true );
		 
		if($percent == 100){
			if(empty($completed_courses)){
				$completed_courses = array($course_id);
				update_user_meta($user_id, 'psys-completed-courses', $completed_courses );
			} else{
				array_push($completed_courses, $course_id);
				$completed_courses = array_unique($completed_courses);
				update_user_meta($user_id, 'psys-completed-courses', $completed_courses);
			}
		}
	}
}
?>
