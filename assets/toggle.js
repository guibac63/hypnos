const $ = require('jquery');

$(document).ready(function (){

   //get the hamburger menu item and slide it on click
    $("#hamburger-menu").click(function (){
        $("#mobile-menu").slideToggle();
   })

});
