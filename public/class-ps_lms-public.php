<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.perceptionsystem.com
 * @since      1.0.0
 *
 * @package    Ps_lms
 * @subpackage Ps_lms/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ps_lms
 * @subpackage Ps_lms/public
 * @author     Ps Developer <soyab.sumra@perceptionsystem.com>
 */
class Ps_lms_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		require_once PS_LMS_INC . 'class-ps-courses.php';
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ps_lms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ps_lms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ps_lms-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'font-awesome-icons', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ps_lms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ps_lms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ps_lms-public.js', array( 'jquery' ), $this->version, false );
	}
	
	//Use Custom Templates
	public function psys_single_lesson_page_template( $template ){
		if ( get_post_type() == 'ps_lms_lesson' && is_single() ) {
			require_once PS_LMS_INC . 'class-ps-courses.php';
			$new_template = PS_LMS_TEMPLATE_PATH . 'psys-single-lesson.php';
			if ( !empty( $new_template ) ) {
				return $new_template;
			} 
		} else {
			return $template;
		}
	}
	
	public function psys_archive_course_page_template( $template ){
		if ( is_post_type_archive( 'ps_lms_course' )) {
			$new_template = PS_LMS_TEMPLATE_PATH . 'psys-archive-course.php';
			if ( !empty( $new_template ) ) {
				return $new_template;
			} 
		} else {
			return $template;
		}
	}
	
	public function psys_archive_teacher_page_template( $template ){
		if ( is_post_type_archive( 'ps_lms_teacher' )) {
			require_once PS_LMS_INC . 'class-ps-courses.php';
			$new_template = PS_LMS_TEMPLATE_PATH . 'psys-archive-teacher.php';
			if ( !empty( $new_template ) ) {
				return $new_template;
			} 
		} else {
			return $template;
		}
	}
	
	public function psys_single_course_page_template( $template ){
		if ( get_post_type() == 'ps_lms_course' && is_single() ) {
			require_once PS_LMS_INC . 'class-ps-courses.php';
			$new_template = PS_LMS_TEMPLATE_PATH . 'psys-single-course.php';
			if ( !empty( $new_template ) ) {
				return $new_template;
			} 
		} else {
			return $template;
		}
	}
	
	public function psys_single_teacher_page_template( $template ){
		if ( get_post_type() == 'ps_lms_teacher' && is_single() ) {
			require_once PS_LMS_INC . 'class-ps-courses.php';
			$new_template = PS_LMS_TEMPLATE_PATH . 'psys-single-teacher.php';
			if ( !empty( $new_template ) ) {
				return $new_template;
			} 
		} else {
			return $template;
		}
	}

	public function psys_course_category_page_template( $template ){
		if ( is_tax() == 'ps_lms_category' ) {
			require_once PS_LMS_INC . 'class-ps-courses.php';
			$new_template = PS_LMS_TEMPLATE_PATH . 'category-course-category.php';
			if ( !empty( $new_template ) ) {
				return $new_template;
			} 
		} else {
			return $template;
		}
	}	
	// add custom styling to header
	public function psys_custom_styling(){
		$psys_show_viewed_lessons = get_option('psys_show_viewed_lessons');
		$psys_primary_button_color = get_option('psys_primary_button_color', '#23d19f');
		$psys_primary_button_border_color = get_option('psys_primary_button_border_color', '#12ad80');
		$psys_primary_button_text_color = get_option('psys_primary_button_text_color', '#fff');
		$psys_primary_button_hover_color = get_option('psys_primary_button_hover_color', '#23d19f');
		$psys_primary_button_hover_border_color = get_option('psys_primary_button_hover_border_color', '#12ad80');
		$psys_primary_button_hover_text_color = get_option('psys_primary_button_hover_text_color', '#fff');
		$psys_primary_button_active_color = get_option('psys_primary_button_active_color', '#009ee5');
		$psys_primary_button_active_border_color = get_option('psys_primary_button_active_border_color', '#027fb7');
		$psys_primary_button_active_text_color = get_option('psys_primary_button_active_text_color', '#fff');

		echo '<style>';

		if($psys_show_viewed_lessons != 'true'){
			echo '#psys-viewed-lessons-toggle { display: none; }';
		}

		echo '.psys-button { 
			background-color: ' . $psys_primary_button_color . '; 
			border-color: ' . $psys_primary_button_border_color . '; 
			color: ' . $psys_primary_button_text_color . '; 
		}';

		echo '.psys-button:hover { 
			background-color: ' . $psys_primary_button_hover_color . '; 
			border-color: ' . $psys_primary_button_hover_border_color . '; 
			color: ' . $psys_primary_button_hover_text_color . '; 
		}';

		echo '.psys-button.active { 
			background-color: ' . $psys_primary_button_active_color . '; 
			border-color: ' . $psys_primary_button_active_border_color . '; 
			color: ' . $psys_primary_button_active_text_color . '; 
		}';

		echo '.course-category-list ul a { color: ' . $psys_primary_button_text_color . '; }';

		echo '.course-category-list ul a:hover { color: ' . $psys_primary_button_hover_text_color . '; }';

		echo '.course-category-list ul a.active { color: ' . $psys_primary_button_active_text_color . '; }';

		echo '</style>';
	}
	
	
	public function psys_register_shortcodes(){?>
		<?php $psys_course = new Psys_Courses(); 
		ob_start();
		?>
		<div class="psys-container">
			<div class="psys-row">
				<div class="psys-sidebar psys-left-sidebar">
					<?php echo $psys_course->psys_get_course_category_list(); ?>
				</div>
				<div id="courses-wrapper" class="psys-sidebar-content">
					<?php
					$args = array(
						'post_type'			=> array('ps_lms_course'),
						'post_status'			=> 'publish',
					);
					$query = new WP_Query($args);					
						if($query->have_posts()){
							while($query->have_posts()){
								$query->the_post();
								global $post;
								$course_id = $post->ID;
								echo '<div class="course-container psys-light-box">';
									echo '<div class="psys-video-wrapper">';
										include PS_LMS_TEMPLATE_PATH.'template-parts/course-video.php';
									echo '</div>';
									include PS_LMS_TEMPLATE_PATH.'/template-parts/course-details.php';
									include PS_LMS_TEMPLATE_PATH.'/template-parts/course-meta.php';
								echo '</div>';

							}
							wp_reset_postdata();
							echo '<br><div class="psys-paginate-links">' . paginate_links() . '</div>';
						}
					?>
				</div>
			</div>
		</div>
		<?php
		$html .= ob_get_contents();
		ob_end_clean();
		return $html;
	}
}
