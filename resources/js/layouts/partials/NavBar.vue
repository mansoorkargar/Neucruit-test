<template>
    <header class="head n-bg-white d-flex align-items-center">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <div class="trial_name">
                    <p class="txt-black">{{ study ? study.name : '' }} <span>Dashboard</span></p>
                </div>
                <div class="d-flex user_menu">
                    <div class="user_info">
                        <div class="case">Case study</div>
                        <div class="trial">Trial ID: {{ study ? study.trial_id : '' }}</div>
                    </div>

                    <div @click="showDropDown = !showDropDown" class="user n-bg-bg-silver d-flex align-items-center justify-content-center position-relative">
                        <img :src="'/images/icons/user.svg'" class="manage_icon" alt="manage">
                        <div v-if="showDropDown" class="menu position-absolute">
                            <ul>
                                <li class="d-flex mb-2 gray"><img :src="'/images/icons/user.svg'" alt=""> <div class="name">Profile</div></li>
                                <li class="d-flex mb-2" @click="this.$parent.logout()"><img :src="'/images/icons/sign-out-icon.svg'" alt=""> <div class="name">Sign Out</div></li>
                                <li class="d-flex mb-2" @click="$refs.popup.open()"><img :src="'/images/icons/change-pass-icon.svg'" alt=""> <div class="name">Change password</div></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="!successMessage" class="popup-wrapper">
            <popup-modal ref="popup">
                <div class="popup-header">
                    <img src="/images/icons/change-pass.svg"/>
                    <h2>Change Password</h2>
                </div>

                <div v-if="errorChangePassword" class="alert alert-danger">{{ errorChangePassword }}</div>

                <form action="" @submit.prevent="changePassword">
                    <div class="form-group mb-3">
                        <label for="current-password" class="password-title mb-1">Current Password</label>
                        <input
                            v-model="password.current"
                            class="form-control"
                            placeholder="input text"
                            type="password"
                            name="current-password"
                            id="current-password"
                        >
                        <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
                        <!-- <div class="forget-password">
                            Forgot your password?
                        </div> -->
                    </div>
                    <div class="form-group mb-3">
                        <label for="new-password" class="password-title mb-1">New Password</label>
                        <input
                            v-model="password.new"
                            class="form-control"
                            type="password"
                            placeholder="input text"
                            name="current-password"
                            id="new-password"
                        >

                        <div class="mt-2 password-requiraments" v-for="(item, i) in passwordValidation" :key="i">
                            <div class="d-flex align-items-center">
                                <img src="/images/icons/warning-icon.svg" alt="">
                                <div class="req" :class="item.isValid ? 'success' : 'error'">{{ item.text }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirm-password" class=" password-title mb-1">Confirm New Password</label>
                        <input
                            v-model="password.confirm"
                            class="form-control"
                            type="password"
                            placeholder="input text"
                            name="current-password"
                            id="confirm-password"
                        >
                    </div>
                    <div class="d-block d-flex justify-content-end">
                        <button @click="closeModal" class="cancel">Cancel</button>
                        <button type="submit" class="submit">Change password</button>
                    </div>
                </form>
            </popup-modal>
        </div>

        <div class="popup-wrapper">
            <popup-modal ref="popupMessage">
                <div class="d-flex align-items-center justify-content-center flex-column">
                    <img src="/images/icons/check-icon.svg" alt="">
                    <div class="success-message">{{ successMessage }}</div>
                </div>
            </popup-modal>
        </div>
    </header>
</template>

<script>
import PopupModal from "../../components/PopupModal";
import { mapActions, mapGetters } from "vuex";
export default {
    name: 'NavBar',
    components: {PopupModal},
    data() {
        return {
            successMessage: '',
            errorMessage: '',
            passwordValidation: {
                character8: {
                    isValid: false,
                    text: 'Atleast 8 characters'
                },
                letterAndNumber: {
                    isValid: false,
                    text: 'Must include a letter and a number'
                }
            },
            study: null,
            showDropDown: false,
            password: {
                current: '',
                new: '',
                confirm: '',
            }
        }
    },

    mounted() {
        this.init();
    },

    computed: {
      ...mapGetters(['changedPasswordData', 'errorChangePassword'])
    },

    watch: {
        "password.new" (value) {
            this.checkPassword(value)
        },

        successMessage(val) {
            if (val) {
                this.$refs.popupMessage.open()
            } else {
                this.$refs.popupMessage.close()
            }
        },

        changedPasswordData: {
            deep: true,
            handler(val) {
                if (val) {
                    if (val.success) {
                        this.successMessage = val.message
                    } else {
                        this.errorMessage = val.message
                    }
                } else {
                    this.successMessage = ''
                    this.errorMessage = ''
                }
            }
        }
    },

    methods: {
        ...mapActions(['changePasswordRequest']),
        async init() {
            this.study = await this.$store.getters.study
        },

        checkPassword(value) {
          this.passwordValidation.character8['isValid'] = value.length >= 8;
          this.passwordValidation.letterAndNumber['isValid'] = /^(?=.*?\d)(?=.*?[a-zA-Z])[a-zA-Z\d]+$/.test(value);
        },

        changePassword() {
            const data = {
                old_password: this.password.current,
                password: this.password.new,
                password_confirmation: this.password.confirm,
            };

            this.changePasswordRequest(data)

            this.password.current = ''
            this.password.new = ''
            this.password.confirm = ''
        },

        closeModal() {
            this.showDropDown = false
            this.$refs.popup.close()
        },

        closeSuccessModal() {
            this.$refs.popupMessage.close()
        }
    }
}
</script>
<style lang="scss" scoped>
.right_container {
    .head {
        height: 66px;
    }
}

.trial_name {
    margin-top: 20px;
}

.menu {
    width: 220px;
    top: 65px;
    right: 0;
    background: #FFFFFF;
    box-shadow: 0 0 5.73057px rgb(0 0 0 / 8%);
    border-radius: 8px;
    padding: 12px 24px;

    .name {
        margin-left: 10px;
        font-weight: 400;
        font-size: 16px;
        line-height: 20px;
        letter-spacing: 0.01em;
        color: #26282C;
    }

    .gray {
        .name {
            color:#999;
        }
    }

    .d-flex {
        margin-bottom:20px !important;

        &:last-child {
            margin-bottom:10px !important;
        }
    }
}

.success-message {
    margin-top: 24px;
    font-weight: 700;
    font-size: 36px;
    line-height: 45px;
    color: #343F44;
}

.success {
    color: green!important;
}

.error-message {
    color: red;
    font-size: 10px;
}

.forget-password {
    margin-top: 10px;
    font-weight: 600;
    font-size: 12px;
    line-height: 15px;
    letter-spacing: -0.48px;
    color: #6D79B8;
}

.password-requiraments {
    .req {
        margin-left: 10px;
        font-weight: 700;
        font-size: 12px;
        line-height: 15px;
        letter-spacing: 0.01em;
        color: #AEB2B4;
    }
}

.cancel {
    background: unset;
    font-weight: 600;
    font-size: 14px;
    line-height: 17px;
    color: #6D79B8;
    padding: 0px 46px;
    display: inline-block;
}

.submit {
    margin-left: 12px;
    padding: 14px 30px;
    background: #6D79B8;
    border-radius: 10px;
    font-weight: 600;
    font-size: 16px;
    line-height: 20px;
    text-align: center;
    color: #FFFFFF;
}

.password-title {
    font-weight: 700;
    font-size: 16px;
    line-height: 20px;
    color: #343F44;
}


.user_menu {
    margin-top: 13px;
    margin-right: 142px;
}

.user_info {
    width: 183px!important;
    padding: 5px 0 37px 9px !important;
}

.case {
    font-weight: 700;
    font-size: 12px!important;
    line-height: 15px!important;
    letter-spacing: 0.01em!important;
    color: #6D79B8!important;
}

.trial {
    font-weight: 400;
    font-size: 16px!important;
    line-height: 20px!important;
    letter-spacing: 0.01em!important;
    color: #343F44!important;
}
.popup {

    &-header {
        display: flex;
        padding-bottom: 10px;
        margin-bottom: 25px;
        border-bottom: 1px solid #D6D9DA;

        img {
            margin-right: 12px
        }

        h2 {
            font-weight: 700;
            font-size: 18px;
            line-height: 22px;
        }
    }
}
</style>
<style lang="scss">
.head {
    .popup-wrapper {
        .window {
            padding: 20px 25px 25px;
        }
        .close-modal {
            top: -15px;
            color: #343F44;
            cursor: pointer;
        }
    }
}
</style>
