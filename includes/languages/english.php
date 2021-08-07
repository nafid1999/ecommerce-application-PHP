<?
   function langue($phrase)
   {
      static $lang=array(

        'MESSAGE'   => 'welcome' ,
        'ADMIN'     => 'administrator'


    
      );
      return $lang[$phrase];
   }

?>