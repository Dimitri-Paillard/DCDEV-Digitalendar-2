
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');
require("popper.js");
require("bootstrap");
require("select2");
require("tinymce");
const ClassicEditor = require( '@ckeditor/ckeditor5-build-classic' );

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');


$(document).ready(function () {

    ClassicEditor.create( document.querySelector( 'textarea' ) );

    $('select').select2();

    $('[data-toggle="tooltip"]').tooltip();

});
