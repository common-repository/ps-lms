(function( $ ) {
	'use strict';

	function psysLessonTableData(){
		var $lessonRows = jQuery('.psys-order-lesson-list-lesson');
		var posts = [];
		$lessonRows.each(function(key, value){
			var dataID = jQuery(this).attr('data-id');
			posts.push({
				'postID': dataID,
				'menuOrder': key,
			});			        	
		});
		var data = {
			'action': 'order_lessons',
			'posts': posts,
		};
		return data;
	}

	function psysShowAjaxIcon(){
		$saveIconWrapper = jQuery('#psys-ajax-save');
		$saveIcon = $saveIconWrapper.children();
		$saveIcon.removeClass();
		$saveIcon.addClass('fa fa-spin fa-spinner');
		$saveIconWrapper.fadeIn();
	}

	function psysHideAjaxIcon(){
		$saveIcon.removeClass();
		$saveIcon.addClass('fa fa-check');
		$saveIconWrapper.delay(750).fadeOut(750);
	}

	jQuery(document).ready(function($){
		// Add Color Picker to all inputs that have 'color-field' class
		$('.color-field').wpColorPicker();

		$('.psys-question-btn').click(function(){
			$('#psys-lightbox-container').show();
			$('#psys-lightbox').html($(this).attr('data-content'));
		});

		$('#psys-lightbox-close').click(function(){
			$('#psys-lightbox-container').hide();
		});

	});
})( jQuery );
