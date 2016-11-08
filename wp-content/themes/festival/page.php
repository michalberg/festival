<?php get_header(); ?>


<section id="aktuality">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 col-sm-10 col-md-offset-1 novinky">
        
		<div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12 blog-posty">
          
          <h2>Novinky</h2>
			

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

          <h3 class="blog-post-title"><a href="<?php the_permalink()?>" tile="<?php the_title() ?>>
			<?php the_title(); ?>
          </a></h3>

 		 <?php the_content(); ?>         
          
          <p class="datum-clanku blog-post-meta">Zveřejněno: 14.7.2017</p>

     
 


<?php endwhile; else : ?>
  <p><?php _e( 'Sorry, no pages matched your criteria.' ); ?></p>
<?php endif; ?>  
    

        <	/div> <!-- konec /col-md-10 blog-posty -->  

        <div class="hoste">
           <button type="button" class="btn btn-warning button-hoste"><a href="hlasovani.html">Starší zprávy</a></button>
        </div> <!-- konec /hoste / starsi zpravy -->  
      
      </div> <!-- konec boxu /col-md-10 novinky -->  
    </div> <!-- konec /row -->  
  </div><!-- konec /container -->  
</section> <!-- konec /aktuality -->  






<?php get_footer(); ?>