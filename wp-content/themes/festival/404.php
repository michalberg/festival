<?php 

/*

Template name: 404 page

*/

get_header(); ?>


<section id="aktuality">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 col-sm-10 col-md-offset-1 novinky">
        
		<div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12 blog-posty">
          
          
			<h1><?php _e("Stránka nebyla nalezena",'FestivalPSP')?> </h1>


			<?php the_widget('WP_Widget_Search')?>
    

    <p><a href="<?php echo esc_url(home_url()); ?>">Zpět na hlavní stránku</a></p>

        </div> <!-- konec /col-md-10 blog-posty -->  

      
      </div> <!-- konec boxu /col-md-10 novinky -->  
    </div> <!-- konec /row -->  
  </div><!-- konec /container -->  
</section> <!-- konec /aktuality -->  






<?php get_footer(); ?>