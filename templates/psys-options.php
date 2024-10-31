<div class="wrap">
	<h1 class="psys-admin-h1">PS Courses Options</h1>
	<form method="post" action="options.php">
		<?php 

		settings_fields( 'psys_options' );

		$psys_show_viewed_lessons = get_option('psys_show_viewed_lessons');
		$psys_show_completed_lessons = get_option('psys_show_completed_lessons');
		$psys_show_lesson_nav_icons = get_option('psys_show_lesson_nav_icons');
		$psys_courses_per_page = get_option('psys_courses_per_page');
		$psys_teachers_per_page = get_option('psys_teachers_per_page');
		$psys_logged_out_message = get_option('psys_logged_out_message');
		$psys_primary_button_color = get_option('psys_primary_button_color', '#23d19f');
		$psys_primary_button_border_color = get_option('psys_primary_button_border_color', '#12ad80');
		$psys_primary_button_text_color = get_option('psys_primary_button_text_color', '#fff');
		$psys_primary_button_hover_color = get_option('psys_primary_button_hover_color', '#12ad80');
		$psys_primary_button_hover_border_color = get_option('psys_primary_button_hover_border_color', '#12ad80');
		$psys_primary_button_hover_text_color = get_option('psys_primary_button_hover_text_color', '#fff');
		$psys_primary_button_active_color = get_option('psys_primary_button_active_color', '#009ee5');
		$psys_primary_button_active_border_color = get_option('psys_primary_button_active_border_color', '#027fb7');
		$psys_primary_button_active_text_color = get_option('psys_primary_button_active_text_color', '#fff');

		if($psys_show_viewed_lessons == 'true'){
			$checked = 'checked';
		} else {
			$checked = '';
		}

		if($psys_show_completed_lessons == 'true'){
			$completed_checked = 'checked';
		} else {
			$completed_checked = '';
		}

		if($psys_show_lesson_nav_icons == 'true'){
			$icons_checked = 'checked';
		} else {
			$icons_checked = '';
		}

		?>
		<div class="psys-light-box psys-admin-extension">
			<h2 class="psys-options-header">Display Options</h2>
			<h2>Toggles</h2>
			<div class="psys-option">
				<input type="checkbox" id="psys-show-viewed-lessons" name="psys_show_viewed_lessons" value="true" <?php echo $checked; ?>/><label for="psys-show-viewed-lessons">Show viewed lessons button on lesson page</label>
			</div>
			<div class="psys-option">
				<input type="checkbox" id="psys-show-completed-lessons" name="psys_show_completed_lessons" value="true" <?php echo $completed_checked; ?>/><label for="psys-show-completed-lessons">Show completed lesson button on lesson page</label>
			</div>
			<div class="psys-option">
				<input type="checkbox" id="psys-show-lesson_nav_icons" name="psys_show_lesson_nav_icons" value="true" <?php echo $icons_checked; ?>/><label for="psys-show-lesson_nav_icons">Show lesson navigation button icons (eye, play, check, lock)</label>
			</div>
			<h2>Messages</h2>
			<div class="psys-option">
				<label>Custom restricted lesson message for logged out users on lesson page</label>
			</div>

			<?php $settings = array(
				'teeny' => true,
				'textarea_rows' => 6,
				'tabindex' => 2,
				'textarea_name'	=> 'psys_logged_out_message',
			);
			wp_editor(esc_html( __($psys_logged_out_message)), 'psys_logged_out_message', $settings); ?>

			<h2>Other Display Options</h2>

			<div class="psys-option">
				<label for="psys-courses-per-page">Courses Per Page</label><br>
				<input id="psys-courses-per-page" type="number" value="<?php echo $psys_courses_per_page; ?>" name="psys_courses_per_page"/>
			</div>

			<div class="psys-option">
				<label for="psys-teachers-per-page">Teachers Per Page</label><br>
				<input id="psys-teachers-per-page" type="number" value="<?php echo $psys_teachers_per_page; ?>" name="psys_teachers_per_page"/>
			</div>
			
			<?php do_action( 'psys_after_display_options' ); ?>

		</div>

		<div class="psys-light-box psys-admin-extension">
			<h2 class="psys-options-header">Design Options</h2>

			<h2>Primary Button Colors</h2>

			<label>Primary Button Color</label>
			<input class="color-field" name="psys_primary_button_color" value="<?php echo $psys_primary_button_color; ?>"/>

			<label>Primary Button Border Color</label>
			<input class="color-field" name="psys_primary_button_border_color" value="<?php echo $psys_primary_button_border_color; ?>"/>

			<label>Primary Button Text Color</label>
			<input class="color-field" name="psys_primary_button_text_color" value="<?php echo $psys_primary_button_text_color; ?>"/>

			<h2>Primary Button Hover Colors</h2>

			<label>Primary Button Hover Color</label>
			<input class="color-field" name="psys_primary_button_hover_color" value="<?php echo $psys_primary_button_hover_color; ?>"/>

			<label>Primary Button Hover Border Color</label>
			<input class="color-field" name="psys_primary_button_hover_border_color" value="<?php echo $psys_primary_button_hover_border_color; ?>"/>

			<label>Primary Button Hover Text Color</label>
			<input class="color-field" name="psys_primary_button_hover_text_color" value="<?php echo $psys_primary_button_hover_text_color; ?>"/>

			<h2>Primary Button Active Colors</h2>

			<label>Primary Button Active Color</label>
			<input class="color-field" name="psys_primary_button_active_color" value="<?php echo $psys_primary_button_active_color; ?>"/>

			<label>Primary Button Active Border Color</label>
			<input class="color-field" name="psys_primary_button_active_border_color" value="<?php echo $psys_primary_button_active_border_color; ?>"/>

			<label>Primary Button Active Text Color</label>
			<input class="color-field" name="psys_primary_button_active_text_color" value="<?php echo $psys_primary_button_active_text_color; ?>"/>
			<?php do_action( 'psys_after_design_options' ); ?>
		</div>
		<?php submit_button(); ?>
	</form>
</div>
