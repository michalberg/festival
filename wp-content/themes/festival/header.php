<!DOCTYPE html>
<html <?php language_attributes(); ?> >
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- xThe above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php wp_title('')?></title>


    <!-- custom fonts -->
    
  <script src="https://use.typekit.net/olb4tvq.js"></script>
  <script>try{Typekit.load({ async: true });}catch(e){}</script>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>

<!-- HEADER -->

<header>

<nav class="navbar navbar-default">

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
                'menu'              => 'primary',
                'theme_location'    => 'primary',
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

<!-- feature section -->   



  <div class="container-fluid">
      <div class="row feature">
        <img src="<?php header_image();?>" data-rjs="3" alt="Písně s příběhem" class="pozadi"/>
          <div class="feature-text col-xs-12 col-md-10 col-lg-8 col-md-offset-1 col-lg-offset-2">
            <div class="pozadi">
              <img src="<?php echo esc_url(get_template_directory_uri());?>/img/logo.png" data-rjs="3" alt="Logo" class="logo">
              <h2><?php vlastni_text();?></h2>
              <h4>Hudební festival Michala Horáčka a jeho přátel</h4>
              <h4>27. - 28. května 2017, Roudnice nad Labem</h4>
            </div> <!-- konec /pozadi -->   
          </div> <!-- konec /feature text -->   
      <img src="<?php echo esc_url(get_template_directory_uri());?>/img/foto-horacek_2.png" data-rjs="3" class="foto-horacek" alt="Michal Horáček">
      </div> <!-- konec /row -->   
  </div> <!-- konec /containter fluid -->   

</header>