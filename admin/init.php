<?
  /*connection to database  */
  require "connect.php";

  /* -----routes----- */

   $tpl = 'includes/templates/';
   $css = 'loyout/Css/';
   $js  = 'loyout/js/';
   $lang ='includes/languages/';
   $fun='includes/functions/';


   // includes files .

   //require $fun."functions.php";
   require  $lang . "english.php";
   require  $tpl . "header.php";
  if(isset($no_navbar)) require  $tpl. "navbar.php";
  
   

   

?>