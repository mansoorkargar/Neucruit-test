<template>
    <div class="dashboard_container">
        <div class="header">
            <div class="social-parent">
                <div class="social-section">
                    <h1 class="social-title">Your Trial Landing Page</h1>
                    <h2>Edit according to your preference on the Designer Tool</h2>
                </div>
                <a class="social-btn" :href="'/landing-page/' + this.study.id" target="_blank">Go to Landing Page</a>
            </div>
        </div>
        <div class="gjs-wrapper">
            <div id="gjs"></div>
        </div>
    </div>
</template>

<script>
import SecondaryNavbar from './partials/SecondaryNavbar';
import grapesjs from 'grapesjs'
import gjspresetwebpag from 'grapesjs-preset-webpage'
import grapesjscustomcode from 'grapesjs-custom-code'
import grapesjstubs from 'grapesjs-tabs'
import grapesjsindexeddb from 'grapesjs-indexeddb'
import VueCookies from 'vue-cookies';
import { mapGetters } from "vuex";

export default {
    name: 'Design',
    components: {
        SecondaryNavbar
    },

    data: () => ({
       file: null
    }),

    computed: {
      ...mapGetters(['authToken', 'study', 'user'])
    },

    mounted () {
        const editor = grapesjs.init({
            container : '#gjs',
            style: '.txt-red{color: red}',
            plugins: [
                gjspresetwebpag,
                grapesjscustomcode,
                grapesjstubs,
                grapesjsindexeddb
            ],
            pluginsOpts: {
                'grapesjs-indexeddb': {
                    // options
                }
            },
            storageManager: {
                autosave: false,
                setStepsBeforeSave: 1,
                type: 'remote',
                urlStore: '/api/make-design',
                urlLoad: `/api/make-design/${this.study.id}`,
                contentTypeJson: true,
                params: {'study_id': this.study.id},
                headers: {
                    'X-Header-Study-Id': this.study.id ?? '',
                    'Authorization':     `Bearer ${this.authToken}`,
                    'X-XSRF-TOKEN':      VueCookies.get('XSRF-TOKEN')
                },
            },
        });

        editor.Panels.addButton
        ('options',
            [{
                id: 'save-db',
                className: 'fa fa-floppy-o',
                command: 'save-db',
                attributes: {title: 'Save DB'}
            }]
        );

        editor.Commands.add
        ('save-db', {
            run: function(editor, sender)
            {
                console.log(editor, 'editor')
                sender && sender.set('active');
                editor.store();
            }
        });
        editor.on('storage:load', function(e) { console.log('Loaded ', e);});
        editor.on('storage:store', function(e) { console.log('Stored ', e);});
    }
}
</script>


<style lang="scss" scoped>
.header {
    padding: 32px 20px;
    background: #FFFFFF;
    box-shadow: 0px 0px 5.73057px rgba(0, 0, 0, 0.08);
    border-radius: 5px;
    height:auto;
    margin:25px;

    .first-text {
        font-weight: 400;
        font-size: 22px;
        line-height: 27px;
        letter-spacing: 0.01em;
        color: #343F44;
    }

    .second-text {
        font-weight: 400;
        font-size: 16px;
        line-height: 20px;
        letter-spacing: 0.01em;
        color: #343F44;
    }
}

.social-parent {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.social-title {
    font-style: normal;
    font-weight: 400;
    font-size: 22px;
    line-height: 27px;
    letter-spacing: 0.01em;
    color: #343F44;
    margin-bottom: 28px;
}

.progress-status {
    margin-bottom:3px ;
}

.social-btn {
    background: #6D79B8;
    border-radius: 12px;
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    padding: 18px 45px;
    color: #FFFFFF;
    margin-bottom: 45px;
    margin-right: 32px;
}

.gjs-wrapper {
    margin:0 25px 25px 25px;
    box-shadow: 0px 0px 5.73057px rgba(0, 0, 0, 0.08);
    border-radius: 5px;
    overflow:hidden;
}
</style>