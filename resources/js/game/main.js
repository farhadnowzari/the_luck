import Vue from 'vue';
import Main from './Main.vue';

window.axios.interceptors.request.use(config => {
    config.headers = {
        'session_id': window.theLuck.get('sessionId')
    };
    return config;
});

new Vue({
    el: '#game-app',
    render: h => h(Main)
});