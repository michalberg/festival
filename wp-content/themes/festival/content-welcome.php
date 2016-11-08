


<section id="welcome">
  <div class="container">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">



<?php

/*
načte titulek a obsah postu s ID 44, ve kterém je text uvítání. Pozor, obsahuje HTML
*/

  $home_page_post_id = 44;
  $home_page_post = get_post( $home_page_post_id, ARRAY_A );
  $content_home = $home_page_post['post_content'];
  $content_title = $home_page_post['post_title'];
  echo '<h2>' . $content_title . '</h2>'; 
  echo $content_home;
?>


    
        </div> <!-- konec /col-sm-10 -->   
    </div><!-- konec /row -->   
</div>
</section>