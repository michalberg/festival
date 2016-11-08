
<!-- FOOTER -->  
<section id="footer">

<nav class="navbar navbar-default nav-footer">

    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Otevřít navigaci</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

<a href="<?php echo esc_url(home_url()); ?>" class="navbar-brand">
        <?php echo get_bloginfo('name');?>
      </a>

      </div> <!-- konec /navbar header -->    
    
      <div class="collapse navbar-collapse">

 <?php
            wp_nav_menu( array(
                'menu'              => 'footer',
                'theme_location'    => 'footer',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'collapse navbar-collapse',
        'container_id'      => 'bs-example-navbar-collapse-1',
                'menu_class'        => 'nav navbar-nav navbar-default',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker())
            );
        ?>

    </div> <!-- konec /navbar-collapse -->   
  </div>  <!-- konec /containter fluid -->   

</nav>



  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 facebook">

      <a href="http://facebook.com/pisnespribehem">
        <img src="<?php echo esc_url(get_template_directory_uri());?>/img/ico-fb.png" alt="facebook"></a>


<?php if ( is_active_sidebar( 'footer_widget_area' ) ) : ?>
  <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
    <?php dynamic_sidebar( 'footer_widget_area' ); ?>
  </div>

<?php endif; ?>

      </div> <!-- konec /facebook -->  
    </div> <!-- konec /row -->  
  </div> <!-- konec /container -->  

</section>




<?php 
  wp_footer();
?>
  </body>
</html>