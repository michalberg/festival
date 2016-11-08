var $vybrano = 0;

jQuery(document).ready(function(){
		jQuery(".odeslat").css("display","none");

  jQuery("input").click(function(){
      jQuery(this).parents(".list-group-item").toggleClass("selected");
    
      var $elements = jQuery('.selected');
      
      jQuery("#pocet").text($elements.length);

       $vybrano = $elements.length;
      
      if ($vybrano > 4) {
         	jQuery("#vystraha").text("Vyberte maximáně 4 kapely");
      		jQuery(".odeslat").css("display","none");
            jQuery("#vystraha").addClass("alert alert-warning");
          } else if ($vybrano < 5 && $vybrano>0) {
          jQuery("#vystraha").removeClass("alert alert-warning");
          jQuery(".odeslat").css("display","inline-block");
          jQuery("#vystraha").text("");
         } else {
         	jQuery(".odeslat").css("display","none");
       };

  });
});

jQuery('#votingform').validate();

