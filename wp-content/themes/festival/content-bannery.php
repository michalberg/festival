<div class="container">
  <div class="row facilities">

<?php if ( is_active_sidebar( 'bannery_dole_vlevo' ) ) : ?>
  
    <?php dynamic_sidebar( 'bannery_dole_vlevo' ); ?>

<?php endif; ?>
     

<?php if ( is_active_sidebar( 'bannery_dole_vpravo' ) ) : ?>
  
    <?php dynamic_sidebar( 'bannery_dole_vpravo' ); ?>

<?php endif; ?>


   </div><!-- konec /row -->   
</div><!-- konec /container -->   


<div class="podekovani">
  Za podporu festivalu děkujeme městu Roudnice nad Labem
  <br>
  <img src="<?php echo esc_url(get_template_directory_uri());?>/img/logo-roudnice.png" alt="Znak města Roudnice"/>
</div><!-- konec /podekovani -->  
