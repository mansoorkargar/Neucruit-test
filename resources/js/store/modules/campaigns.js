import axios from 'axios';

const state = {
    campaigns: null,
};

const getters = {
    campaigns: state => state.campaigns
};

const actions = {
    async getCampaignsRequest({commit}, data) {
        const response = await axios.get(`/study/${data.id}/campaigns`)
        commit('setCampaigns', response.data)
    }
}

const mutations = {
    setCampaigns(state, campaigns) {
        state.campaigns = campaigns
    },
}

export default {
    state,
    getters,
    actions,
    mutations
};
