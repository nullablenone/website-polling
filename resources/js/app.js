import './bootstrap';

// Import Vendors from node_modules
import AOS from 'aos';
import GLightbox from 'glightbox';
import Swiper from 'swiper/bundle'; // Swiper bundle includes all modules
import PureCounter from '@srexi/purecounterjs';
import imagesLoaded from 'imagesloaded';
import Isotope from 'isotope-layout';
import 'bootstrap'; // Import Bootstrap Javascript
import '../vendor/php-email-form/validate.js'; // Keep local validation script

// Bind to window so main.js can access them globally
window.AOS = AOS;
window.GLightbox = GLightbox;
window.Swiper = Swiper;
window.PureCounter = PureCounter;
window.imagesLoaded = imagesLoaded;
window.Isotope = Isotope;

// Import main template JS
import './main.js';
