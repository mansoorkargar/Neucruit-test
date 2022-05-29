<template>
    <div class="landing-page">
        <div id="gjs"></div>

        <transition name="fade">
            <div class="popup-modal" v-if="isVisible">
                <div class="window">
                    <div class="base_modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="participiantModalLabel">Add participiant</h5>
                                    <button @click="close" type="button" class="btn-close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-success" v-if="!participantMessage">Participan created</div>
                                    <form @submit.prevent="createParticipant">
                                        <div class="form-group mb-3">
                                            <label for="email">Email</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    type="email"
                                                    id="email"
                                                    v-model="form.email"
                                                    class="form-control"
                                                    placeholder="Email"
                                                    aria-label="Email"
                                                    aria-describedby="basic-addon1">

                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="postcode">Post code</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="postcode"
                                                    type="number"
                                                    v-model="form.postcode"
                                                    class="form-control"
                                                    placeholder="postcode"
                                                    aria-label="postcode"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="gender">Select Gender</label>
                                            <div class="input-group">
                                                <select id="gender" class="form-control" v-model="form.sex" required>
                                                    <option value="" disabled hidden>Select Gender</option>
                                                    <option v-for="gender in genders" :key="gender.id" :value="gender.id">{{ gender.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="age">Age</label>
                                            <div class="input-group mb-3">
                                                <input
                                                    required
                                                    id="age"
                                                    type="number"
                                                    v-model="form.age"
                                                    class="form-control"
                                                    placeholder="Age"
                                                    aria-label="Age"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="ethnicity">Ethnicity</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="ethnicity"
                                                    type="text"
                                                    v-model="form.ethnicity"
                                                    class="form-control"
                                                    placeholder="Ethnicity"
                                                    aria-label="Ethnicity"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="phone_number">Phone number</label>
                                            <div class="input-group mb-3">
                                                <input
                                                    required
                                                    id="phone_number"
                                                    type="number"
                                                    v-model="form.phone_number"
                                                    class="form-control"
                                                    placeholder="Phone number"
                                                    aria-label="Phone number"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="status">Status</label>
                                            <div class="input-group">
                                                <select id="status" class="form-control" v-model="form.status" required>
                                                    <option value="" disabled hidden>Select Status</option>
                                                    <option v-for="status in statuses" :key="status.id" :value="status.id">{{ status.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="site">Site</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="site"
                                                    type="text"
                                                    v-model="form.site"
                                                    class="form-control"
                                                    placeholder="Site"
                                                    aria-label="Site"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="site_distance">Site distance</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="site_distance"
                                                    type="text"
                                                    v-model="form.site_distance"
                                                    class="form-control"
                                                    placeholder="Site distance"
                                                    aria-label="Site distance"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="opt_in">Opt in</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="opt_in"
                                                    type="text"
                                                    v-model="form.opt_in"
                                                    class="form-control"
                                                    placeholder="Opt in"
                                                    aria-label="Opt in"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="contact_date">Contact date</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="contact_date"
                                                    type="date"
                                                    v-model="form.contact_date"
                                                    class="form-control"
                                                    placeholder="Contact date"
                                                    aria-label="Contact date"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="confirmation_date">Confirmation date</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="confirmation_date"
                                                    type="date"
                                                    v-model="form.confirmation_date"
                                                    class="form-control"
                                                    placeholder="Confirmation date"
                                                    aria-label="Confirmation date"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="symptoms_date">Symptoms date</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="symptoms_date"
                                                    type="date"
                                                    v-model="form.symptoms_date"
                                                    class="form-control"
                                                    placeholder="Symptoms date"
                                                    aria-label="Symptoms date"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="suspect_date">Suspect date</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="suspect_date"
                                                    type="date"
                                                    v-model="form.suspect_date"
                                                    class="form-control"
                                                    placeholder="Suspect date"
                                                    aria-label="Suspect date"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="name">Name</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="name"
                                                    type="text"
                                                    v-model="form.name"
                                                    class="form-control"
                                                    placeholder="name"
                                                    aria-label="name"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="form_sent">Form sent</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="form_sent"
                                                    type="text"
                                                    v-model="form.form_sent"
                                                    class="form-control"
                                                    placeholder="Form sent"
                                                    aria-label="Form sent"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="screening_data">Screening data</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="screening_data"
                                                    type="date"
                                                    v-model="form.screening_data"
                                                    class="form-control"
                                                    placeholder="Screening date"
                                                    aria-label="Screening date"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="country">Country</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="country"
                                                    type="text"
                                                    v-model="form.country"
                                                    class="form-control"
                                                    placeholder="Country"
                                                    aria-label="Country"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="city">City</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="city"
                                                    type="text"
                                                    v-model="form.city"
                                                    class="form-control"
                                                    placeholder="City"
                                                    aria-label="City"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address_line_1">Address line 1</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="address_line_1"
                                                    type="text"
                                                    v-model="form.address_line_1"
                                                    class="form-control"
                                                    placeholder="Address line 1"
                                                    aria-label="Address line 1"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address_line_2">Address line 2</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="address_line_2"
                                                    type="text"
                                                    v-model="form.address_line_2"
                                                    class="form-control"
                                                    placeholder="Address line 2"
                                                    aria-label="Address line 2"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="birthdate">Birthdate</label>
                                            <div class="input-group">
                                                <input
                                                    required
                                                    id="birthdate"
                                                    type="date"
                                                    v-model="form.birthdate"
                                                    class="form-control"
                                                    placeholder="Birthdate"
                                                    aria-label="Birthdate"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button @click="close" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import grapesjs from 'grapesjs'
import VueCookies from 'vue-cookies';
import { mapActions, mapGetters } from "vuex";
import grapesjscustomcode from "grapesjs-custom-code";

export default {
    name: 'Landing page',

    computed: {
        ...mapGetters(['authToken', 'study', 'genders', 'statuses', 'participantMessage'])
    },

    data: () => ({
        loadedData: {},
        isVisible: false,
        form: {
            email: '',
            postcode: '',
            sex: '',
            age: '',
            ethnicity: '',
            phone_number: '',
            status: '',
            site: '',
            site_distance: '',
            opt_in: '',
            contact_date: '',
            confirmation_date: '',
            symptoms_date: '',
            suspect_date: '',
            name: '',
            form_sent: '',
            screening_data: '',
            country: '',
            city: '',
            address_line_1: '',
            address_line_2: '',
            birthdate: '',
        }
    }),

    async mounted () {
        const editor = grapesjs.init({
            container : '#gjs',
            style: '.txt-red{color: red}',

            plugins: [grapesjscustomcode],
            pluginsOpts: {
                'grapesjs-custom-code': {
                    // options
                }
            },
            storageManager: {
                autosave: false,
                setStepsBeforeSave: 1,
                type: 'remote',
                urlLoad: `/api/get-design/${this.$route.params.id}`,
                contentTypeJson: true,
                storeStyles: true,
                storeHtml: true,
                storeCss: true,
                json_encode:{
                    "gjs-html": [],
                    "gjs-css": [],
                },
                headers: {
                    'X-Header-Study-Id': this.study.id ?? '',
                    'Authorization': `Bearer ${this.authToken}`,
                    'X-XSRF-TOKEN': VueCookies.get('XSRF-TOKEN')
                },
            },
        });

        editor.on('storage:load', function(e) { console.log('Loaded ', e);});
        editor.on('load', () => editor.runCommand('preview'))
        await this.getStatuses()
        await this.getGenders()

        const iframe = document.querySelector('iframe');
        const checkBtn = iframe.contentWindow.document.querySelector('.check-btn');

        checkBtn.onclick = () => {
            this.open()
            console.log(this.isVisible, 'isVisible')
        }
    },

    methods: {
        ...mapActions(['getStatuses', 'getGenders', 'createParticipantRequest']),

        async createParticipant() {
            const study_id = JSON.parse(localStorage.getItem('vuex')).auth.study.id ?? ''
            const data = {
                ...this.form,
                study_id
            }

            await this.createParticipantRequest(data)
        },

        open() {
            this.isVisible = true;
        },

        close() {
            this.isVisible = false;
        }
    }
}
</script>

<style lang="scss" scoped>
.landing-page {
    .form-control {
        height: 40px;
    }
}

/* css class for the transition */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter,
.fade-leave-to {
    opacity: 0;
}

.popup-modal {
    background-color: rgba(0, 0, 0, 0.5);
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 0.5rem;
    display: flex;
    align-items: center;
    z-index: 9999;
    height: 100vh;
}

.window {
    background: #fff;
    border-radius: 5px;
    box-shadow: 2px 4px 8px rgb(0, 0, 0, 0.2);
    width: 480px;
    height: 500px;
    max-width: 100%;
    margin-left: auto;
    margin-right: auto;
    overflow-y: auto;
}

.base_modal,
.base_modal__header,
.base_modal__body {
    position: relative;
    padding: 1em;
}

.close-modal {
    position: absolute;
    padding: 10px;
    right: 0;
    top: -10px;
    font-size: 22px;
    opacity: .5;
    cursor: pointer;
}

.close-modal:hover {
    opacity: 1;
}
</style>
