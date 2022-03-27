const $ = require('jquery');

$(document).ready(function (){

   //get the hamburger menu item
    $("#hamburger-menu").click(function (){
        $("#mobile-menu").slideToggle();
   })

});
