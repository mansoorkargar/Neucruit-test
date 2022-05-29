import { createApp } from 'vue';
import Embed         from './Embed.vue'
import 'vue-universal-modal/dist/index.css'
import VueUniversalModal from 'vue-universal-modal'

if (!window.__neucruitSurveyApplicationLoaded) {
    window.axios = require('axios')
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
    window.__neucruitSurveyApplicationLoaded = true
    console.log('[NeucruitSurvey] Loaded')

    document.addEventListener('DOMContentLoaded', function(event) {
        let div = document.createElement('div');
        div.setAttribute('id', 'neucruit-survey-applicaton');
        document.body.appendChild(div);

        let modals = document.createElement('div');
        modals.setAttribute('id', 'modals');
        document.body.appendChild(modals);
        
        const app = createApp(Embed);
        app.use(VueUniversalModal, {
            teleportTarget: '#modals'
        })
        app.mount('#neucruit-survey-applicaton');
    });
}