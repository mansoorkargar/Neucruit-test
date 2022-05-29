import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import auth from './modules/auth';
import users from './modules/users';
import communications from './modules/communications';
import participants from './modules/participants';
import campaigns from './modules/campaigns';

const dataState = createPersistedState({
    paths: ['auth', 'participants', 'users']
})

// Create store
export default new Vuex.Store({
  modules: {
    auth,
    communications,
    users,
    participants,
    campaigns
  },

  plugins: [dataState]
});
