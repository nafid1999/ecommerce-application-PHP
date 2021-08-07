$(document).ready(function(){
    var palce;
   $('input').focus(function(){
     palce=$(this).attr("placeholder");
    $(this).attr("placeholder",'');
    }).
    blur(function(){
        $(this).attr("placeholder",palce);
    });

    $('input').each(function(){
        if($(this).attr('required')==='required')
        {
            $(this).after("<span class='astrisk'>*</span>")
        }
    });

    $('.show-pass').click(function(e){
       if($('.password').attr('type')=='password')
       {
           $('.password').attr('type','text');
       }else{
        $('.password').attr('type','password');
       }

    });

    $('.confirm').click(function(){
        
      return confirm('are you sure !!');

   });

   $(".nav-item").hover(function(e){
    
     $(this).toggleClass('active')
   },function(e){
    
    $(this).toggleClass('active')
  }
   
   );
 
   
   $(".cat").click(function(){
     
    $(this).find('.full-view').slideToggle('800');
   });

   $('.toggle').click(function(){
     $(this).parent().next().slideToggle('fast');
     if($(this).hasClass('fa-plus'))
     {
       $(this).removeClass('fa-plus').addClass('fa-minus');
     }else{
      $(this).removeClass('fa-minus').addClass('fa-plus');
     }

   });

 


});