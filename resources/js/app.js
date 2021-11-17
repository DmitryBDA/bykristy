
import Vue from "vue";
 import ModalActionRecord from "./components/ModalActionRecord";
// import ExampleComponent from "./components/ExampleComponent";

require('./bootstrap');

window.Vue = require('vue').default;

const app = new Vue({
    el: '#app',

    components:{
        ModalActionRecord,
    }
});
