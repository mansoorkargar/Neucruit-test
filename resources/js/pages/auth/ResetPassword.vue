<template>
    <div class="reset-password-wrapper">
        <div class="d-flex">
            <div class="left">
                <auth-header></auth-header>
            </div>

            <div class="right p-4">
                <div class="alert alert-danger" role="alert" v-if="showError">
                    <div v-for="error in errors" class="alert alert-danger" role="alert">
                        <div v-for="err in error">{{ err.toString() }}</div>
                    </div>
                </div>
                <form @submit.prevent="reset" class="form_wrapper">
                    <div class="form_wrapper_body p-5 n-bg-white">
                        <h2 class="mb-5 txt-center">Set New Password</h2>

                        <div class="form-group mb-3">
                            <label for="password" class="mb-1">Password</label>
                            <input class="form-control" required type="password" name="password" id="password" v-model="form.password">
                        </div>

                        <div class="form-group mb-3">
                            <label for="password-confirm" class="mb-1">Retype Password</label>
                            <input class="form-control" required type="password" name="password-confirm" id="password-confirm" v-model="form.confirmPassword">
                        </div>

                        <div class="form-group mb-1">
                            <button type="submit" class="n-btn d-block n-bg-primary txt-white">Set Password</button>
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
    name: 'ResetPassword',
    components: {AuthHeader},

    data: () => ({
        form: {
            password: "",
            confirmPassword: ''
        },
        errors: [],
        showError: false
    }),

    methods: {
        ...mapActions(['resetPassword']),
        async reset() {
            this.errors = []
            const sentData = new FormData();
            sentData.append("password", this.form.password);
            sentData.append("password_confirmation", this.form.confirmPassword);
            sentData.append("token", this.$route.query.token);

            await this.resetPassword(sentData)
                .then(res => {
                    if (res.data.token) {
                        this.$store.commit('setToken', res.data.token);
                        this.$store.commit('setUser', res.data.user);

                        this.$router.push({ name: 'Home' });
                    }
                })
                .catch(err => {
                    this.errors    = err.response.data.errors
                    this.showError = true

                    setTimeout(() => {
                        this.showError = false
                    }, 10000)
                })
        }
    }
}
</script>

<style lang="scss" scoped>
.reset-password-wrapper {

}
</style>



