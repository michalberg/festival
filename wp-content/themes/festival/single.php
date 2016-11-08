<?php 

/*

Single post template

*/

get_header(); ?>


<section id="page">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 col-sm-10 col-md-offset-1 novinky">
        
    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12 blog-posty">
          

      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

          <h1>
      <?php the_title(); ?>
         </h1>

<p class="datum-clanku blog-post-meta">Zveřejněno: <?php echo get_the_date('j.n.Y');?>, Kategorie: <?php the_category(', ');?> </p>

     <?php the_content(); ?>         
          

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
