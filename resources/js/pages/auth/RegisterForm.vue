<template>
    <div class="register-form-wrapper main">
        <div class="d-flex">
            <div class="left">
                <auth-header></auth-header>
            </div>

            <div class="right p-4">
                <div v-if="showError">
                    <div v-for="error in errors" class="alert alert-danger" role="alert">
                        <div v-for="err in error">{{ err.toString() }}</div>
                    </div>
                </div>
                <form @submit.prevent="save" class="form_wrapper">
                    <div class="form_wrapper_body p-5 n-bg-white">
                        <h2 class="mb-5 txt-center">Need help with a study?</h2>

                        <div class="form-group mb-3 d-flex">
                            <input
                                required
                                class="form-control"
                                type="text" name="name"
                                placeholder="First Name"
                                id="name" v-model="form.name">

                            <input
                                required
                                class="form-control"
                                type="text" name="last_name"
                                placeholder="Last Name"
                                id="lastName" v-model="form.last_name">
                        </div>

                        <div class="form-group mb-3">
                            <vue-tel-input @change="handleChange" v-model="form.phone_number" mode="international"></vue-tel-input>
                        </div>

                        <div class="form-group mb-3">
                            <input
                                required
                                class="form-control"
                                type="text" name="company"
                                placeholder="Company"
                                id="company" v-model="form.company">
                        </div>

                        <div class="form-group mb-3">
                            <input
                                required
                                class="form-control"
                                type="email" name="email"
                                placeholder="Email"
                                id="email" v-model="form.email">
                        </div>

                        <div class="form-group mb-3">
                            <input
                                required
                                class="form-control"
                                type="password" name="password"
                                placeholder="Password"
                                id="password" v-model="form.password">
                        </div>

                        <div class="form-group mb-3">
                            <input
                                required
                                class="form-control"
                                type="password" name="confirmPassword"
                                placeholder="Confirm Password"
                                id="confirmPassword" v-model="form.password_confirmation">
                        </div>

                        <div class="form-group mb-3 d-flex">
                            <input type="checkbox" id="remember_me" class="form-check-input" v-model="form.info_checked" :value="false">
                            <label for="remember_me" class="font-sm">I would like to receive additional information from Neucruit</label>
                        </div>

                        <div class="form-group mb-1">
                            <button type="submit" class="n1-btn d-block n-bg-primary txt-white">Register</button>

                            <router-link class="back-btn" to="/login">Back</router-link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import AuthHeader from "./Header";
import { mapActions, mapGetters } from "vuex";

export default {
    name: 'Register',

    data: () => ({
       form: {
           name: '',
           last_name: '',
           company: '',
           email: '',
           password: '',
           password_confirmation: '',
           phone_number: '',
           info_checked: null,
           token: null
       },

        errors: [],
        showError: false
    }),

    components: {
        AuthHeader
    },
    async mounted () {
        if ( this.$route.query.token ) {
            this.form.token = this.$route.query.token
        }

        if ( this.$route.query.email ) {
            this.form.email = this.$route.query.email
        }
    },

    methods: {
        ...mapActions(["register"]),

        handleChange(e) {
            this.form.phone_number = +e.target.value
        },

        async save() {
            this.errors = [];

            await this.register(this.form)
            .then(res => {
                this.$router.push('/registration');
            })
            .catch(err => {
                this.showError = true
                this.errors = err.response.data.errors

                setTimeout(() => {
                    this.showError = false
                }, 10000)
            })
        }
    }
}
</script>

<style lang="scss" scoped>
.register-form-wrapper {
    #lastName {
        margin-left: 8px;
    }

    .back-btn {
        color: #6D79B8;
        margin: 20px auto 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
}
</style>

<style lang="scss">
.register-form-wrapper {
    .form-control {
        background: #f6f7fa;
    }

    .vue-tel-input {
        background: #f6f7fa;
        height: 58px;
        border-radius: 12px;
        border: 1px solid #E0E0E0;
        box-sizing: border-box;

        input {
            border-radius: 0 12px 12px 0;
        }
    }

    .vti__dropdown {
        border-radius: 12px 0 0 12px;
    }
}
</style>
