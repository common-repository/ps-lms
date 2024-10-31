<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.perceptionsystem.com
 * @since      1.0.0
 *
 * @package    Ps_lms
 * @subpackage Ps_lms/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ps_lms
 * @subpackage Ps_lms/admin
 * @author     Ps Developer <soyab.sumra@perceptionsystem.com>
 */
class Ps_lms_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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
		 
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ps_lms-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'font-awesome-icons', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	}

	/**
	 * Register the JavaScript for the admin area.
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
		 
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ps_lms-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * register tab post type
	 */
	public function psys_course_post_type(){
	  $labels = array(
		'name'               => _x( 'Courses', 'post type general name'),
		'singular_name'      => _x( 'Course', 'post type singular name'),
		'add_new'            => _x( 'Add New', 'Course'),
		'add_new_item'       => __( 'Add New Course'),
		'edit_item'          => __( 'Edit Course' ),
		'new_item'           => __( 'New Course' ),
		'all_items'          => __( 'All Courses' ),
		'view_item'          => __( 'View Course' ),
		'search_items'       => __( 'Search Courses' ),
		'not_found'          => __( 'No Courses Found' ),
		'not_found_in_trash' => __( 'No Courses Found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Courses'
		);
	  $args = array(
		'labels'              => $labels,
		'show_in_admin_bar'   => true,
		'menu_icon'           => '',
		'show_in_nav_menus'   => false,
		'publicly_queryable'  => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'show_in_menu'        => '',
		'description'         => 'Enter a Course Description Here',
		'public'              => true,
		'show_ui'             => true,
		'hierarchical'        => false,
		'supports'            => array('title', 'editor', 'excerpt', 'page-attributes', 'thumbnail'),
		'has_archive'         => true,
		'hierarchical'        => false,
		);
		register_post_type('ps_lms_course', $args);
	}

	//Custom Messages for Course
	public function psys_course_messages( $messages ) {
		global $post;
		$post_ID = get_the_id();
		$messages['course'] = array(
			0 => '', 
			1 => sprintf( __('Course updated. <a href="%s">View Course</a>'), esc_url( get_permalink($post_ID) ) ),
			2 => __('Custom field updated.'),
			3 => __('Custom field deleted.'),
			4 => __('Course updated.'),
			5 => isset($_GET['revision']) ? sprintf( __('Course restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __('Course published. <a href="%s">View Course</a>'), esc_url( get_permalink($post_ID) ) ),
			7 => __('Course saved.'),
			8 => sprintf( __('Course submitted. <a target="_blank" href="%s">Preview Course</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			9 => sprintf( __('Course scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Course</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( __('Course draft updated. <a target="_blank" href="%s">Preview Course</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		);
	  return $messages;
	}

	// Register Custom Post Type Lesson
	public function psys_register_post_type(){
	  $labels = array(
		'name'               => _x( 'Lesson', 'post type general name' ),
		'singular_name'      => _x( 'Lesson', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'Lesson' ),
		'add_new_item'       => __( 'Add New Lesson' ),
		'edit_item'          => __( 'Edit Lesson' ),
		'new_item'           => __( 'New Lesson' ),
		'all_items'          => __( 'All Lessons' ),
		'view_item'          => __( 'View Lesson' ),
		'search_items'       => __( 'Search Lessons' ),
		'not_found'          => __( 'No Lessons found' ),
		'not_found_in_trash' => __( 'No lessons found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Lessons'
	  );
	  $args = array(
		'show_in_admin_bar'   => true,
		'menu_icon'           => null,
		'show_in_nav_menus'   => false,
		'publicly_queryable'  => true,
		'exclude_from_search' => true,
		'has_archive'         => false,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'show_in_menu'        => '',
		'has_archive'         => true,
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'hierarchical'        => false,
		'labels'        => $labels,
		'description'   => 'Enter a lesson description here.',
		'supports'      => array( 'title', 'editor', 'excerpt', 'comments', 'revisions', 'author', 'custom-fields', 'page-attributes'),
	  );
	  register_post_type( 'ps_lms_lesson', $args ); 
	}
	
	//Custom Messages for Lesson
	public function psys_lesson_messages( $messages ) {
		global $post;
		$post_ID = get_the_id();
		$messages['lesson'] = array(
			0 => '', 
			1 => sprintf( __('Lesson updated. <a href="%s">View Lesson</a>'), esc_url( get_permalink($post_ID) ) ),
			2 => __('Custom field updated.'),
			3 => __('Custom field deleted.'),
			4 => __('Lesson updated.'),
			5 => isset($_GET['revision']) ? sprintf( __('Lesson restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __('Lesson published. <a href="%s">View Lesson</a>'), esc_url( get_permalink($post_ID) ) ),
			7 => __('Lesson saved.'),
			8 => sprintf( __('Lesson submitted. <a target="_blank" href="%s">Preview Lesson</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			9 => sprintf( __('Lesson scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Lesson</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( __('Lesson draft updated. <a target="_blank" href="%s">Preview Lesson</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		);
		return $messages;
	}

	// Register Custom Post Type Teacher
	function psys_register_teacher_post_type(){
	  $labels = array(
		'name'               => _x( 'Teachers', 'post type general name'),
		'singular_name'      => _x( 'Teacher', 'post type singular name'),
		'add_new'            => _x( 'Add New', 'Teacher'),
		'add_new_item'       => __( 'Add New Teacher'),
		'edit_item'          => __( 'Edit Teacher' ),
		'new_item'           => __( 'New Teacher' ),
		'all_items'          => __( 'All Teachers' ),
		'view_item'          => __( 'View Teacher' ),
		'search_items'       => __( 'Search Teachers' ),
		'not_found'          => __( 'No Teachers Found' ),
		'not_found_in_trash' => __( 'No Teachers Found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Teachers'
		);
	  $args = array(
		'show_in_admin_bar'   => true,
		'menu_icon'           => null,
		'show_in_nav_menus'   => false,
		'publicly_queryable'  => true,
		'exclude_from_search' => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'show_in_menu'        => '',
		'has_archive'         => true,
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'hierarchical'        => false,
		'labels'                => $labels,
		'description'           => 'Enter a Teacher Description Here',
		'supports'              => array('title', 'editor', 'excerpt', 'page-attributes', 'thumbnail'),
		); 
		register_post_type('ps_lms_teacher', $args);
		flush_rewrite_rules(false);
	}
	
	//Custom Messages Teacher
	function psys_teacher_messages( $messages ) {
		$permalink = get_permalink(get_the_ID());
		$messages['course'] = array(
			0 => '', 
			1 => sprintf( __('Teacher updated. <a href="%s">View Teacher</a>'), esc_url( $permalink ) ),
			2 => __('Custom field updated.'),
			3 => __('Custom field deleted.'),
			4 => __('Teacher updated.'),
			5 => isset($_GET['revision']) ? sprintf( __('Teacher restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __('Teacher published. <a href="%s">View Teacher</a>'), esc_url( $permalink ) ),
			7 => __('Teacher saved.'),
			8 => sprintf( __('Teacher submitted. <a target="_blank" href="%s">Preview Teacher</a>'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
			9 => sprintf( __('Teacher scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Teacher</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( get_the_ID() ) ), esc_url( $permalink ) ),
			10 => sprintf( __('Teacher draft updated. <a target="_blank" href="%s">Preview Teacher</a>'), esc_url( add_query_arg( 'preview', 'true', $permalink ) )),  
		);
		return $messages;
	}
	
	// Customize taxonomy
	public function psys_course_category() {
	  $labels = array(
		'name'              => _x( 'Category', 'taxonomy general name' ),
		'singular_name'     => _x( 'Category', 'taxonomy name' ),
		'search_items'      => __( 'Search Category' ),
		'all_items'         => __( 'All Categories' ),
		'parent_item'       => __( 'Parent Term Category' ),
		'parent_item_colon' => __( 'Parent Term Category:' ),
		'edit_item'         => __( 'Edit Category' ), 
		'update_item'       => __( 'Update Category' ),
		'add_new_item'      => __( 'Add New Category' ),
		'new_item_name'     => __( 'New Category' ),
		'menu_name'         => __( 'Category' ),
	  );
	  $args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'show_admin_column' => true,
		'query_var' => true
	  );
	  register_taxonomy( 'ps_lms_category', 'ps_lms_course', $args );
	}
	
	public function psys_create_admin_menu() {
		add_menu_page('PS Courses', 'PS Courses', 'manage_options', 'psys_options', array($this,'psys_options_page'),'dashicons-welcome-learn-more' );
		add_submenu_page( 'psys_options', 'Courses', 'Courses', 'manage_options', 'edit.php?post_type=ps_lms_course' );
		add_submenu_page( 'psys_options', 'Lessons', 'Lessons', 'manage_options', 'edit.php?post_type=ps_lms_lesson' );
		add_submenu_page( 'psys_options', 'Teachers', 'Teachers', 'manage_options', 'edit.php?post_type=ps_lms_teacher' );
		add_submenu_page( 'psys_options', 'Course Categories', 'Course Categories', 'manage_options', 'edit-tags.php?taxonomy=ps_lms_category&post_type=ps_lms_course' );
	}
	public function psys_options_page(){
		require_once PS_LMS_TEMPLATE_PATH . 'psys-options.php';
	}
	
	public function psys_register_settings() {
		
		add_option( 'psys_show_viewed_lessons', 'true');
		add_option( 'psys_show_completed_lessons', 'true');
		add_option( 'psys_show_lesson_nav_icons', 'true');
		add_option( 'psys_courses_per_page', 10);
		add_option( 'psys_teachers_per_page', 10);
		add_option( 'psys_logged_out_message' );
		add_option( 'psys_primary_button_color', '#23d19f');
		add_option( 'psys_primary_button_border_color', '#12ad80');
		add_option( 'psys_primary_button_text_color', '#fff');
		add_option( 'psys_primary_button_hover_color', '#12ad80');
		add_option( 'psys_primary_button_hover_border_color', '#12ad80');
		add_option( 'psys_primary_button_hover_text_color', '#fff');
		add_option( 'psys_primary_button_active_color', '#009ee5');
		add_option( 'psys_primary_button_active_border_color', '#027fb7');
		add_option( 'psys_primary_button_active_text_color', '#fff');
		register_setting( 'psys_options', 'psys_show_viewed_lessons', 'psys_callback' );
		register_setting( 'psys_options', 'psys_show_completed_lessons', 'psys_callback' );
		register_setting( 'psys_options', 'psys_show_lesson_nav_icons', 'psys_callback' );
		register_setting( 'psys_options', 'psys_courses_per_page', 'psys_callback' );
		register_setting( 'psys_options', 'psys_teachers_per_page', 'psys_callback' );
		register_setting( 'psys_options', 'psys_logged_out_message', 'psys_callback' );
		register_setting( 'psys_options', 'psys_primary_button_color', 'psys_callback' );
		register_setting( 'psys_options', 'psys_primary_button_border_color', 'psys_callback' );
		register_setting( 'psys_options', 'psys_primary_button_text_color', 'psys_callback' );
		register_setting( 'psys_options', 'psys_primary_button_hover_color', 'psys_callback' );
		register_setting( 'psys_options', 'psys_primary_button_hover_border_color', 'psys_callback' );
		register_setting( 'psys_options', 'psys_primary_button_hover_text_color', 'psys_callback' );
		register_setting( 'psys_options', 'psys_primary_button_active_color', 'psys_callback' );
		register_setting( 'psys_options', 'psys_primary_button_active_border_color', 'psys_callback' );
		register_setting( 'psys_options', 'psys_primary_button_active_text_color', 'psys_callback' );
	}	
	
	public function psys_add_meta_box() {
		$screens = array( 'ps_lms_lesson');
		foreach ( $screens as $screen ) {
			add_meta_box(
				'psys_sectionid',
				__( 'Options', 'ps-lms' ),
				array($this,'psys_meta_box_callback'),
				$screen,
				'side',
				'high'
			);
		}
	}

	/**
	 * Prints the box content.
	 * 
	 * @param WP_Post $post The object for the current post/page.
	 */
	public function psys_meta_box_callback( $post ) {
		wp_nonce_field('psys_save_lesson_meta_box_data', "psys_lesson_meta_box_nonce");
		if(get_post_type() == 'ps_lms_lesson'){
			$value = get_post_meta( $post->ID, 'lesson-video', true );
			?>
			<label>
				<button type="button" class="psys-question-btn button" data-content='If your lesson has a video, copy and paste the iframe from YouTube, Vimeo or another host here.'>?</button>
				<?php echo __('Video Embed Code', 'wp-courses'); ?> (iframe)
			</label>
			<br>
			<textarea style="width:100%;" id="psys_new_field" name="psys_new_field"><?php echo $value; ?></textarea>
			<br>

		<?php } ?>
		<br><label><button type="button" class="psys-question-btn button" data-content="If you would like your lessons to appear in a course you have created, you will need to connect them to that course.">?</button><?php echo __('Connected Course', 'wp-courses'); ?></label><br>
		<?php
		global $post;
		$post_old = $post;
		echo $this->psys_get_course_dropdown($post->ID, 'chosen-select');
		echo '<br><a style="margin: 5px 0 0; display: inline-block;" href="' . admin_url() . 'post-new.php?post_type=ps_lms_course" class="page-title-action add-new">' . __('Add New', 'wp-courses') . '</a>';
		// fixes issue with wrong slug being used
		$post = $post_old;
		setup_postdata( $post );

		do_action('psys-after-lesson-meta'); ?>
	<?php }

	public function psys_save_meta_box_data( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['psys_lesson_meta_box_nonce'] ) ) {
			return;
		}
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['psys_lesson_meta_box_nonce'], 'psys_save_lesson_meta_box_data' ) ) {
			return;
		}
		
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'ps_lms_lesson' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
		// Make sure that it is set.
		if(isset($_POST['psys-lesson-restriction'])){
			$restriction = sanitize_text_field( $_POST['psys-lesson-restriction'] );
			update_post_meta( $post_id, 'psys-lesson-restriction', $restriction );
		}
		if ( isset( $_POST['psys_new_field'] ) ) {
			$my_data = strip_tags($_POST['psys_new_field'], '<iframe>');
			update_post_meta( $post_id, 'lesson-video', $my_data );
		}
		if(isset($_POST['course-selection'])){
			$course_id = sanitize_text_field( $_POST['course-selection'] );
			update_post_meta( $post_id, 'psys-connected-lesson-to-course', $course_id);
		}
	}
	
	public function psys_get_course_dropdown($lesson_id = null, $class = ''){
			global $wpdb;
			$sql = 'SELECT DISTINCT ID, post_title, post_status 
			FROM '.$wpdb->posts.' 
			WHERE post_type = "ps_lms_course" AND post_status = "publish" OR post_type = "ps_lms_course" AND post_status = "draft" 
			ORDER By post_title';
			$results = $wpdb->get_results($sql);
			$course_id = get_post_meta($lesson_id, 'psys-connected-lesson-to-course', true);

			$data .= '<select name="course-selection" class="' . $class . '">';
			$data .= '<option value="none">None</option>';
			foreach($results as $result) {
				if($result->ID == $course_id){
					$selected = 'selected';
				} else {
					$selected = '';
				}
				if(!empty($result->ID)){
					$data .= '<option value="' . $result->ID . '" ' . $selected . '>' . $result->post_title . '</option>';
				}
			}

			$data .= '</select>';
			return $data;
	}

	public function psys_add_course_meta_box() {
		$screens = array( 'ps_lms_course' );
		add_meta_box(
			'psys_sectionid',
			__( 'Course Video', 'ps-lms' ),
			array($this,'psys_course_meta_box_callback'),
			'ps_lms_course',
			'side',
			'high'

		);
	}

	public function psys_course_meta_box_callback( $post ) {
		wp_nonce_field( 'psys_save_meta_box_data', 'psys_meta_box_nonce' );
		$value = get_post_meta( $post->ID, 'psys_video_id', true ); ?>

		<label for="psys_new_field"><?php _e( 'Video Embed Code (iframe)', 'ps-courses' ); ?></label>
		<textarea style="width:100%;" id="psys_video_id" name="psys_video_id"><?php echo $value; ?></textarea>
		<br><label><?php echo __('Course Teacher', 'wp-courses'); ?>:</label><br>
		<?php
		global $post;
		$post_old = $post;
		$lesson_id = get_the_ID();
		$args = array(
			'post_type'		=> 'ps_lms_teacher',
			'orderby'		=> 'title',
			'post_status'		=> 'publish',
		);

		$query = new WP_Query($args);

		echo '<select id="teacher-select" name="teacher-selection">';
		echo '<option value="-1">' . __('Select Teacher', 'wp-courses') . '</option>';
		while($query->have_posts()){
			$query->the_post();
			$teacher_id = get_the_ID();
			$course_id = get_post_meta($lesson_id, 'psys-connected-teacher-to-course', true);
			if( $course_id == $teacher_id){
				$selected = 'selected="selected"';
			} else{
				$selected = '';
			}
			echo '<option value="' . $teacher_id . '"' . $selected . '>' . get_the_title() . '</option>';
		}
		wp_reset_postdata();
		echo '</select>';
		$admin_url = admin_url();
		echo ' <a href="' . $admin_url . 'post-new.php?post_type=ps_lms_teacher" class="page-title-action add-new">' . __('Add New', 'ps-lms') . '</a>';

		$post = $post_old;

		setup_postdata( $post );
		$tax_name = 'ps_lms_category';
		$taxonomy = get_taxonomy($tax_name);
		?>
		<br><label><?php echo __('Course Category', 'ps-lms'); ?>:</label>

		<div class="tagsdiv" id="<?php echo $tax_name; ?>">
			<div class="jaxtag">
			<?php 
			// Use nonce for verification
			wp_nonce_field( plugin_basename( __FILE__ ), 'ps_lms_category_noncename' );
			$type_IDs = wp_get_object_terms( $post->ID, 'ps_lms_category', array('fields' => 'ids') );
			if(!empty($type_IDs[0])){
				$id = $type_IDs[0];
			} else {
				$id = '';
			}
			wp_dropdown_categories('taxonomy=ps_lms_category&hide_empty=0&orderby=name&name=ps_lms_category&show_option_none=Select Category&selected='. $id); ?>
			<?php echo ' <a href="' . $admin_url . 'edit-tags.php?taxonomy=ps_lms_category&post_type=ps_lms_course" class="page-title-action add-new">' . __('Add New', 'wp-courses') . '</a>'; ?>
			</div>
		</div>
	<?php }

	public function psys_course_save_meta_box_data( $post_id ) {
		if ( ! isset( $_POST['psys_meta_box_nonce'] ) ) {
			return;
		}
		// Verify that the nonce is valid.

		if ( ! wp_verify_nonce( $_POST['psys_meta_box_nonce'], 'psys_save_meta_box_data' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.

		if ( isset( $_POST['post_type'] ) && 'ps_lms_course' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		// Sanitize user input.

		if(isset($_POST['teacher-selection'])){
			$teacher = sanitize_text_field( $_POST['teacher-selection'] );
			update_post_meta( $post_id, 'psys-connected-teacher-to-course', $teacher);
		}

		if(isset($_POST['psys_video_id'])){
			$my_data = strip_tags($_POST['psys_video_id'], '<iframe>');
			update_post_meta( $post_id, 'psys_video_id', $my_data );
		}

		if(isset($_POST['ps_lms_category'])){
			$type_ID = sanitize_text_field($_POST['ps_lms_category']);
			$type = ( $type_ID > 0 ) ? get_term( $type_ID, 'ps_lms_category' )->slug : NULL;
			wp_set_object_terms(  $post_id , $type, 'ps_lms_category' );
		}
	}
	public function psys_remove_category_meta_box() {
		remove_meta_box( 'tagsdiv-ps_lms_category', 'ps_lms_course', 'side' );
	}
}
