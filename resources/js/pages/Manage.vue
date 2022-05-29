<template>
    <div>
        <div class="dashboard_container crms-wrapper">
            <div>
                <div class="d-flex participant-wrapper" >
                    <div class="participant">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="head-text">
                                {{ study.name }} – Participant Management
                            </div>
                            <a :href="'/api/study/' + study.id + '/participants/export'" target="_blank" class="export-btn" v-if="user.role_id == 3"><p>EXPORT DATA</p> <img src="/images/icons/export-data-icon.svg" alt=""></a>
                        </div>
                        <div class="progresses-wrapper d-flex justify-content-between">
                            <div class="bar"><div class="progress-status d-flex"><div class="randomized">{{ study.participants_total }} participants </div></div>
                                <div class="progressbar">
                                    <div class="progressbar text-center"
                                         style="background-color: #00C7A8; margin: -5px 0 0 0; color: #E7ECF3;"
                                         :style="{width: progress + '%'}"></div>
                                </div>
                            </div>

                            <div class="left-days">
                                <p class="head-text">DAYS LEFT</p>
                                <apexchart class="days-chart" width="120" type="bar" :options="miniChartOptions" :series="miniSeries"></apexchart>
                                <p class="days">{{ study.days_left }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="users">
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="head-text">Site Users</div>
                            <div @click="showModal = true" class="add-user">Manage User</div>
                        </div>
                        <div class="users-list mt-2 position-relative" v-if="studyUsers && studyUsers.length">
                            <div class="user-item">
                                <div class="d-flex">
                                    <img src="https://via.placeholder.com/35" alt="">
                                    <div>
                                        <div class="user-name">{{ studyUsers[0].name }}</div>
                                        <div class="user-position" v-if="studyUsers[0].role">{{ studyUsers[0].role.name }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-item" v-if="studyUsers.length >= 2">
                                <div class="d-flex">
                                    <img src="https://via.placeholder.com/35" alt="">
                                    <div>
                                        <div class="user-name">{{ studyUsers[1].name }}</div>
                                        <div class="user-position" v-if="studyUsers[1].role">{{ studyUsers[1].role.name }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tabs d-flex align-items-center">
                    <div @click="showAll = false" class="tab" :class="!showAll ? 'active-tab' : ''">
                        <div class="tab-title">Overview</div>
                    </div>
                    <div @click="showAll = true" class="tab" :class="showAll ? 'active-tab' : ''">
                        <div class="tab-title">All Participants</div>
                    </div>
                </div>

                <div class="all-participants mt-0">
                    <div class="filters-wrapper d-flex justify-content-start align-items-center">

                        <div class="d-flex flex-column">
                            <label class="input-label" for="status">Contact Status</label>
                            <select id="status" class="form-input" v-model="filters.status">
                                <option :value="null">All</option>

                                <template v-if="statuses && statuses.length">
                                <option
                                    v-for="status in statuses"
                                    :value="status.id"
                                    :key="status.id"
                                >{{ status.name }}</option>
                                </template>
                            </select>
                        </div>
                        <div class="d-flex flex-column">
                            <label class="input-label" for="age">Age</label>

                            <select id="age" class="form-input" v-model="filters.age">
                                <option :value="null">All</option>

                                <template v-if="filtersReq.ages && filtersReq.ages.length">
                                <option
                                    v-for="(filter, i) in filtersReq.ages"
                                    :value="filter.age"
                                    :key="i"
                                >{{ filter.age }}</option>
                                </template>
                            </select>
                        </div>

                        <div class="d-flex flex-column">
                            <label class="input-label" for="gender">Gender</label>

                            <select id="gender" class="form-input" v-model="filters.gender">
                                <option :value="null">All</option>

                                <template v-if="genders && genders.length">
                                <option
                                    v-for="gender in genders"
                                    :value="gender.id"
                                    :key="gender.id"
                                >{{ gender.name }}</option>
                                </template>
                            </select>
                        </div>

                        <div class="d-flex flex-column">
                            <label class="input-label" for="ethnicity">Ethnicity</label>

                            <select id="ethnicity" class="form-input" v-model="filters.ethnicity">
                                <option :value="null">All</option>

                                <template v-if="filtersReq.ethnicities && filtersReq.ethnicities.length">
                                <option
                                    v-for="(filter, i) in filtersReq.ethnicities"
                                    :value="filter.ethnicity"
                                    :key="i"
                                >{{ filter.ethnicity }}</option>
                                </template>
                            </select>
                        </div>

                        <button class="filter-btn" @click="filter">Filter</button>
                    </div>
                    <hr>
                    <div class="table-wrapper" v-if="!studyParticipants.length && !participantsWithStatus.length && !allParticipants.length">
                        <div class="no-data d-flex justify-content-between align-items-center flex-column">
                            <img src="/images/icons/no-data.png" alt="">
                            <div class="no-data-text">
                            <span>
                                Once participants register on your trial, data will appear on this table
                            </span>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div v-if="!showAll">
                            <div v-if="studyParticipants" class="table-wrap">
                                <div class="table-texts">
                                    <div class="needed d-flex"><img src="/images/icons/arrow-down-black.svg" alt="">Action needed ({{ studyParticipants ? studyParticipants.length : 0 }})</div>
                                    <div class="small-text">Set the status of a participant that requires an action to be taken on</div>
                                </div>
                                <div class="table-wrapper">
                                    <table class="table mt-3">
                                        <thead class="table-head">
                                        <tr>
                                            <th scope="col">Reference Number</th>
                                            <th scope="col">Contact Status</th>
                                            <th scope="col">Registration Date</th>
                                            <th scope="col">Age</th>
                                            <th scope="col">Gender</th>
                                            <th scope="col">Ethnicity</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="studyParticipants">
                                        <tr v-for="participant in studyParticipants" :key="participant">
                                            <th class="text-center">{{ participant.reference_number }}</th>
                                            <td class="text-center">
                                                <select class="statuses" @change="handleOnChange($event, participant.id)">
                                                    <option
                                                        v-for="status in statuses"
                                                        :value="status.id"
                                                        :selected="participant.status.slug === status.slug"
                                                        :key="status.id">{{ status.slug }}</option>
                                                </select>
                                            </td>
                                            <td class="text-center">{{ dateFormatter(participant.created_at) ?? '-' }}</td>
                                            <td class="text-center">{{ participant.age }}</td>
                                            <td class="text-center">{{ participant.gender ? participant.gender.name : '-' }}</td>
                                            <td class="text-center">{{ participant.ethnicity }}</td>
                                            <td class="d-flex justify-content-center align-items-center">
                                                <button @click="showSingleParticipant(participant.id)" class="action-btn with-margin" v-if="user.role_id == 3"><img src="/images/icons/show-icon.svg" alt=""></button>
                                                <button @click="getParticipantEmails(participant.id)" class="action-btn"><img src="/images/icons/mail-icon.svg" alt=""></button>
                                            </td>
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div v-if="participantsWithStatus" class="table-wrap">
                                <div class="table-texts">
                                    <div class="needed d-flex"><img src="/images/icons/arrow-down-black.svg" alt="">In Progress ({{ participantsWithStatus ? participantsWithStatus.length : 0 }})</div>
                                    <div class="small-text">Set the status of a participant that requires an action to be taken on</div>
                                </div>
                                <div class="table-wrapper-status">
                                    <table class="table mt-3">
                                        <thead class="table-head">
                                        <tr>
                                            <th scope="col">Reference Number</th>
                                            <th scope="col">Contact Status</th>
                                            <th scope="col">Registration Date</th>
                                            <th scope="col">Age</th>
                                            <th scope="col">Gender</th>
                                            <th scope="col">Ethnicity</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="participant in participantsWithStatus" :key="participant">
                                            <th class="text-center">{{ participant.reference_number }}</th>
                                            <td class="text-center">
                                                <select @change="handleOnChange($event, participant.id)" class="statuses">
                                                    <option
                                                        :selected="participant.status.slug === status.slug"
                                                        v-for="status in statuses" :key="status.id"
                                                        :value="status.id"
                                                    >{{ status.slug }}</option>
                                                </select>
                                            </td>
                                            <td class="text-center">{{ dateFormatter(participant.created_at) ?? '-' }}</td>
                                            <td class="text-center">{{ participant.age }}</td>
                                            <td class="text-center">{{ participant.gender ? participant.gender.name : '-' }}</td>
                                            <td class="text-center">{{ participant.ethnicity }}</td>
                                            <td class="d-flex justify-content-center align-items-center">
                                                <button @click="showSingleParticipant(participant.id)" class="action-btn with-margin" v-if="user.role_id == 3"><img src="/images/icons/show-icon.svg" alt=""></button>
                                                <button @click="getParticipantEmails(participant.id)" class="action-btn"><img src="/images/icons/mail-icon.svg" alt=""></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div v-if="showAll">
                            <div class="table-wrap">
                                <div class="table-texts">
                                    <div class="needed d-flex"><img src="/images/icons/arrow-down-black.svg" alt="">All Participants</div>
                                    <div class="small-text">All registered participants</div>
                                </div>
                                <div class="table-wrapper-status">
                                    <table class="table mt-3">
                                        <thead class="table-head">
                                        <tr>
                                            <th scope="col">Reference Number</th>
                                            <th scope="col">Contact Status</th>
                                            <th scope="col">Registration Date</th>
                                            <th scope="col">Age</th>
                                            <th scope="col">Gender</th>
                                            <th scope="col">Ethnicity</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="participant in allParticipants" :key="participant">
                                            <th class="text-center">{{ participant.reference_number }}</th>
                                            <td class="text-center">
                                                <select @change="handleOnChange($event, participant.id)" class="statuses">
                                                    <option
                                                        :selected="participant.status.slug === status.slug"
                                                        v-for="status in statuses" :key="status.id"
                                                        :value="status.id"
                                                    >{{ status.slug }}</option>
                                                </select>
                                            </td>
                                            <td class="text-center">{{ dateFormatter(participant.created_at) ?? '-' }}</td>
                                            <td class="text-center">{{ participant.age }}</td>
                                            <td class="text-center">{{ participant.gender ? participant.gender.name : '-' }}</td>
                                            <td class="text-center">{{ participant.ethnicity }}</td>
                                            <td class="d-flex justify-content-center align-items-center">
                                                <button @click="showSingleParticipant(participant.id)" class="action-btn with-margin" v-if="user.role_id == 3"><img src="/images/icons/show-icon.svg" alt=""></button>
                                                <button @click="getParticipantEmails(participant.id)" class="action-btn"><img src="/images/icons/mail-icon.svg" alt=""></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <add-user-modal
                :user="user"
                :showModal="showModal"
                :toggleModal="toggleModal"
            />

            <popup-modal ref="popup">
                <div class="participant-modal-wrapper">
                    <div class="d-flex align-items-center">
                        <img src="/images/icons/participan-mail-icon.svg" alt="">
                        <div class="message-text">Past Communications</div>
                    </div>
                    <hr>
                    <div class="message-text" v-if="!participantEmails.length">No emails have been sent yet</div>
                    <div v-else class="messages-wrapper">
                        <div v-for="email in participantEmails">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="message-type">{{ email.email_types.name }}</div>
                                    <div class="date">{{ dateFormatter(email.created_at) }}</div>
                                </div>
                                <div class="message-text"> > </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </popup-modal>

            <popup-modal ref="popupDetails">
                <div class="participant-modal-wrapper">
                    <div class="ref-number"># {{ participant.reference_number }} Details:</div>
                    <template v-if="participant.json && participant.json.old">
                        <template v-for="(answer, question) in participant.json.old">
                            <template v-if="answer">
                                <hr style="margin-top:12px;">
                                <div class="name" style="margin-top:10px;">{{ question }}: {{ answer }}</div>
                            </template>
                        </template>
                    </template>
                    <template v-if="participant.json && participant.json.questions">
                        <template v-for="(item, position) in participant.json.questions">
                            <template v-if="item.type != 'SEPARATOR'">
                                <hr style="margin-top:12px;">
                                <div class="name" style="margin-top:10px;">{{ item.name }}: {{ typeof participant.json.asnwers.replies[item.id] == 'object' ? participant.json.asnwers.replies[item.id].join('; ') : participant.json.asnwers.replies[item.id] }}</div>
                            </template>
                        </template>
                    </template>
                </div>
            </popup-modal>
        </div>
    </div>
</template>

<script>
import SecondaryNavbar from './partials/SecondaryNavbar';
import { mapActions, mapGetters } from "vuex";
import AddUserModal from "../components/AddUserModal";
import PopupModal from '../components/PopupModal';
import moment from "moment";

export default {
    name: 'Manage',
    components: {
        AddUserModal,
        SecondaryNavbar,
        PopupModal
    },

    data: () => ({
        progress: 212,
        miniChartOptions: {
            dataLabels: {
                enabled: false,
            },
            plotOptions: {
                bar: {
                    columnWidth: '20px'
                }
            },
            fill: {
                colors: ['#4142A2'],
            },
            chart: {
                toolbar: {
                    show: false
                },
            },

            tooltip: {
                enabled: false
            },
            grid: {
                show: false
            },
            xaxis: {
                labels: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
        },
        miniSeries: [{
            data: [ 100, 70, 20, 100, 70, 20 ]
        }],
        isShowList: false,
        showModal: false,
        ages: [],
        filters: {
            status: null,
            age: null,
            gender: null,
            ethnicity: null
        },
        showAll: false,
    }),

    async created () {
        await this.getStudy(this.user.studies[0])
        await this.getStudyUsers(this.study)
        await this.getStudyInvitations(this.study)
        await this.getStudyParticipants(this.study)
        await this.getAllStudyParticipants(this.study)
        await this.getStatuses()
        await this.getGenders()
        await this.getAllAges()
        await this.getParticipantsWitStatusRequest(this.study)

        if (this.$route.query.viewTeam) {
            this.showModal = true;
        }
    },

    computed: {
        ...mapGetters([
            'user',
            'study',
            'studyUsers',
            'studyInvitations',
            'studyParticipants',
            'statuses',
            'genders',
            'filtersReq',
            'participantEmails',
            'filtersReq',
            'participantEmails',
            'participant',
            'participantsWithStatus',
            'allParticipants'
        ])
    },

    methods: {
        ...mapActions([
            'getStudy',
            'getStudyUsers',
            'getStudyInvitations',
            'getStudyParticipants',
            'getStatuses',
            'getGenders',
            'getFilteredList',
            'getAllAges',
            'getParticipantEmailsRequest',
            'getAllAges',
            'getParticipantEmailsRequest',
            'getParticipantRequest',
            'getParticipantsWitStatusRequest',
            'changeStatusRequest',
            'getAllStudyParticipants',
            'getAllFilteredList'
        ]),

        dateFormatter (date) {
            return moment(date).format('DD/MM/YYYY')
        },

        toggleModal(event) {
            if (event) {
                if (event.target.closest('#modal')) {
                    return
                }
            }
            this.showModal = false
        },

        async handleOnChange (e, id) {
            await this.changeStatusRequest({id, statusId: +e.target.value, study: this.study})
            await this.getParticipantsWitStatusRequest(this.study)
            await this.getParticipants(this.study)
        },

        filter () {
            if (this.showAll) {
                this.getAllFilteredList({filters: this.filters, study: this.study})
            } else {
                this.getFilteredList({filters: this.filters, study: this.study})
            }
        },

        async getParticipantEmails (id) {
            await this.getParticipantEmailsRequest(id)
            this.$refs.popup.open()
        },

        async showSingleParticipant (id) {
            await this.getParticipantRequest(id)
            this.$refs.popupDetails.open()
        },
    }
}
</script>

<style lang="scss" scoped>
.tab:last-child{
    padding: 18px 26px !important;
}

.crms-wrapper {
    width: 100%;
    //max-width: 1215px;
    padding: 25px;

    .table-wrap {
        margin-top: 33px;
        padding: 26px 18px;
        background: #F6F7FA;
        box-shadow: 0px 4px 9px rgba(56, 71, 109, 0.09);
        border-radius: 12px;
    }

    .table {
        width: 100%;
        background: #fff;
    }

    .needed {
        font-weight: 400;
        font-size: 22px;
        line-height: 27px;
        letter-spacing: 0.01em;
        color: #343F44;

        img {
            margin-right: 11px;
        }
    }

    .randomized {
        font-weight: 400;
        font-size: 22px;
        line-height: 27px;
        letter-spacing: 0.01em;
        color: #343F44;
    }

    .small-text {
        margin-left: 28px;
        font-weight: 700;
        font-size: 12px;
        line-height: 15px;
        letter-spacing: 0.01em;
        color: #343F44;
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

    .rotated {
        transform: rotate(180deg);
    }


    .progress-status {
        font-weight: 400;
        font-size: 22px;
        line-height: 27px;
        letter-spacing: 0.01em;
        color: #00C7A8;
        padding-top: 8px;
    }

    .progresses-wrapper {
        margin-top: 68px;
    }

    .tabs {
        margin-top: 33px;

        .tab {
            padding: 18px 47px;
            background: #FFFFFF;
            font-size: 14px;
            line-height: 17px;
            text-align: center;
            letter-spacing: 0.01em;
            color: #989898;
            cursor: pointer;
        }

        .active-tab {
            color: #4142A2;
            background: #E9EAF7;
            border-bottom: 3px solid #6D79B8;
        }
    }

    .head-text {
        font-weight: 400;
        font-size: 22px;
        line-height: 27px;
        letter-spacing: 0.01em;
        color: #343F44;
    }

    .second-text {
        font-weight: 700;
        font-size: 12px;
        line-height: 15px;
        letter-spacing: 0.01em;
        color: #343F44;
    }

    .participant {
        width: 100%;
        padding: 20px 17px;
        //max-width: 721px;
        background: #FFFFFF;
        box-shadow: 0 0 5.73057px rgb(0 0 0 / 8%);
        border-radius: 4.91192px;
    }

    .statuses {
        background: none;
        border: none;
        outline: none;
    }

    .users {
        width: 100%;
        margin-left: 42px;
        //max-width: 383px;
        background: #FFFFFF;
        box-shadow: 0 0 5.73057px rgba(0, 0, 0, 0.08);
        border-radius: 4.91192px;

        .head-text {
            font-weight: 400;
            font-size: 22px;
            line-height: 27px;
            letter-spacing: 0.01em;
            color: #343F44;
            margin-left: 15px;
        }

        .add-user {
            margin-right: 15px;
            font-weight: 700;
            font-size: 12px;
            line-height: 15px;
            letter-spacing: 0.01em;
            color: #6D79B8;
            cursor: pointer;
        }

        .big-index {
            z-index: 999;
        }

        .user-item {
            //width: 385px;
            background: #F6F7FA;
            border-bottom: 1px solid #E9EAF7;
            padding: 11px 21px;

            .user-name {
                font-weight: 400;
                font-size: 16px;
                line-height: 20px;
                letter-spacing: 0.01em;
                color: #343F44;
            }

            .user-position {
                font-weight: 700;
                font-size: 12px;
                line-height: 15px;
                letter-spacing: 0.01em;
                color: #343F44;
            }

            img {
                margin-right: 10px;
                border-radius:50%;
                width: 40px;
                height: 40px;
            }
        }

        .arrow-down {
            display: flex;
            margin: 11px auto;
            cursor: pointer;
        }
    }

    .export-btn {
        width: 100%;
        max-width: 134px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 2px 10px;
        background: #FFFFFF;
        border: 0.590954px solid #4142A2;
        box-sizing: border-box;
        border-radius: 2.36382px;
        cursor: pointer;

        p {
            font-size: 12px;
            line-height: 15px;
            letter-spacing: 0.01em;
            color: #4142A2;
        }

        img {
            margin-top: 3px;
        }
    }

    .progressbar {
        width: 100%;
        height: 6px;
        background-color: #E7ECF3;
        margin: 0.85em auto;
        transition: width 500ms;
        box-sizing: border-box;
        border-radius: 3.26746px;
    }

    .left-days {
        position: relative;
        margin: 0 70px 0 0;

        .days {
            margin: 5px 0 0 -15px;
            font-size: 24px;
            line-height: 29px;
            letter-spacing: 0.01em;
            color: #343F44;
        }
        .head-text {
            margin: -11px 0 0 -19px;
            font-weight: 600;
            font-size: 12px;
            line-height: 15px;
            letter-spacing: 0.01em;
            color: #343F44;
        }
    }

    .all-participants {
        padding: 45px 25px;
        background: #FFFFFF;
        box-shadow: 0px 0px 7px rgba(0, 0, 0, 0.08);

        .flex-column {
            margin-right: 48px;
        }

        .no-data-text {
            font-weight: 700;
            font-size: 11.8154px;
            line-height: 15px;
            text-align: center;
            letter-spacing: 0.01em;
            color: #9FA7D1;
        }
    }

    .table > :not(:first-child) {
        border-top: unset;
    }

    .table-head {
        background: #E9EAF7;

        th {
            padding: 16px 25px;
            font-weight: 700;
            font-size: 12px;
            line-height: 15px;
            text-align: center;
            color: #343F44;
        }
    }

    .action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        padding: 0;
        background: linear-gradient(180deg, #F6F7FA 0%, #E9EAF7 100%);
        border-radius: 6.74949px;
    }

    .with-margin {
        margin-right: 20px;
    }

    .form-input {
        width: 192px;
        margin-top: 5px;
        padding: 14px;
        border: 1px solid #C6C6C6;
        box-sizing: border-box;
        border-radius: 4px;
        background: #FFFFFF;
        box-shadow: 0 0 7px rgba(0, 0, 0, 0.08);
        font-weight: 400;
        font-size: 16px;
        line-height: 20px;
        letter-spacing: 0.01em;
        color: #343F44;
        outline: none;
    }

    .input-label {
        font-weight: 400;
        font-size: 16px;
        line-height: 20px;
        letter-spacing: 0.01em;
        color: #343F44;
    }

    .filter-btn {
        margin-top: 15px;
        border: 2px solid #6D79B8;
        border-radius: 16px;
        background: #fff;
        font-weight: 400;
        font-size: 16px;
        color: #6D79B8;
    }

    .message-text {
        margin-left: 14px;
        font-weight: 700;
        font-size: 18px;
        line-height: 22px;
        color: #343F44;
    }

    .table-wrapper-status {
        margin-top: 26px;
        background: #F6F7FA;
        box-shadow: 0px 4px 9px rgba(56, 71, 109, 0.09);
        border-radius: 12px;

        table {
            background: #fff;
        }
    }
}
.left-days {
    .days-chart {
        position: absolute;
        top: -31px;
        left: 5px;
    }
}

.crms-wrapper {
    .window {
        width: 684px;
    }

    .base_modal__header {
        padding: 5px 13px;
    }

    .message-type {
        font-weight: 600;
        font-size: 14px;
        line-height: 17px;
        color: #343F44;
    }

    .date {
        font-weight: 400;
        font-size: 12px;
        line-height: 15px;
        letter-spacing: -0.48px;
        color: #5D6569;
    }

    .messages-wrapper {
        overflow-y: scroll;
        padding-right: 13px;
        height: 336px;
    }

    hr {
        margin: 21px 0 0 0;
    }

    .ref-number {
        font-weight: 700;
        font-size: 18px;
        line-height: 22px;
        color: #343F44;
    }

    .name {
        font-weight: 700;
        font-size: 12px;
        line-height: 15px;
        letter-spacing: 0.01em;
        color: #343F44;
    }
}
</style>
