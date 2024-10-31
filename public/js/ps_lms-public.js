(function( $ ) {
	'use strict';


	function fixIframeSize(){
		var video = $('.psys-video-wrapper iframe');
		$.each(video, function(key, val){
			var w = $(this).parent().width();
			var h = w * 0.5625;
			$(this).width(w);
			$(this).height(h);	
		});
	}

	// fix iframe size
	fixIframeSize();

	$(window).resize(function(){
		fixIframeSize();
	});	

	// toolbar functionality
	$('#psys-viewed-lessons-toggle').click(function(){
		$('#psys-viewed-lessons-content').fadeToggle();
		$('#psys-attachments-content').fadeOut();
	});

	$('#psys-attachments-toggle').click(function(){
		$('#psys-attachments-content').fadeToggle();
		$('#psys-viewed-lessons-content').fadeOut();
	});

	// scroll to active lesson
	if ($('.active-lesson-button').length) {
        var pos = $('.active-lesson-button:first').position();
        var nav = $('.lesson-nav');
        nav.animate({
            scrollTop: pos.top,
        }, 1000);
    }
    
})( jQuery );
