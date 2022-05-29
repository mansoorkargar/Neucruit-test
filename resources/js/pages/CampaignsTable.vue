<template>
    <div class="campaigns-wrapper">

        <div class="header">
            <div class="social-parent">
                <div class="social-section">
                    <h1 class="social-title">Social Media Campaigns</h1>
                    <div class="progresses-wrapper d-flex justify-content-between">
                        <div class="bar"><p class="progress-status"><span>{{ progress }}</span>
                            <span>/15 Campaign Created</span></p>
                            <div class="progressbar">
                                <div class="progressbar text-center"
                                     style="background-color: #00C7A8; margin: 0; color: #E7ECF3;"
                                     :style="{width: progress + '%'}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <router-link to="/participance" class="social-btn">Manage Participants</router-link>
            </div>
        </div>
        <div class="social-table">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Status</th>
                    <th scope="col">Description</th>
                    <th scope="col">Social name</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="campaign in campaigns" :key="campaign">
                    <td>{{ campaign.name }}</td>
                    <td>{{ campaign.type.name }}</td>
                    <td>{{ campaign.status ? 'Active' : 'InActive' }}</td>
                    <td>{{ campaign.description }}</td>
                    <td>{{ campaign.social_name ?? '-' }}</td>
                </tr>

                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name: 'campaigns-table',

    data: () => ({
        progress: 70,
    }),

    async created () {
        await this.getCampaignsRequest(this.study)
    },

    computed: {
        ...mapGetters(['campaigns'])
    },

    methods: {
        ...mapActions(['getCampaignsRequest'])
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
                border-radius: 5px;


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
        border-radius: 5px;

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
