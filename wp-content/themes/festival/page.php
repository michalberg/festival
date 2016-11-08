<?php get_header(); ?>


<section id="page">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 col-sm-10 col-md-offset-1 novinky">
        
		<div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12 blog-posty">
          
          

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

          <h3 class="blog-post-title"><a href="<?php the_permalink()?>" tile="<?php the_title() ?>">
			<?php the_title(); ?>
          </a></h3>

 		 <?php the_content(); ?>         
          

<?php
          if ( is_page( array( 'vstupenky', 'prakticke-informace') )) { 

          
      ?>
          <p class="datum-clanku blog-post-meta">Poslední aktualizace: <?php echo get_the_date('j.n.Y');?> </p>

     <?php } ?> 


<?php endwhile; else : ?>
  <p><?php _e( 'Sorry, no pages matched your criteria.' ); ?></p>
<?php endif; ?>  
    

        </div> <!-- konec /col-md-10 blog-posty -->  

      
      </div> <!-- konec boxu /col-md-10 novinky -->  
    </div> <!-- konec /row -->  
  </div><!-- konec /container -->  
</section> <!-- konec /aktuality -->  






<?php get_footer(); ?>