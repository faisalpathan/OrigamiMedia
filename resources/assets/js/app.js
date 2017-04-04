
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

var  VueResource = require('vue-resource');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('video-upload', require('./components/VideoUpload.vue'));

Vue.component('video-player', require('./components/VideoPlayer.vue'));

Vue.component('video-voting', require('./components/VideoVoting.vue'));

Vue.component('video-comments', require('./components/VideoComments.vue'));

Vue.component('subscribe-button', require('./components/SubscribeButton.vue'));


Vue.use(VueResource);

const app = new Vue({
    el: '#app',
    data:window.origamimedia
});
