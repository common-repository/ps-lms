<?php $course_id = get_the_ID(); ?>
<?php $course_video = get_post_meta($course_id, 'psys_video_id', true); ?>

<?php if($course_video != ''){
		if(strpos($course_video, 'iframe') === false && !empty($course_video)){
			if(preg_match("/[a-z]/i", $lesson_video) || preg_match("/[A-Z]/i", $course_video)){
			    $course_video = '<iframe class="psys-video" id="video-iframe" width="560" height="315" src="https://www.youtube.com/embed/' . $course_video . '" frameborder="0" allowfullscreen></iframe>';
			} else {
				$course_video = '<iframe class="psys-video" id="video-iframe" src="https://player.vimeo.com/video/' . $course_video . '" width="500" height="216" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			}
		}
		echo $course_video;
} else{
	echo get_the_post_thumbnail($course_id, 'large');
} ?>
