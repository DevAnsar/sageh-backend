require('./bootstrap');
// import { io } from "socket.io-client";
window.Vue = require('vue');
Vue.component('one-to-many', require('./components/admin/OneToMany.vue').default);

// const socket = io('localhost:5000');
const admin_app = new Vue({
    el: '#app',
    created(){
        console.log('ansaramman');
        // socket.on("connect", () => {
        //     console.log(socket.id); // x8WIv7-mJelg7on_ALbx
        // });
    }
});