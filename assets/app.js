/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */




// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';


//import toggle menu navbar
import './toggle.js';

// start the Stimulus application
import './bootstrap';

//js for carousel slide
import './carousel.js';



//enable AOS animation library
import AOS from 'aos';
import 'aos/dist/aos.css';

AOS.init({
    once:true
});

//reservation js part
//full calendar library
// import './calendar.js';
//to load suite options for the selected establishment
import './suite.js';
//to allow reservation
import './reservation.js';
//to cancel reservation
import './annulReservation.js';


//allow utilisation of fontawesome
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');




