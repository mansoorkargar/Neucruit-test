<template>
    <div>
        <popup-modal ref="popup" :keepOpen="true">
            <div v-if="user">
                <div class="form-group pb-5">
                    <p class="h4 mb-3">Select Study</p>
                    <select class="form-control" v-model="study">
                        <option value="">Select...</option>
                        <option v-for="study in user.studies" :key="study.id" :value="study">{{ study.name }}</option>
                    </select>
                </div>

                <div v-if="study">
                    <button class="n-btn n-bg-primary-dark txt-white" @click="setStudy">Save</button>
                </div>
            </div>
        </popup-modal>
    </div>
</template>

<script>
import PopupModal from '../components/PopupModal'

export default {
    name: 'SelectStudy',
    components: {
        PopupModal
    },
    data() {
        return {
            user: null,
            study: null,
            prevRoute: null
        }
    },
    mounted() {
        this.init();
    },
    methods: {
        async init() {
            this.user = await this.$store.dispatch('getUser');

            if (this.user.studies?.length < 1) {
                this.$store.dispatch('logOut');
                return false;
            }

            if (this.user.studies?.length > 1) {
                return this.$refs.popup.open();
            }

            this.setStudy(this.user.studies[0]);
        },
        async setStudy(study) {
            this.$store.commit('setStudy', study);
            this.$router.push( { name: 'Home' } );
        }
    }
}
</script>
