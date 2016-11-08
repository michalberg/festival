<?php get_header(); ?>


<section id="aktuality">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 col-sm-10 col-md-offset-1 novinky">
        
    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12 blog-posty">
          
          <h2>Novinky</h2>
      

      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <!-- pro blog-ID stylování -->  

          <h3 class="blog-post-title"><a href="<?php the_permalink();?>" title="<?php the_title(); ?>">
      <?php the_title(); ?>
          </a></h3>

<p class="datum-clanku blog-post-meta">Zveřejněno: <?php echo get_the_date('j.n.Y');?>, Kategorie: <?php the_category(', ');?> </p>

     <?php the_post_thumbnail('medium'); ?>         
     <?php the_excerpt(); ?>         
    
          </div>          

<?php endwhile; else : ?>
  <p><?php _e( 'Sorry, no pages matched your criteria.' ); ?></p>
<?php endif; ?>  
          </div> <!-- konec /col-md-10 blog-posty -->  


        <div class="hoste">
           
<?php if (get_next_posts_link()) { ?>
           <button type="button" class="btn btn-warning button-hoste">
            <?php next_posts_link('Starší novinky')?>
           </button>

<?php 
      }

if (get_previous_posts_link()) { ?>
           <button type="button" class="btn btn-warning button-hoste">
            <?php previous_posts_link('Novější novinky')?>
           </button>

<?php 
      }
      ?>

        </div> <!-- konec /stránkování -->  
      
      </div> <!-- konec boxu /col-md-10 novinky -->  
    </div> <!-- konec /row -->  
  </div><!-- konec /container -->  
</section> <!-- konec /aktuality -->  






<?php get_footer(); ?>