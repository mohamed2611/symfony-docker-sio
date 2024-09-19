import './bootstrap.js';
// Importe le fichier javascript de bootstrap
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
// Importe les fichiers css de bootswatch et bootstrap icon
import 'bootswatch/dist/yeti/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.min.css';

import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
