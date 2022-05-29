<template>
    <div class="check-email-wrapper">
        <div class="d-flex">
            <div class="left">
                <auth-header></auth-header>
            </div>

            <div class="right p-4">
                <form @submit.prevent class="form_wrapper">
                    <div class="form_wrapper_body p-5 n-bg-white">
                        <img class="check-mail-img" src="/images/check-mail.png" alt="">
                        <h2 class="txt-center">Please check your email!</h2>
                        <p class="second-text txt-center">An email has been sent to {{ $route.params.email }}. Please click on the included link to reset your password.</p>
                        <div class="form-group mb-1">
                            <router-link to="/login" class="n-btn d-block n-bg-primary txt-white">  Return to Login </router-link>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>

<script>
import AuthHeader from "./Header";

export default {
    name: 'CheckEmail',
    components: { AuthHeader },

    data: () => ({}),
}
</script>

<style lang="scss" scoped>
.check-email-wrapper {
    .second-text {
        width: 94%;
        font-size: 16px;
        line-height: 24px;
        margin: 0 auto 57px;
        color: #5D6E82;
    }

    .check-mail-img {
        display: flex;
        margin: 0 auto 24px;
    }
}
</style>
