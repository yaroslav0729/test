window.$ = window.jQuery = require('jquery');
window.Vue = require('vue');
require('../../assets/vendor/MediaManager/js/manager')

$(function (){
    new Vue({
        el: '#app'
    });
});
