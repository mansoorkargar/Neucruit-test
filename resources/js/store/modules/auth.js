import axios from 'axios';

const state = {
    user: null,
    token: null,
    study: null,
    questionList: null,
    questionTypesList: null,
};

const getters = {
    authToken: state => state.token,
    study: state => state.study,
    user: state => state.user,
    questionList: state => state.questionList,
    questionTypesList: state => state.questionTypesList,
};

const actions = {
    async LogIn({commit}, User) {
        const response = await axios.post('/auth/login', User);
        commit('setToken', response.data.token);
        commit('setUser', response.data.user);
        return response;
    },

    async getStudy({commit}, study) {
        const response = await axios.get('/study/' + study.id);
        commit('setStudy', response.data);
        return response;
    },

    async resetPassword({ commit }, sentData) {
        return await axios.post('/auth/reset-password', sentData)
    },

    async sendLinkEmail({ commit }, sentData) {
        return await axios.post('/auth/forget-password', sentData)
    },

    async register({ commit }, sentData) {
        const response = await axios.post('/auth/register', sentData);

        commit('setUser', response.data.user);

        return response
    },

    async getUser({commit}) {
        const response = await axios.get('/me');
        return response.data.user;
    },

    async logOut({commit}) {
        await axios.post('/auth/logout');
        commit('logOut');
    },

    async getQuestionList({commit}) {
        const response = await axios.get('/get-question-list');
        commit('setQuestionList', response.data.data)
    },

    async getQuestionTypesList({commit}) {
        const response = await axios.get('/get-question-types');
        commit('setQuestionTypesList', response.data.data)
    },

    async setAnswers({commit}, data) {
        const response = await axios.post('/answers?token=' + data.token, data.form)
        return response.data
    }
};

const mutations = {
    setToken(state, _token) {
        state.token = _token
    },
    setUser(state, _user){
        state.user = _user
    },
    setStudy(state, _study) {
        state.study = _study;
    },
    logOut(state) {
        state.user = null
        state.token = null
    },
    setQuestionList(state, questionList) {
        state.questionList = questionList
    },
    setQuestionTypesList(state, questionTypesList) {
        state.questionTypesList = questionTypesList
    },
};

export default {
  state,
  getters,
  actions,
  mutations
};
