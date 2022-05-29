<template>
    <div class="participants-wrapper">
        <div class="message" v-if="showMessageBlock">
            <p class="head-text">Welcome back! test changes </p>
            <p class="message-text">{{ study.participants_this_week }} new <template v-if="study.participants_this_week == 1">participant</template><template v-else>participants</template> have pre-screened and registered this week. <br> Schedule
                screening visits now!</p>
            <img class="close-img" src="/images/icons/close-icon.svg" alt="" @click="showMessageBlock = false">
        </div>

        <div class="progresses-wrapper">
            <div class="bar"><div class="progress-status">
                <p class="progress-status-number">{{ study.participants_total }}</p>
                <div class="progress-status-sec">&nbsp;participants randomized</div></div>
                <div class="progressbar">
                    <div class="progressbar text-center"
                         style="background-color: #00C7A8; margin: 0; color: #E7ECF3;"
                         :style="{width: '147%'}"></div>
                </div>
            </div>
                <div class="d-flex align-items-center days-left-wrap">
                    <div class="left-days">
                        <p class="head-text">DAYS LEFT</p>
                        <apexchart class="days-chart" width="120" type="bar" :options="miniChartOptions" :series="miniSeries"></apexchart>
                        <p class="days">{{ study.days_left }}</p>
                    </div>
                </div>

        </div>

        <div class="d-flex ">
            <div class="recruitment-progress-wrapper">
                <div class="progress-chart-wrapper">
                    <div class="apex-parent">
                        <div class="progress-wrapper-period d-flex align-items-center justify-content-between">
                            <div>Real-time update on recruitment progress</div>
                            <div>
                                <label for="period-select" class="lable-show">Show:</label>
                                <select class="select-period" name="period" id="period-select" v-model="selectedRealtimePeriod">
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                        </div>
                        <apexchart class="progress-chart" width="900" height="320" :options="progressChartOption" :series="realTimeSeries"></apexchart>
                    </div>
                </div>
            </div>
            <div class="metrics-wrapper">
                <div class="users">
                    <div class="d-flex justify-content-between align-items-center team">
                        <div class="head-text">Site Users</div>
                        <div class="view"><a href="/manage?viewTeam=true">View Full Team</a></div>
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
                <div class="metrics-chart">
                    <p class="head-text">Pre-screening metrics</p>
                    <div class="status-progress">{{ inligibleParticipants.length }} / {{ study.participants_total }}</div>
                    <div class="progress position-relative">
                        <div class="progress-bar color-1" role="progressbar" :style="`width: ${inligibleParticipants.length}%`" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar progress-bar-2 color-2" role="progressbar" :style="`width: ${notEligible.length}%`" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar color-3" role="progressbar" :style="`width: ${pending.length}%`" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <div class="d-flex align-items-center square-wrapper">
                            <div class="color-1 square"></div>
                            <p>Not Eligible</p>
                        </div>
                        <div class="d-flex align-items-center square-wrapper">
                            <div class="color-2 square"></div>
                            <p>Eligible</p>
                        </div>
                        <div class="d-flex align-items-center square-wrapper">
                            <div class="color-3 square"></div>
                            <p>Pending</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between conversion-cross-channel-wrapper">
            <div class="conversion-rate-wrapper">
                <div class="line"></div>
                <p class="rate"><span>{{ study.conversion_rate }}</span> conversion rate</p>
                <div v-for="item in rateConversation" :key="item.id" class="rate-item-wrapper">
                    <div :class="item.value > 70 ? 'trapezoid' : 'square'" :style="{backgroundColor: `${item.color}`, width: `${item.value}px`}">
                        <p :style="{marginLeft: `calc(100% - ${item.value - 50})px`}">{{ item.name }}</p>
                    </div>
                </div>
            </div>
            <div class="cross-channel-wrapper d-flex align-items-center justify-content-around">
                <div class="cross">
                    <div v-for="(item, i) in crossChannel" :key="item.id" class="d-flex align-items-center cross-channel-item-wrapper">
                        <div class="cross-channel-item" :style="{backgroundColor: item.color}"></div>
                        <div class="cross-title">{{ statuses[i].slug }}</div>
                    </div>
                </div>
                <div class="cross-chart-wrapper">
                    <div class="d-flex justify-content-between mt-4 position-relative">
                        <h2 class="text-center">Cross-channel analytics of conversion metrics</h2>
                        
                        <select class="d-flex justify-content-between align-items-baseline dropdown-wrapper" v-model="selectedCrossChannel">
                            <option value="last_15_days">Last 15 days</option>
                            <option value="last_month">Last Month</option>
                            <option value="last_year">Last Year</option>
                        </select>
                    </div>
                    <apexchart type="bar" width="900" height="280" :options="crossChannelOptions" :series="crossChannelSeries"></apexchart>
                </div>
            </div>
        </div>

        <div v-if="participantCountries" class="d-flex justify-content-between demographics-wrapper">
            <div class="table-wrapper">
                <h2>Demographics by region</h2>
                <table class="table">
                    <thead>
                    <tr class="head-table">
                        <th scope="col">Area</th>
                        <th scope="col">Participants</th>
                        <th scope="col">Percentage</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, i) in participantCountries.percentage" :key="i">
                        <td>{{ Object.values(participantCountries.unique)[i] }}</td>
                        <td>{{ Object.values(participantCountries.count)[i] }}</td>
                        <td>{{ participantCountries.percentage[i] }}%</td>
                    </tr>
                    </tbody>
                </table>`
            </div>

            <div class="chart-wrapper">
                <div class="d-flex justify-content-between align-items-center chart-wrapper-title position-relative">
                    <h2>Demographics by gender</h2>
                    <select class="d-flex justify-content-between align-items-baseline dropdown-wrapper" v-model="selectedDemographic">
                        <option value="by_gender">By Gender</option>
                        <option value="by_age">By Age</option>
                        <option value="by_ethnicity">By Ethnicity</option>
                    </select>
                </div>
                <div class="d-flex apex-parent-chart">
                    <apexchart type="bar" width="400" height="300" :options="demographicsOptions" :series="demographicsSeries"></apexchart>
                    <div class="cross-last">
                        <div v-for="(item, i) in crossChannel" :key="item.id" class="d-flex align-items-center cross-channel-item-wrapper">
                            <div class="cross-channel-item" :style="{backgroundColor: item.color}"></div>
                            <div class="cross-title">{{ statuses[i].slug }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
    name: 'Participants',

    data: () => ({
        selectedDemographic: 'by_gender',
        selectedCrossChannel: 'last_15_days',
        selectedRealtimePeriod: 'weekly',
        showPeriosList: false,
        showGenderList: false,
        showMessageBlock: true,
        progress: 70,
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
        progressChartOption: {
            chart: {
                height: 350,
                type: 'line',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },

            stroke: {
                curve: 'straight'
            },
            title: {
                align: 'left',
                style: {
                    fontSize:  '16px',
                    fontWeight:  'bold',
                    color: '#939AA9',
                },
            },
            grid: {
                row: {
                    colors: [ 'transparent'],
                    opacity: 0.5,
                    strokeDashArray: 0
                },
            },
            xaxis: {
                labels: {
                    show: false
                }
            },
            legend: {
                show: false
            }
        },
        series: [{
            name: 'Net Profit',
            data: [44, 55, 57, 56, 61, 58, 63]
        }, {
            name: 'Revenue',
            data: [76, 85, 101, 98, 87, 105, 91]
        }, {
            name: 'Free Cash Flow',
            data: [35, 41, 36, 26, 45, 48, 52]
        }, {
            name: 'Free Cash Flow',
            data: [35, 41, 36, 26, 45, 48, 52]
        }],
        crossChannel: [
            {id: 1, title: 'Viewed', color: '#4142A2'},
            {id: 2, title: 'Pre-screened', color: '#6D79B8'},
            {id: 3, title: 'Registered', color: '#9099CA'},
            {id: 4, title: 'Screened', color: '#9FA7D1'},
            {id: 5, title: 'Randomized', color: '#00C7A8'},
        ],
        rateConversation: [
            {id: 1, name: 'OUTREACH', value: 170, color: '#4142A2'},
            {id: 1, name: 'PRE-SCREEN', value: 150, color: '#6D79B8'},
            {id: 1, name: 'SCREEN', value: 130, color: '#9099CA'},
            {id: 1, name: 'CONSENT', value: 110, color: '#9FA7D1'},
            {id: 1, name: '', value: 50, color: '#00C7A8'},
        ],
    }),

    async created() {
        await this.getStudy(this.user.studies[0])
        await this.getStudyUsers(this.study)
        await this.getStatuses()
        await this.getAllStudyParticipants(this.study)
        await this.getParticipantCountries(this.study)
    },

    computed: {
        ...mapGetters(['user', 'study', 'studyUsers', 'allParticipants', 'participantCountries', 'statuses']),

        inligibleParticipants () {
            const filtered = []
            this.allParticipants.map(participant => {
                if (participant.status.name !== 'REGISTERED' && participant.status.name !== 'INELIGIBLE') {
                    filtered.push(participant)
                }
            })

            return filtered
        },

        notEligible () {
            const filtered = []
            this.allParticipants.map(participant => {
                if (participant.status.name === 'INELIGIBLE') {
                    filtered.push(participant)
                }
            })

            return filtered
        },

        pending  () {
            const filtered = []
            this.allParticipants.map(participant => {
                if (participant.status.name === 'REGISTERED') {
                    filtered.push(participant)
                }
            })

            return filtered
        },

        crossChannelOptions() {
            let data = {
                chart: {
                    type: 'bar',
                    toolbar: {
                        show: false
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: Object.values(this.study.channels[this.selectedCrossChannel].categories),
                },
                legend: {
                    show: false,
                },
                fill: {
                    opacity: 1,
                    colors:  ['#4142a2', '#6D79B8', '#9099CA', '#9FA7D1', '#00C7A8']
                }
            };

            return data;
        },

        realTimeSeries() {
            return [
                {name: "Registered",    data: Object.values(this.study.realtime[this.selectedRealtimePeriod].registered)},
                {name: "Ineligible",    data: Object.values(this.study.realtime[this.selectedRealtimePeriod].not_eligible)},
                {name: "Completed",     data: Object.values(this.study.realtime[this.selectedRealtimePeriod].completed)},
            ]
        },

        crossChannelSeries() {
            let registered   = [],
                inelibile    = [],
                confirmed    = [],
                completed    = [],
                notReachable = [];

            for (var i in this.study.channels[this.selectedCrossChannel].categories) {
                registered.push(
                    this.study.channels[this.selectedCrossChannel]['status-1'][i] ? this.study.channels[this.selectedCrossChannel]['status-1'][i] : 0
                )

                inelibile.push(
                    this.study.channels[this.selectedCrossChannel]['status-2'][i] ? this.study.channels[this.selectedCrossChannel]['status-2'][i] : 0
                )

                confirmed.push(
                    this.study.channels[this.selectedCrossChannel]['status-3'][i] ? this.study.channels[this.selectedCrossChannel]['status-3'][i] : 0
                )

                completed.push(
                    this.study.channels[this.selectedCrossChannel]['status-4'][i] ? this.study.channels[this.selectedCrossChannel]['status-4'][i] : 0
                )

                notReachable.push(
                    this.study.channels[this.selectedCrossChannel]['status-5'][i] ? this.study.channels[this.selectedCrossChannel]['status-5'][i] : 0
                )
            }

            return [
                {name: "Registered",    data: registered},
                {name: "Ineligible",    data: inelibile},
                {name: "Confirmed",     data: confirmed},
                {name: "Completed",     data: completed},
                {name: "Not reachable", data: notReachable},
            ]
        },

        demographicsOptions() {
            let data = {
                chart: {
                    type: 'bar',
                    toolbar: {
                        show: false
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: [],
                },
                legend: {
                    show: false,
                },
                fill: {
                    opacity: 1,
                    colors:  ['#4142a2', '#6D79B8', '#9099CA', '#9FA7D1', '#00C7A8']
                }
            };

            switch (this.selectedDemographic) {
                case 'by_gender':
                    data.xaxis.categories = ['Male', 'Female', 'Other'];
                    break;

                case 'by_age':
                    data.xaxis.categories = this.study.demographics.by_age.categories
                    break;

                case 'by_ethnicity':
                    data.xaxis.categories = this.study.demographics.by_ethnicity.categories
                    break;
            }

            return data;
        },

        demographicsSeries() {
            let data = [];
            switch (this.selectedDemographic) {
                case 'by_gender':
                    data = [
                        {name: "Registered", data: [
                            this.study.demographics.by_gender['status-1'][1] ? this.study.demographics.by_gender['status-1'][1] : 0,
                            this.study.demographics.by_gender['status-1'][2] ? this.study.demographics.by_gender['status-1'][1] : 0,
                            this.study.demographics.by_gender['status-1'][3] ? this.study.demographics.by_gender['status-1'][1] : 0,
                        ]},
                        {name: "Ineligible", data: [
                            this.study.demographics.by_gender['status-2'][1] ? this.study.demographics.by_gender['status-2'][1] : 0,
                            this.study.demographics.by_gender['status-2'][2] ? this.study.demographics.by_gender['status-2'][1] : 0,
                            this.study.demographics.by_gender['status-2'][3] ? this.study.demographics.by_gender['status-2'][1] : 0,
                        ]},
                        {name: "Confirmed", data: [
                            this.study.demographics.by_gender['status-3'][1] ? this.study.demographics.by_gender['status-3'][1] : 0,
                            this.study.demographics.by_gender['status-3'][2] ? this.study.demographics.by_gender['status-3'][1] : 0,
                            this.study.demographics.by_gender['status-3'][3] ? this.study.demographics.by_gender['status-3'][1] : 0,
                        ]},
                        {name: "Completed", data: [
                            this.study.demographics.by_gender['status-4'][1] ? this.study.demographics.by_gender['status-4'][1] : 0,
                            this.study.demographics.by_gender['status-4'][2] ? this.study.demographics.by_gender['status-4'][1] : 0,
                            this.study.demographics.by_gender['status-4'][3] ? this.study.demographics.by_gender['status-4'][1] : 0,
                        ]},
                        {name: "Not reachable", data: [
                            this.study.demographics.by_gender['status-5'][1] ? this.study.demographics.by_gender['status-5'][1] : 0,
                            this.study.demographics.by_gender['status-5'][2] ? this.study.demographics.by_gender['status-5'][1] : 0,
                            this.study.demographics.by_gender['status-5'][3] ? this.study.demographics.by_gender['status-5'][1] : 0,
                        ]},
                    ]
                    break;

                case 'by_age':
                case 'by_ethnicity':
                    let registered   = [],
                        inelibile    = [],
                        confirmed    = [],
                        completed    = [],
                        notReachable = [];

                    for (var i in this.study.demographics[this.selectedDemographic].categories) {
                        registered.push(
                            this.study.demographics[this.selectedDemographic]['status-1'][this.study.demographics[this.selectedDemographic].categories[i]] ? this.study.demographics[this.selectedDemographic]['status-1'][this.study.demographics[this.selectedDemographic].categories[i]] : 0
                        )

                        inelibile.push(
                            this.study.demographics[this.selectedDemographic]['status-2'][this.study.demographics[this.selectedDemographic].categories[i]] ? this.study.demographics[this.selectedDemographic]['status-2'][this.study.demographics[this.selectedDemographic].categories[i]] : 0
                        )

                        confirmed.push(
                            this.study.demographics[this.selectedDemographic]['status-3'][this.study.demographics[this.selectedDemographic].categories[i]] ? this.study.demographics[this.selectedDemographic]['status-3'][this.study.demographics[this.selectedDemographic].categories[i]] : 0
                        )

                        completed.push(
                            this.study.demographics[this.selectedDemographic]['status-4'][this.study.demographics[this.selectedDemographic].categories[i]] ? this.study.demographics[this.selectedDemographic]['status-4'][this.study.demographics[this.selectedDemographic].categories[i]] : 0
                        )

                        notReachable.push(
                            this.study.demographics[this.selectedDemographic]['status-5'][this.study.demographics[this.selectedDemographic].categories[i]] ? this.study.demographics[this.selectedDemographic]['status-5'][this.study.demographics[this.selectedDemographic].categories[i]] : 0
                        )
                    }

                    data = [
                        {name: "Registered",    data: registered},
                        {name: "Ineligible",    data: inelibile},
                        {name: "Confirmed",     data: confirmed},
                        {name: "Completed",     data: completed},
                        {name: "Not reachable", data: notReachable},
                    ]
                    break;
            }
            
            return data;
        }
    },

    methods: {
        ...mapActions(['getStudy', 'getStudyUsers', 'getAllStudyParticipants', 'getParticipantCountries', 'getStatuses'])
    }
}
</script>

<style lang="scss" scoped>
.participants-wrapper {
    padding: 25px;
    width: 100%;

    .users {
        width: 362px;
        background: #FFFFFF;
        box-shadow: 0 0 5.73057px rgba(0, 0, 0, 0.08);
        border-radius: 4.91192px;

        .head-text {
            font-weight: 600;
            font-size: 16px;
            line-height: 26px;
            letter-spacing: 0.2px;
            color: #939AA9;
        }

        .view {
            margin-right: 13px;
            font-weight: 700;
            font-size: 12px;
            line-height: 15px;
            letter-spacing: 0.01em;
            color: #6D79B8;

            a {
                color: #6D79B8;
                font-size:12px;
            }
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

    .drop-down {
        padding: 20px;
        background: #FFFFFF;
        border: 1px solid #D6D9DA;
        box-sizing: border-box;
        box-shadow: 0px 2px 10px rgba(5, 44, 63, 0.1);
        border-radius: 10px;
        top: 43px;
        right: -4px;
        z-index: 999;

        .option {
            font-weight: 400;
            font-size: 16px;
            line-height: 20px;
            color: #343F44;
            cursor: pointer;
        }
    }

    .days-left-wrap {
        margin: -15px 0 0 278px
    }

    .team-wrapper {
        width: 362px;
        background: #FFFFFF;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        border-radius: 8px;

        .team-wrap {
            margin-top: 15px;
            background: #F6F7FA;

            img {
                margin-right: 6px;
                margin-left: 16px;
                margin-bottom: 8px;
            }

            .name {
                font-weight: 400;
                font-size: 16px;
                line-height: 20px;
                letter-spacing: 0.01em;
                color: #343F44;
            }

            .position {
                font-weight: 700;
                font-size: 12px;
                line-height: 15px;
                letter-spacing: 0.01em;
                color: #343F44;
            }
        }
    }

    .cross-channel-item {
        width: 12px;
        height: 12px;
        border-radius: 2px
    }

    .cross {
        margin: 22px 0 0 35px;
    }

    .cross-last {
        margin: 126px 0 0 20px;
    }

    .cross-channel-item-wrapper {
        margin-bottom: 15px;
        p {
            margin-left: 5px;
        }
    }

    .cross-title {
        margin-left: 6px;
        font-weight: 400;
        font-size: 10.3057px;
        line-height: 13px;
        color: #333333;
    }

    .dropdown-wrapper {
        outline: none;
        padding: 5px 17px;
        border-radius: 6px;
        border: 1px dashed #00C7A8;
        cursor: pointer;
        margin-left: 88px;
        color: #00C7A8;
        font-weight: 600;
        font-size: 12px;
        line-height: 26px;
        letter-spacing: 0.2px;
    }

    .export-btn {
        width: 122px;
        display: flex;
        padding: 2px 9px;
        align-items: center;
        justify-content: space-between;
        margin: 40px 0 0 7px;
        background: #FFFFFF;
        border: 0.590954px solid #6D79B8;
        box-sizing: border-box;
        border-radius: 2.36382px;
        cursor: pointer;

        p {
            font-size: 12px;
            line-height: 15px;
            letter-spacing: 0.01em;
            color: #4142A2;
            font-weight: 700;
        }

        img {
            margin-top: 3px;
        }
    }

    .color-1 {
        background: #4142A2;
    }

    .color-2 {
        background: #6D79B8;
    }

    .color-3 {
        background: #E9EAF7;
    }

    .square {
        width: 12px;
        height: 12px;
        border-radius: 2px;
    }

    .square-wrapper {
        p {
            margin-left: 5px;
            font-size: 10px;
            line-height: 121.4%;
            color: #3E4756;
        }
    }

    .message {
        position: relative;
        width: 100%;
        //max-width: 1118px;
        padding: 32px 0 30px 42px;
        background: linear-gradient(180deg, #6D79B8 0%, #9FA7D1 100%);
        box-shadow: 0 3.56384px 10.6915px rgba(0, 0, 0, 0.06);
        border-radius: 12px;

        .head-text {
            font-weight: 400;
            font-size: 24px;
            line-height: 30px;
            letter-spacing: 0.01em;
            color: #FFFFFF;

        }

        .message-text {
            margin-top: 10px;
            font-size: 12px;
            line-height: 141.5%;
            letter-spacing: 0.01em;
            color: #FFFFFF;
        }

        .close-img {
            position: absolute;
            top: 13px;
            right: 14px;
            cursor: pointer;
        }
    }

    .progresses-wrapper {
        display: flex;
        margin-top: 24px;
        margin-bottom: 61px;

        .bar {
            width: 100%;
            max-width: 460px;
        }

        .progress-status-sec {
            font-weight: 400;
            font-size: 22px;
            line-height: 27px;
            letter-spacing: 0.01em;
            color: #343F44;
        }

        .progress-status {
            display: flex;
            font-weight: 400;
            font-size: 22px;
            line-height: 27px;
            letter-spacing: 0.01em;
            color: #00C7A8;
            margin-top: 7px;
            margin-left: 12px;


            span:first-child {
                color: #00C7A8;
                font-weight: 600;
            }

            span:last-child {
                color: #b9b6b6;
                font-weight: 600;
            }
        }

        .progressbar {
            width: 100%;
            height: 6px;
            background-color: #E7ECF3;
            margin-top: 9px;
            transition: width 500ms;
            box-sizing: border-box;
            border-radius: 3.26746px;
        }

        .left-days {
            position: relative;
            margin-right: 75px;
            margin-top: 20px;

            .days {
                margin-top: 5px;
                font-size: 24px;
                line-height: 29px;
                letter-spacing: 0.01em;
                color: #343F44;
            }
            .head-text {
                width: 60px;
                font-size: 12px;
                line-height: 15px;
                letter-spacing: 0.01em;
                color: #343F44;
            }
        }
    }
    .progress-wrapper-period {
        padding: 13px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        box-shadow: 0px 19px 51px rgba(8, 35, 48, 0.09);
    }
    .progress-chart-wrapper {
        background: #FFFFFF;
        border-radius: 7px;
        overflow:hidden;
        box-shadow: 0px 19px 51px rgba(8, 35, 48, 0.09);
    }
    select {
        border:none;
        color: #109CF1;
    }
    .name-info {
        margin:4px 0 7px 0 ;
    }
    .name {
        padding-bottom: 7px;
    }

    .metrics-wrapper {
        margin-left: 38px;

        .team {
            width: 100%;
            max-width: 362px;
            padding: 9px 0;
            background: #FFFFFF;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .team > div:first-child{
            padding: 0 22px;
        }
        .name-role {
            margin-left: 14px;
        }

        .name {
            font-weight: 600;
            font-size: 10px;
            line-height: 12px;
            color: #3E4756;
        }

        .role {
            font-size: 10px;
            line-height: 12px;
            color: #3E4756;
        }

        .view-team-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-left: 57px;
            padding: 7px 18px;
            font-weight: 600;
            font-size: 12px;
            line-height: 22px;
            letter-spacing: -0.48px;
            color: #8A8D9B;
        }
        .name-role {
            background: linear-gradient(180deg, #F6F7FA 0%, #F6F7FA 0.01%, #E9EAF7 93.23%);
            border-radius: 6px;
            display: flex;
        }

        .metrics-chart {
            margin: 20px 0 0 0;
            padding: 15px 22px;
            background: #FFFFFF;
            box-shadow: 0 2px 20px rgba(40, 41, 61, 0.1);
            border-radius: 8px;

            .head-text {
                font-weight: 600;
                font-size: 16px;
                line-height: 26px;
                letter-spacing: 0.2px;
                color: #939AA9;
            }

            .progress {
                border-radius: 100px;
            }

            .status-progress {
                margin: 26px 0 9px 0;
                font-weight: bold;
                font-size: 28px;
                line-height: 121.4%;
                color: #3E4756;
            }
        }
    }

    .conversion-rate-wrapper {
        width: 100%;
        max-width: 248px;
        background: #FFFFFF;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        box-shadow: 0px 19px 51px rgba(8, 35, 48, 0.09);

        .rate {
            font-weight: 400;
            font-size: 16px;
            margin: 31px auto 28px;
            line-height: 20px;
            text-align: center;
            letter-spacing: 0.01em;
            color: #939AA9;

            span {
                color: #00C7A8;
            }
        }
    }

    .conversion-cross-channel-wrapper {
        position: relative;
        width: 100%;
        //max-width: 1116px;
        margin-top: 50px;

        .line {
            width: 0.5px;
            height: 211px;
            background: #191919;
            position: absolute;
            bottom: 75px;
            left: 9%;
        }

        .square {
            position: relative;
            margin: 0 auto;
            height: 28px;
        }

        .trapezoid {
            position: relative;
            margin: 0 auto 17px;
            height: 28px;

            p {
                position: absolute;
                bottom: 0;
                right: 15px;
                font-size: 5px;
                line-height: 6px;
                letter-spacing: 0.01em;
                color: #FFFFFF;
            }

            &:after {
                width: 0;
                height: 0;
                border-bottom: 28px solid white;
                border-left: 14px solid transparent;
                float: right;
                content:"";
            }

            &:before {
                width: 0;
                height: 0;
                border-bottom: 45px solid white;
                border-right: 22px solid transparent;
                float: left;
                content:"";
            }
        }

        .export-btn {
            margin: 20px 0 0 109px;
        }
    }

    .cross-channel-wrapper {
        width: 100%;
        margin-left: 50px;
        //max-width: 828px;
        background: #FFFFFF;
        box-shadow: 0 4px 20px rgba(40, 41, 61, 0.1);
        border-radius: 8px;
    }

    .demographics-wrapper {
        width: 100%;
        margin-top: 35px;

        h2 {
            font-weight: 600;
            font-size: 16px;
            line-height: 26px;
            letter-spacing: 0.2px;
            color: #93A6A9;
            margin-bottom: 21px;
        }

        .table-wrapper {
            width: 100%;
            //max-width: 502px;
            padding: 35px 34px;
            background: #FFFFFF;
            box-shadow: 0 4px 20px rgb(40 41 61 / 10%);
            border-radius: 8px;
            margin-right: 34px;
            table {
                .head-table {
                    background: #E9EAF7;

                    th {
                        font-weight: 600;
                        font-size: 15.5px;
                        line-height: 20px;
                        color: #3E4756;
                    }
                }
            }
        }

        .chart-wrapper {
            width: 100%;
            max-width: 578px;
            padding: 14px 30px;
            background: #FFFFFF;
            box-shadow: 0 4px 20px rgba(40, 41, 61, 0.1);
            border-radius: 8px;
           .chart-wrapper-title{
               margin-top: 16px;
               padding: 0px 0px 0px 20px;
           }
        }
    }
}
</style>

<style lang="scss">
.participants-wrapper {
    .left-days {
        .days-chart {
            position: absolute;
            top: -15px;
            left: 13px;
        }
    }

    .apexcharts-text tspan {
        font-size: 8px;
    }

    .recruitment-progress-wrapper {
        width: 100%;
        //max-width: 724px;

        .progress-chart {

        }
    }
}
.progress-status-number {
    font-weight: 400;
    font-size: 22px;
    line-height: 27px;
    letter-spacing: 0.01em;
    color: #00C7A8;
}
.lable-show {
    font-size: 11px;
}
.select-period{
    font-size: 13px;
}
.recruitment-progress-wrapper .vue-apexcharts.progress-chart{
    background: white;
}
</style>
