import axios from 'axios';

const state = {
    participants: [],
    allParticipants: [],
    participantsWithStatus: [],
    participant: null,
    statuses: [],
    genders: [],
    message: false,
    participantCountries: null,
    participantEmails: null,
    filters: {
        ages: [],
    },
};

const getters = {
    studyParticipants: state => state.participants,
    allParticipants: state => state.allParticipants,
    statuses: state => state.statuses,
    genders: state => state.genders,
    filtersReq: state => state.filters,
    participantMessage: state => state.message,
    participantEmails: state => state.participantEmails,
    participant: state => state.participant,
    participantsWithStatus: state => state.participantsWithStatus,
    participantCountries: state => state.participantCountries
};

const actions = {
    async getStudyParticipants ({commit}, data) {
        const response = await axios.get(`/study/${data.id}/participants`)
        commit('setParticipants', response.data.data)
    },

    async getAllStudyParticipants ({commit}, data) {
        const response = await axios.get(`/study/${data.id}/all-participants`)
        commit('setAllParticipants', response.data.data)
    },

    async getParticipantsWitStatusRequest ({commit}, data) {
        const response = await axios.get(`/study/${data.id}/participants/status`)
        commit('setSingleParticipantWithStatus', response.data.data)
    },

    async changeStatusRequest({commit}, data) {
        await axios.post(`/study/${data.study.id}/participants/status/${data.id}`, data)
    },

    async getStatuses ({commit}) {
        const response = await axios.get('/participants-statuses')
        commit('setParticipantsStatuses', response.data.data)
    },

    async getGenders ({commit}) {
        const response = await axios.get('/participants-gender')
        commit('setGenders', response.data.data)
    },

    async getFilteredList ({commit}, data) {
        const response = await axios.post('/participants-filter', { filters: data.filters, study: data.study })
        commit('setSingleParticipantWithStatus', response.data.data.withStatus)
        commit('setParticipants', response.data.data.withoutStatus)
    },

    async getAllFilteredList ({commit}, data) {
        const response = await axios.post('/all-participants-filter', { filters: data.filters, study: data.study })
        commit('setAllParticipants', response.data.data)
    },

    async getAllAges ({commit}) {
        const response = await axios.get('/participants-filters');
        commit('setFilters', response.data.data)
    },

    async getParticipantCountries ({commit}, data) {
        const response = await axios.get(`/study/${data.id}/participants-countries`)
        commit('setParticipantCountries', response.data)
    },

    async createParticipantRequest({commit}, data) {
        const response = await axios.post('/participants', data)
        commit('setParticipant', response.data.success)
    },

    async getParticipantEmailsRequest({commit}, id) {
        const response = await axios.get(`/participant-emails/${id}`)
        commit('setParticipantEmails', response.data.data)
    },

    async getParticipantRequest ({commit}, id) {
        const response = await axios.get(`/participant/${id}`)
        commit('setSingleParticipant', response.data.data)
    }
}

const mutations = {
    setParticipants(state, participants){
        state.participants = participants
    },

    setAllParticipants(state, allParticipants){
        state.allParticipants = allParticipants
    },

    setParticipantsStatuses(state, statuses){
        state.statuses = statuses
    },

    setGenders(state, genders){
        state.genders = genders
    },

    setFilters(state, filters){
        state.filters = filters
    },

    setParticipant(state, data) {
        state.message = data
    },

    setParticipantEmails(state, participantEmails) {
        state.participantEmails = participantEmails
    },

    setSingleParticipantWithStatus(state, participantsWithStatus) {
        state.participantsWithStatus = participantsWithStatus
    },

    setSingleParticipant(state, participant) {
        state.participant = participant
    },

    setParticipantCountries(state, participantCountries) {
        state.participantCountries = participantCountries
    }
}

export default {
    state,
    getters,
    actions,
    mutations
};

