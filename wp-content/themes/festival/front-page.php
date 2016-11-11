<?php get_header(); ?>


<!-- welcome section - umístěno v samostatném souboru -->   

<?php get_template_part('content-welcome');?>

<section id="artists">
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 bg-interpret">
            <div class="datum">

            pátek 26. května 2017

            </div> <!-- konec /datum -->   

        <div class="row">
          <div class="col-md-6">
              <a href="program">
          <img src="<?php echo esc_url(get_template_directory_uri());?>/img/cover-pavlica.jpg" data-rjs="3"  alt="Hradišťan &amp; Jiří Pavlica" class="img-rounded full-width">
          <h5>Hradišťan &amp; Jiří Pavlica</h5>
        </a>

            </div> <!-- konec /vnitřní Aneta -->   



            <div class="col-md-6">

        <a href="program">
          <img src="<?php echo esc_url(get_template_directory_uri());?>/img/cover-kittchen.jpg"  data-rjs="3" alt="Kittchen"  class="img-rounded full-width second-duo" >
          <h5>Kittchen</h5>
        </a>

            </div><!-- konec /vnitřní Kittchen -->   
      </div><!-- konec /row -->   

      <div class="row hoste">
          A s nimi jako hosté?
            <br>
            <button type="button" class="btn btn-warning button-hoste">
              <a href="hlasovani">VYBERTE SAMI V HLASOVÁNÍ!</a>
            </button>
          </div> <!-- konec /hoste -->   

      </div> <!-- konec /col-md-10 -->   
      
   
    </div> <!-- konec /container -->   
  </div><!-- konec /container -->   
  

<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1  col-sm-10 col-sm-offset-1  bg-interpret">
            <div class="datum">

            sobota 27. května 2017

            </div> <!-- konec /datum -->   

        <div class="row">
          <div class="col-md-6">
              <a href="program">
          <img src="<?php echo esc_url(get_template_directory_uri());?>/img/cover-orffove.jpg" data-rjs="3"  alt="Bratří Orffové" class="img-rounded full-width">
          <h5>Bratří Orffové</h5>
        </a>

            </div> <!-- konec /vnitřní Aneta -->   



            <div class="col-md-6">

        <a href="program">
          <img src="<?php echo esc_url(get_template_directory_uri());?>/img/cover-horacek.jpg"  data-rjs="3" alt="Michal Horáček a přátelé"  class="img-rounded full-width second-duo" >
          <h5>Michal Horáček &amp; přátelé</h5>
        </a>

            </div><!-- konec /vnitřní Kittchen -->   
      </div><!-- konec /row -->   

      <div class="row hoste">
          A s nimi jako hosté?
            <br>
            <button type="button" class="btn btn-warning button-hoste">
              <a href="hlasovani">VYBERTE SAMI V HLASOVÁNÍ!</a>
            </button>
          </div> <!-- konec /hoste -->   

      </div> <!-- konec /col-md-11 -->   
      
   </div> <!-- konec /container -->   

   <div class="row">

    <div class="center">
      <button class="btn vstupenky">

          <a href="vstupenky">Koupit vstupenky</a>
      
      </button>
    </div> <!-- konec /center -->   
  </div><!-- konec /row -->   

  
  </div><!-- konec /container -->   
</section> <!-- konec /artists - seznam kapel -->  

<section id="aktuality">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 col-sm-10 col-md-offset-1 novinky">
          
          <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
          <h2>Novinky</h2>
      

<?php 
query_posts(array('post_type' => 'post', 'posts_per_page' => 3));
if ( have_posts() ) : $i = 1; while (have_posts() && $i < 4) : the_post(); 

/* není jasné, zda ta vlastní proměnná je zde potřeba s tím posts_per page
nicméně není to vyřešený úkol -> mít na hlavní stránce odlišný počet zpráv a následně dole pod tím odkaz
na archiv, který bude mít offset o tento počet zpráv */

?>


          <h3 class="blog-post-title"><a href="<?php the_permalink();?>" title="<?php the_title(); ?>">
      <?php the_title(); ?>
          </a></h3>

<p class="datum-clanku blog-post-meta">Zveřejněno: <?php echo get_the_date('j.n.Y');?>, Kategorie: <?php the_category(', ');?> </p>

     <?php the_excerpt(); ?>         
          
<?php $i++; endwhile; else : ?>
  <p><?php _e( 'Nejsou žádné novinky' ); ?></p>
<?php endif;  ?>  
          </div> <!-- konec /col-md-10 blog-posty -->  


        <div class="hoste">
            <button type="button" class="btn btn-warning button-hoste">
            <a href="novinky">Starší zprávy</a>
           </button>

        </div> <!-- konec /stránkování -->  
      
      
      </div> <!-- konec boxu /col-md-9 -->  
    </div> <!-- konec /row -->  
  </div><!-- konec /container -->  
</section> <!-- konec /aktuality -->  

      
<?php get_template_part('content-bannery');?>

<?php get_footer(); ?>