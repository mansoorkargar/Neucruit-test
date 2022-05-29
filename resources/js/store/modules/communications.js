import axios from 'axios';

const state = {
    communications: null,
    communication: null
};

const getters = {
    communications: state => state.communications,
    communication:  state => state.communication,
};

const actions = {
    async getCommunications({commit}, data) {
        const response = await axios.get(`/study/${data.id}/communications`)
        commit('setCommunications', response.data)
    },

    async getCommunication({commit}, data) {
        const response = await axios.get(`/study/${data.id}/communications/${data.communication_id}`)
        commit('setCommunication', response.data)
    },

    async editCommunications({commit}, data) {
        const response = await axios.post(`/study/${data.id}/communications/${data.communication_id}`, data.data, {
            headers: { "Content-Type": "multipart/form-data" },
        })
        return response
    },

    async editEnabled({commit}, data) {
        const response = await axios.put(`/study/${data.id}/communications/${data.communication_id}`, data.data)
    }
};

const mutations = {
    setCommunications(state, data) {
        state.communications = data
    },
    setCommunication(state, data) {
        state.communication = data
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};
