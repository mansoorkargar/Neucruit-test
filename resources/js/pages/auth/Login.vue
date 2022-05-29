<template>
    <div class="main">
        <div class="d-flex">
            <div class="left">
                <auth-header></auth-header>
            </div>

            <div class="right p-4">
                <div v-if="this.errors.api" class="alert alert-danger" role="alert">
                    {{ this.errors.api }}
                </div>
                <div class="form_wrapper">
                    <div class="form_wrapper_body p-5 n-bg-white">
                        <h2 class="mb-5 txt-center">Log in</h2>

                        <div v-if="this.errors.unauthorized" class="alert alert-danger" role="alert">
                            {{ this.errors.unauthorized }}
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="mb-1">Email</label>
                            <input v-bind:class="{'is-invalid': !!this.errors.email}" @change="inputChange"
                                   class="form-control" type="text" name="email" id="email" v-model="form.email">
                            <div class="invalid-feedback" v-if="this.errors.email">
                                <div v-for="(msg, i) in this.errors.email" v-bind:key="i">{{ msg }}</div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="mb-1">Password</label>
                            <input v-bind:class="{'is-invalid': !!this.errors.password}" @change="inputChange"
                                   class="form-control" type="password" name="password" id="password" v-model="form.password">
                            <div class="invalid-feedback" v-if="this.errors.password">
                                <div v-for="(msg, i) in this.errors.password" v-bind:key="i">{{ msg }}</div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <input type="checkbox" id="remember_me" class="form-check-input">
                            <label for="remember_me" class="font-sm">Remember me</label>
                        </div>

                        <div class="form-group mb-1">
                            <button @click.prevent="login" class="n-btn d-block n-bg-primary txt-white">Log in</button>
                        </div>

                        <div class="form-group mb-3 px-2 txt-right">
                            <router-link to="/forgot-password" class="font-sm txt-secondary">Forget Password?</router-link>
                        </div>
                    </div>

                    <div class="form_wrapper_footer mt-5">
                        <div class="row">
                            <div class="col-6 txt-center">
                                <router-link to="/register" class="pt-3 txt-black">Not a customer?</router-link>
                            </div>
                            <div class="col-6 txt-left">
                                <a href="https://neucruit.com" class="n-btn grd-light txt-grd-light">
                                    Schedule a Demo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="popup-wrapper">
            <popup-modal ref="popup" keepOpen="true">
                <div class="h3">
                    <div class="d-flex align-items-center wrapp">
                        <img class="img" src="/images/check-img.png" alt="">
                        <div>
                            <h2>We’ve received your registration form!</h2>
                            <p class="message">Hold tight, your study page will be generated soon. We
                                will send you an email once set-up has complete</p>
                        </div>
                    </div>
                </div>
            </popup-modal>
        </div>
    </div>
</template>

<script>

import AuthHeader from "./Header";
import { mapActions } from "vuex";
import PopupModal from '../../components/PopupModal.vue';

export default {
    name: "Login",
    components: {
        AuthHeader,
        PopupModal
    },
    data() {
        return {
            form: {
                email: "",
                password: ""
            },
            errors: [],
            message: "",
            user: null
        };
    },
    methods: {
        ...mapActions(["LogIn"]),
        async login() {
            if (!this.validateForm()) {
                return false;
            }

            const User = new FormData();
            User.append("email", this.form.email);
            User.append("password", this.form.password);

            try {
                const res = await this.LogIn(User);

                if (!res.data.success) {
                    await this.$router.push( {name: 'Registration' });
                } else {
                    this.user = res.data.user;
                    this.nextPage();
                }
                this.showError = false
            } catch (error) {
                switch(error.response.status) {
                    case 401:
                        this.errors = {
                            unauthorized: 'Invalid email or password.'
                        }
                        break;
                    case 422:
                        this.errors = error.response.data.errors;
                        break;
                    case 403:
                        this.message = error.response.data.message;
                        this.$refs.popup.open();
                        break;
                    default:
                        this.errors = {
                            api: 'Application error! please, try later'
                        }
                }
            }
        },
        inputChange(e) {
            this.errors = [];
        },
        validateForm() {
            let isValid = true;
            const email = this.form.email.trim();
            const password = this.form.password.trim();

            if (!email) {
                isValid = false;
                this.errors['email'] = ['The email field is required.'];
            } else if (!this.validateEmail(email)) {
                this.errors['email'] = ['The email must be a valid email address.'];
                isValid = false;
            }

            if (!password) {
                this.errors['password'] = ['The password field is required.'];
                isValid = false;
            }

            return isValid;
        },
        validateEmail(email) {
            return String(email).toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        },
        async nextPage() {
            // if (this.user.studies.length > 1) {
            //     return await this.$router.push( { name: 'SelectStudy' } );
            // }

            await this.$store.commit('setStudy', this.user.studies[0]);
            
            window.location.pathname = '/';
            
            //return await this.$router.push( { name: 'Home' } );
        }
    }
}
</script>

<style lang="scss">
.popup-wrapper {
    .window {
        width: 562px;
    }

    .base_modal__body, .base_modal__header, .base_modal {
        padding: 0;
    }

    .wrapp {
        padding: 44px 62px 44px 40px;

        img {
            margin-top: -16px;
        }

        .message {
            margin-top: 9px;
        }
    }
}
</style>
