<template>
    <div class="modal-backdrop" v-if="showModal">
        <div v-if="showSuccessModal" class="success-modal d-flex align-items-center justify-center flex-column">
            <h2 class="text-center">Invite sent</h2>
            <img class="mt-4" src="/images/icons/success-icon.svg" alt="">
            <div class="invitation-text mt-3 text-center">
                <span>
                    Your invite has been sent. You can now view incoming participants in the Management System
                </span>
            </div>

            <button class="go-to-manage-btn mt-3" @click="goToManage">Go to Management System</button>
        </div>
        <div v-else>
            <div class="close-btn" @click="toggleModal"><img src="/images/icons/close_icon.svg" alt=""></div>
            <div id="modal" class="modal-wrapper">
                <spinner v-if="isLoading"></spinner>
                <div class="alert alert-danger" v-if="message" v-html="message"></div>

                <div class="d-flex align-items-center header-wrapper">
                    <img src="/images/icons/users-icon.svg" alt="">
                    <div class="head-text">
                        Manage Site Users
                    </div>
                </div>
                <hr>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="input-header-text">Invite new users by email</div>
                        <input
                            type="email"
                            class="form-control mt-2"
                            placeholder="laura@neucruit.com, liv@neucruit.com, zan@neucruit.com"
                            aria-label="email"
                            aria-describedby="basic-addon1"
                            v-model="emails"
                        >
                        <div class="small-text">Seperate multiple email addresses with a comma</div>
                    </div>

                    <div class="buttons-group d-flex justify-content-between mt-2">
                        <button @click="inviteUser" class="send-button">Send Invite</button>
                    </div>
                </div>
                <template v-if="studyInvitations.length > 0 || studyUsers.length > 0">
                    <div class="head-text mt-4">Invited Site Users</div>
                    <div class="invited-users">
                        <div v-for="user in studyUsers">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center justify-content-between w-100 mt-2">
                                    <div class="d-flex align-items-center mt-3">
                                        <div class="icon-name">{{ user.first_letter }}</div>
                                        <div>
                                            <div class="user-email">{{ user.name }} ({{ user.email }})</div>
                                            <div class="status">Joined {{ dateFormatter(user.created_at) }}</div>
                                        </div>
                                    </div>
                                    <div class="actions">
                                        <div @click="removeUser(user.id)">
                                            <img class="trash-icon" src="/images/icons/trash-icon.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-for="user in studyInvitations">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center justify-content-between w-100 mt-2">
                                    <div class="d-flex align-items-center mt-3">
                                        <div class="icon-name">{{ user.first_letter }}</div>
                                        <div>
                                            <div class="user-email">{{ user.email }}</div>
                                            <div class="status" v-if="user.is_expired">Invite expired</div>
                                            <div class="status" v-else>Invite sent {{ dateFormatter(user.created_at) }}</div>
                                        </div>
                                    </div>
                                    <div class="actions">
                                        <div v-if="user.is_expired" @click="resendInvite(user.id)" class="name">Resend invite</div>
                                        <div v-else class="name" @click="removeInvite(user.id)">Cancel invite</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import moment from "moment";
import Spinner from "./Spinner";

export default {
    name: 'add-user-modal',
    
    components: {
        Spinner
    },

    props: ['showModal', 'toggleModal', 'user'],

    data: () => ({
        isLoading:        false,
        emails:           '',
        message:          null,
        showSuccessModal: false
    }),

    async mounted () {
    },

    computed: {
        ...mapGetters(['study', 'studyUsers', 'studyInvitations'])
    },

    methods: {
        ...mapActions([
            'userInvite',
            'getStudyUsers',
            'getStudyInvitations',
            'removeStudyUserRequest',
            'resendInviteRequest',
            'removeInviteRequest'
        ]),

        dateFormatter (date) {
            return moment(date).format('DD/MM/YYYY')
        },

        goToManage () {
            this.showSuccessModal = false
            this.toggleModal()
        },

        async removeUser (id) {
            this.message   = null
            this.isLoading = true

            await this.removeStudyUserRequest({
                user:  {id},
                study: this.study
            })
            .then(res => {
                this.message  = null
                this.getStudyUsers(this.study)
                this.getStudyInvitations(this.study)

                this.isLoading = false
            })
            .catch((err) => {
                this.message = '<b>' + err.response.data.message + '</b><br>';

                for (let field of Object.values(err.response.data.errors)) {
                    for (let message in field) {
                        this.message += field[message] + '<br>';
                    }
                }

                this.isLoading = false
            })
        },

        async removeInvite (id) {
            this.message   = null
            this.isLoading = true
            
            await this.removeInviteRequest({
                id,
                study: this.study
            })
            .then(res => {
                this.message  = null
                this.getStudyUsers(this.study)
                this.getStudyInvitations(this.study)

                this.isLoading = false
            })
            .catch((err) => {
                this.message = '<b>' + err.response.data.message + '</b><br>';

                for (let field of Object.values(err.response.data.errors)) {
                    for (let message in field) {
                        this.message += field[message] + '<br>';
                    }
                }

                this.isLoading = false
            })
        },

        async resendInvite (id) {
            this.message   = null
            this.isLoading = true

            await this.resendInviteRequest({
                id,
                study: this.study
            })
            .then(res => {
                this.message  = null
                this.getStudyUsers(this.study)
                this.getStudyInvitations(this.study)

                this.isLoading = false
            })
            .catch((err) => {
                this.message = '<b>' + err.response.data.message + '</b><br>';

                for (let field of Object.values(err.response.data.errors)) {
                    for (let message in field) {
                        this.message += field[message] + '<br>';
                    }
                }
                
                this.isLoading = false
            })
        },

        async inviteUser () {
            this.message   = null
            this.isLoading = true

            await this.userInvite({
                study:  this.study,
                emails: this.emails.length > 0 ? this.emails.split(',') : null,
            })
            .then(res => {
                res.data.map(item => {
                    if (typeof item.status !== 'boolean') {
                        this.message = item.status
                    } else {
                        this.getStudyUsers(this.study)
                        this.getStudyInvitations(this.study)

                        this.emails           = ''
                        this.message          = null
                        this.showSuccessModal = true
                    }
                })

                this.isLoading = false
            })
            .catch((err) => {
                this.message = '<b>' + err.response.data.message + '</b><br>';

                for (let field of Object.values(err.response.data.errors)) {
                    for (let message in field) {
                        this.message += field[message] + '<br>';
                    }
                }

                this.isLoading = false
            })
        }
    }
}
</script>

<style lang="scss" scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
}

/* width */
::-webkit-scrollbar {
    width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
    background: #E9EAF7;
    border-radius: 10px;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: #4142A2;
    border-radius: 17px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #4142A2;
}

.modal-wrapper, .success-modal {
    width: 100%;
    max-width: 684px;
    padding: 23px 29px;
    background-color: white;
    border: 1px solid #DEE2E6;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.12), 0 20px 20px rgba(0, 0, 0, 0.08);
    border-radius: 8px;
    position: fixed;
    transform: translate(-50%, -50%);
    top: 50%;
    left: 50%;
    z-index: 999999;

    .head-text {
        font-weight: 700;
        font-size: 18px;
        line-height: 22px;
        color: #343F44;
    }

    .input-header-text {
        font-weight: 700;
        font-size: 16px;
        line-height: 20px;
        color: #343F44;
    }

    .message {
        font-size: 14px;
        line-height: 22px;
        color: rgba(84, 89, 94, 0.6);
    }

    .input-group {
        border: 2px solid #343F44;
        box-sizing: border-box;
        border-radius: 12px;
    }

    .input-group-text-custom {
        display: flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
    }

    .form-control {
        width: 475px;
        border: 1px solid black;
        padding: 11px 17px;
        height: 46px;
        margin-right: 5px;

        &:focus {
            background-color: unset!important;
            box-shadow: unset!important;
        }
    }

    .add-user-btn {
        font-weight: 700;
        font-size: 12px;
        line-height: 15px;
        letter-spacing: 0.01em;
        color: #6D79B8;
        cursor: pointer;
    }

    .buttons-group {
        .send-button {
            padding: 15px 32px;
            background: #6D79B8;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            line-height: 17px;
            text-align: center;
            color: #FFFFFF;
        }
    }

    .actions {
        white-space: nowrap;

        div {
            display:inline-block;
            margin-left:10px;
        }
    }

    .small-text {
        margin-top: 5px;
        font-weight: 600;
        font-size: 12px;
        line-height: 15px;
        letter-spacing: -0.48px;
        color: #5D6569;
    }

    .header-wrapper {
        img {
            width: 5%;
            margin-right: 5px;
        }
    }

    .invited-users {
        height: 35vh;
        overflow-y: scroll;
        padding-right: 20px;

        .head-text {
            font-weight: 600;
            font-size: 18px;
            line-height: 22px;
            color: #343F44;
        }

        .name {
            color: #6D79B8;
            cursor: pointer;
        }

        .user-email {
            font-weight: 600;
            font-size: 14px;
            line-height: 17px;
            color: #343F44;
        }

        .status {
            font-weight: 400;
            font-size: 12px;
            line-height: 15px;
            letter-spacing: -0.48px;
            color: #5D6569;
        }
    }

    .icon-name {
        margin-right: 5px;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #6d79b8;
    }

    .trash-icon {
        width: 20px;
        height: 20px;
        margin-left: 5px;
        cursor: pointer;
    }
}

.success-modal {
    h2 {
        font-weight: 400;
        font-size: 35px;
        line-height: 43px;
        letter-spacing: 0.01em;
        color: #343F44;
    }

    .go-to-manage-btn {
        background: #6D79B8;
        border-radius: 12px;
        color: white;
    }
}

.close-btn {
    position: absolute;
    bottom: calc(100% - 25%);
    right: 32%;
    cursor: pointer;
    z-index: 9999999;
}
</style>
