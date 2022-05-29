<template>
    <div class="campaigns-wrapper">
        <div class="header">
            <div class="social-parent">
                <div class="social-section">
                    <h1 class="social-title">Your campaigns</h1>
                    <h2>Now you can manage your participants & invite your staff.</h2>
                </div>
                <router-link to="/manage" class="social-btn">Go to Manage Participants</router-link>
            </div>
        </div>
        <div class="social-table">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Channel</th>
                    <th scope="col">Medium</th>
                    <th scope="col">Start date</th>
                    <th scope="col">End date</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="campaign in campaigns" :key="campaign">
                        <td>{{ campaign.name }} <span v-if="campaign.status != 'Completed'">[<a :href="'/landing-page/' + campaign.study_id + '/' + campaign.slug" target="_blank">Link</a>]</span></td>
                        <td>{{ campaign.type }}</td>
                        <td>{{ dateFormatter(campaign.starts_at) ?? '-' }}</td>
                        <td>{{ dateFormatter(campaign.ends_at) ?? '-' }}</td>
                        <td>{{ campaign.status }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import moment from "moment";

export default {
    name: 'campaigns-table',

    data: () => ({
        progress: 100,
    }),

    async created () {
        await this.getCampaignsRequest(this.study)
    },

    computed: {
        ...mapGetters([
            'campaigns',
            'user',
            'study',
        ])
    },

    methods: {
        ...mapActions(['getCampaignsRequest']),

        dateFormatter (date) {
            return moment(date).format('DD/MM/YYYY')
        },
    }
}
</script>

<style lang="scss" scoped>
.campaigns-wrapper {
    margin: 25px;

    .header {
        padding: 32px 20px;
        background: #FFFFFF;
        box-shadow: 0px 0px 5.73057px rgba(0, 0, 0, 0.08);
        border-radius: 4.91192px;

        .first-text {
            font-weight: 400;
            font-size: 22px;
            line-height: 27px;
            letter-spacing: 0.01em;
            color: #343F44;
        }

        .second-text {
            font-weight: 400;
            font-size: 16px;
            line-height: 20px;
            letter-spacing: 0.01em;
            color: #343F44;
        }
    }

    .progressbar {
        width: 100%;
        height: 6px;
        background-color: #E7ECF3;
        transition: width 500ms;
        box-sizing: border-box;
        border-radius: 3.26746px;
    }

    .social-table {
        margin-top: 16px;
        padding: 34px 24px;
        background: #FFFFFF;
        box-shadow: 0 0 5.73057px rgba(0, 0, 0, 0.08);
        border-radius: 4.91192px;

        thead {
            background: #E9EAF7;
            text-align: center;
        }

        tr td {
            text-align: center;
        }
    }
}
.social-parent {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.social-title {
    font-style: normal;
    font-weight: 400;
    font-size: 22px;
    line-height: 27px;
    letter-spacing: 0.01em;
    color: #343F44;
    margin-bottom: 28px;
}

.progress-status {
    margin-bottom:3px ;
}

.social-btn {
    background: #6D79B8;
    border-radius: 12px;
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    padding: 18px 45px;
    color: #FFFFFF;
    margin-bottom: 45px;
    margin-right: 32px;
}
</style>