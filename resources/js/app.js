import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
import $ from 'jquery';

$(document).ready(function () {
    console.log("jQuery is ready!");
    $('body').css('background-color', '#f0f8ff');
});
