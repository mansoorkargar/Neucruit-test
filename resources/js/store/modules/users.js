import axios from 'axios';

const state = {
    users: [],
    invitations: [],
    changedPasswordData: null,
    errorChangePassword: ''
};

const getters = {
    studyUsers: state => state.users,
    studyInvitations: state => state.invitations,
    changedPasswordData: state => state.changedPasswordData,
    errorChangePassword: state => state.errorChangePassword,
};

const actions = {
    async getStudyUsers ({commit}, data) {
        const response = await axios.get(`/study/${data.id}/users`)
        commit('setUsers', response.data)
    },

    async getStudyInvitations ({commit}, data) {
        const response = await axios.get(`/study/${data.id}/invitations`)
        commit('setInvitations', response.data)
    },

    async removeStudyUserRequest ({commit}, data) {
        const response = await axios.delete(`/study/${data.study.id}/users/${data.user.id}`)
    },

    async userInvite ({commit}, data) {
        return await axios.post(`/study/${data.study.id}/invitations`, {emails: data.emails})
    },

    async resendInviteRequest ({commit}, data) {
        const response = await axios.post(`/study/${data.study.id}/invitations/${data.id}/resend`)
    },

    async removeInviteRequest ({commit}, data) {
        const response = await axios.delete(`/study/${data.study.id}/invitations/${data.id}`)
    },

    async changePasswordRequest ({commit}, data) {
        await axios.post('/change-password', data)
            .then(res => {
                commit('setChangePassword', res.data)

                setTimeout(() => {
                    commit('setChangePassword', null)
                }, 4000)
            })
            .catch(err => {
                commit('setErrorMessage', err.response.data.message)

                setTimeout(() => {
                    commit('setErrorMessage', null)
                }, 4000)
            })

        setTimeout(() => {
            commit('setChangePassword', null)
        }, 4000)
    }
}

const mutations = {
    setUsers(state, users){
        state.users = users
    },
    setInvitations(state, invitations){
        state.invitations = invitations
    },
    setChangePassword(state, changedPasswordData) {
        state.changedPasswordData = changedPasswordData
    },
    setErrorMessage(state, errorChangePassword) {
        state.errorChangePassword = errorChangePassword
    }
}

export default {
    state,
    getters,
    actions,
    mutations
};
