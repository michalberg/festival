<?php get_header(); ?>


<!-- welcome section -->   

<section id="welcome">
  <div class="container">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
        <h2>Vážení příznivci kvalitní české hudby</h2>

        <p class="lead">Zvu vás téměř k sobě domů, do Roudnice nad Labem, kde s přáteli pořádáme festival Písně s příběhem. V krásném prostředí roudnického zámku se vám v květnu 2017 představí špička české populární hudby, které spojuje jedno - v jejich písních se odehrávají příběhy. Smutné, veselé, dramatické i milostné - prostě takové, jaký je sám život. Přijďte si je poslechnout.
        </p>
        <p class="lead podpis"><br>
          <b>Těším se na vás,<br>
          váš Michal Horáček</b>
        </p>

    
        </div> <!-- konec /col-sm-10 -->   
    </div><!-- konec /row -->   
</div>
</section>

<section id="artists">
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 bg-interpret">
            <div class="datum">

            sobota 27. května 2017

            </div> <!-- konec /datum -->   

        <div class="row">
          <div class="col-md-6">
              <a href="program.html">
          <img src="<?php echo esc_url(get_template_directory_uri());?>/img/img-aneta.png" data-rjs="3"  alt="Aneta Langerová" class="img-rounded full-width">
          <h5>Aneta Langerová</h5>
        </a>

            </div> <!-- konec /vnitřní Aneta -->   



            <div class="col-md-6">

        <a href="program.html">
          <img src="<?php echo esc_url(get_template_directory_uri());?>/img/img-kittchen.png"  data-rjs="3" alt="Kittchen"  class="img-rounded full-width second-duo" >
          <h5>Kittchen</h5>
        </a>

            </div><!-- konec /vnitřní Kittchen -->   
      </div><!-- konec /row -->   

      <div class="row hoste">
          A s nimi jako hosté?
            <br>
            <button type="button" class="btn btn-warning button-hoste">
              <a href="hlasovani.html">VYBERTE SAMI V HLASOVÁNÍ!</a>
            </button>
          </div> <!-- konec /hoste -->   

      </div> <!-- konec /col-md-10 -->   
      
   
    </div> <!-- konec /container -->   
  </div><!-- konec /container -->   
  

<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1  col-sm-10 col-sm-offset-1  bg-interpret">
            <div class="datum">

            neděle 28. května 2017

            </div> <!-- konec /datum -->   

        <div class="row">
          <div class="col-md-6">
              <a href="program.html">
          <img src="<?php echo esc_url(get_template_directory_uri());?>/img/img-orffove.png" data-rjs="3"  alt="Bratří Orffové" class="img-rounded full-width">
          <h5>Bratří Orffové</h5>
        </a>

            </div> <!-- konec /vnitřní Aneta -->   



            <div class="col-md-6">

        <a href="program.html">
          <img src="<?php echo esc_url(get_template_directory_uri());?>/img/img-horacek.png"  data-rjs="3" alt="Michal Horáček a přátelé"  class="img-rounded full-width second-duo" >
          <h5>Michal Horáček &amp; přátelé</h5>
        </a>

            </div><!-- konec /vnitřní Kittchen -->   
      </div><!-- konec /row -->   

      <div class="row hoste">
          A s nimi jako hosté?
            <br>
            <button type="button" class="btn btn-warning button-hoste">
              <a href="hlasovani.html">VYBERTE SAMI V HLASOVÁNÍ!</a>
            </button>
          </div> <!-- konec /hoste -->   

      </div> <!-- konec /col-md-11 -->   
      
   </div> <!-- konec /container -->   

   <div class="row">

    <div class="center">
      <button class="btn vstupenky">

          <a href="vstupenky.html">Koupit vstupenky</a>
      
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
  <p><?php _e( 'Sorry, no pages matched your criteria.' ); ?></p>
<?php endif;  ?>  
          </div> <!-- konec /col-md-10 blog-posty -->  


        <div class="hoste">
            <button type="button" class="btn btn-warning button-hoste">
            <a href="novinky/">Starší zprávy</a>
           </button>

        </div> <!-- konec /stránkování -->  
      
      
      </div> <!-- konec boxu /col-md-9 -->  
    </div> <!-- konec /row -->  
  </div><!-- konec /container -->  
</section> <!-- konec /aktuality -->  

<div class="container">
  <div class="row facilities">
      <div class="col-md-5 bg-interpret col-md-offset-1 custom-offset-left  bannery">
      <a href="roudnice.html"><img src="http://placehold.it/460x200"/></a>
      </div> <!-- konec /bannery -->  
   
      <div class="col-md-5 bg-interpret custom-offset-right bannery">
       <a href="horacek.html"><img src="http://placehold.it/460x200"/></a>
      </div>  <!-- konec /bannery -->  

   </div><!-- konec /row -->   
</div><!-- konec /container -->   


<div class="podekovani">
  Za podporu festivalu děkujeme městu Roudnice nad Labem
  <br>
  <img src="<?php echo esc_url(get_template_directory_uri());?>/img/logo-roudnice.png" alt="Znak města Roudnice"/>
</div><!-- konec /podekovani -->  


<?php get_footer(); ?>