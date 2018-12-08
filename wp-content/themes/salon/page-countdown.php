<?php
/*
Template Name: Countdown
*/
get_header(); 
?>
<div id="content">
	<div id="ozycounter" class="post">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div class="post-content">       
            <h1><?php esc_attr_e('COMING SOON', 'salon'); ?></h1>
            <div id="timer">
              <div id="days">
                <div class="time"><div>000</div><span><?php esc_html_e('DAYS', 'salon') ?></span></div>                
              </div>
              <div id="hours">
                <div class="time"><div>00</div><span><?php esc_html_e('HOURS', 'salon') ?></span></div>                
              </div>
              <div id="minutes">
                <div class="time"><div>00</div><span><?php esc_html_e('MINUTES', 'salon') ?></span></div>                
              </div>
              <div id="seconds">
                <div class="time"><div>00</div><span><?php esc_html_e('SECONDS', 'salon') ?></span></div>                
              </div>
            </div>            
            <div id="social-icons">
            <?php
				$ozySalonHelper->social_icons();
			?>
            </div>
            <!--#counter-->
		</div><!--.post-content-->
		<?php endwhile; ?>
	</div><!--#ozycounter .post-->
</div><!--#content-->   

<div id="trees"></div>

<?php get_footer(); ?>