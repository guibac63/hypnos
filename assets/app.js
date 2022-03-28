/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

//enable AOS animation library
import AOS from 'aos';

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import 'aos/dist/aos.css';

//import toggle menu navbar
import './toggle.js';

// start the Stimulus application
import './bootstrap';

import './carousel.js';

AOS.init = function (param) {
    
}
AOS.init({
    once:true
});

//allow utilisation of fontawesome
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');



