<template>
    <div class="forgot-password-wrapper">
        <div class="d-flex">
            <div class="left">
                <auth-header></auth-header>
            </div>

            <div class="right p-4">
                <div class="alert alert-danger" role="alert" v-if="showError">
                    <div v-for="error in errors">{{ error }}</div>
                </div>
                <form @submit.prevent="sendLink" class="form_wrapper">
                    <div class="form_wrapper_body p-5 n-bg-white">
                        <h2 class="txt-center">Forgot your password?</h2>
                        <p class="second-text txt-center">Enter your email to receive a reset link</p>
                        <div class="form-group mb-3">
                            <label for="email" class="mb-1">Email</label>
                            <input class="form-control" required type="email" name="email" id="email"
                                   v-model="form.email">
                        </div>

                        <div class="form-group mb-1">
                            <button type="submit" class="n-btn d-block n-bg-primary txt-white">Send reset link</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>

<script>
import AuthHeader from "./Header";
import { mapActions } from "vuex";

export default {
    name: 'ForgotPassword',
    components: { AuthHeader },

    data: () => ({
        form: {
            email: "",
        },
        errors: [],
        showError: false
    }),

    methods: {
        ...mapActions(['sendLinkEmail']),
        async sendLink() {
            const Email = new FormData();
            Email.append("email", this.form.email);

            await this.sendLinkEmail(Email)
                .then(res => {
                    if (res.data.success) {
                        this.$router.push({
                            name: 'CheckEmail',
                            params: {
                                email: this.form.email
                            }
                        });
                    } else {
                        this.errors.push(res.data.message)
                        this.showError = true
                        this.form.email = ''
                        setTimeout(() => {
                            this.showError = false
                        }, 3000)
                    }
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style lang="scss" scoped>
.forgot-password-wrapper {
    .second-text {
        font-size: 16px;
        line-height: 24px;
        margin-bottom: 57px;
        color: #5D6E82;
    }
}
</style>
