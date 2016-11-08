<?php 

/*

Template name: Hlasování

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


     <?php the_content(); ?>         
          


<form id="votingform">
<div class="panel panel-default">

<div class="panel-heading">
  <b>Vyberte </b>
</div>
<div class="panel-body">
  
<div class="col-md-6">
<ul class="list-group">
  <li class="list-group-item"><label><input type="checkbox" value=""> Jan Žamboch</label>
    <p>elektro-folk | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">bandzone</a></li>
  <li class="list-group-item"><label><input type="checkbox" value=""> PONK</label>
    <p>neo-folklór | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">web</a></li>
  <li class="list-group-item"><label><input type="checkbox" value=""> Půljablkoň</label><p>neo-folklór | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">web</a></li>
  <li class="list-group-item"><label><input type="checkbox" value=""> Martina TRchová</label><p>neo-folklór | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">web</a></li>
  <li class="list-group-item"><label><input type="checkbox" value=""> Ladě</label><p>neo-folklór | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">web</a></li>
  <li class="list-group-item"><label><input type="checkbox" value=""> Expedice Apalucha</label><p>neo-folklór | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">web</a></li>
  <li class="list-group-item"><label><input type="checkbox" value=""> The Honzíci</label><p>neo-folklór | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">web</a></li>
  <li class="list-group-item"><label><input type="checkbox" value=""> Wabi Daněk</label><p>neo-folklór | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">web</a></li>
  
</ul>
</div>
<div class="col-md-6">
<ul class="list-group">
    <li class="list-group-item"><label id="zambosi" ><input type="checkbox" value=""> Jan Žamboch</label>
    <p>elektro-folk | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">bandzone</a></li>
  <li class="list-group-item"><label><input type="checkbox" value=""> PONK</label>
    <p>neo-folklór | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">web</a></li>
  <li class="list-group-item"><label><input type="checkbox" value=""> Půljablkoň</label><p>neo-folklór | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">web</a></li>
  <li class="list-group-item"><label><input type="checkbox" value=""> Martina TRchová</label><p>neo-folklór | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">web</a></li>
  <li class="list-group-item"><label><input type="checkbox" value=""> Ladě</label><p>neo-folklór | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">web</a></li>
  <li class="list-group-item"><label><input type="checkbox" value=""> Expedice Apalucha</label><p>neo-folklór | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">web</a></li>
  <li class="list-group-item"><label><input type="checkbox" value=""> The Honzíci</label><p>neo-folklór | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">web</a></li>
  <li class="list-group-item"><label><input type="checkbox" value=""> Wabi Daněk</label><p>neo-folklór | <a href="https://www.youtube.com/watch?v=JLbXvzGsDYo">youtube</a> | <a href="http://bandzone.cz/zambosi">web</a></li>
</ul>
</div>

<div class="col-md-5 col-md-offset-3 text-center">
<div class="form-group">
  <label for="usr">Vaše jméno:</label>
  <input type="text" class="form-control" id="usr">
</div>
<div class="form-group">
  <label for="pwd">Váš email:</label>
  <input type="email" class="form-control" id="email">
</div>

<div>Vybráno kapel: <span id="pocet">0</span></div>

<div id="vystraha" class=""></div>

          <input type="submit" value="Odeslat" class="btn btn-warning button-hoste odeslat" />
</div>

</div>
</div><!-- konec panelu -->  

</form>






<?php endwhile; else : ?>
  <p><?php _e( 'Stránka není k dispozici' ); ?></p>
<?php endif; ?>  




        </div> <!-- konec /col-md-10 blog-posty -->  

      
      </div> <!-- konec boxu /col-md-10 novinky -->  
    </div> <!-- konec /row -->  
  </div><!-- konec /container -->  
</section> <!-- konec /aktuality -->  



<?php get_footer(); ?>