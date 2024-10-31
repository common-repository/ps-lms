<?php get_header(); ?>

<div class="psys-container">
	<div class="psys-row">
		<div class="psys-light-box">

    		<?php

                if(have_posts()){
                    while(have_posts()){
                        the_post();

                        echo '<div class="psys-video-wrapper">';
                            include 'template-parts/course-video.php';
                        echo '</div>';
                        include 'template-parts/course-details.php';
                        include 'template-parts/course-meta.php';

                    }
                }

    		?>

    	</div>
	</div>
</div>

<?php get_footer(); ?>