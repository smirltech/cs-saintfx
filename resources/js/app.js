require('./bootstrap');
require('@popperjs/core');
require('bootstrap');
require('../../vendor/marcincook/laravel-livewire-modals/resources/js/modals');


import Alpine from 'alpinejs'
import Swal from 'sweetalert2';
import printJS from 'print-js';

window.Alpine = Alpine;
window.Swal = Swal;
window.PrintJS = printJS;

Alpine.start();







