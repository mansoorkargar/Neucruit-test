<template>
    <div class="embed-survey-component">
        <Modal v-model="isShow" :close="closeModal">
            <div class="embed-form" v-if="!isSent">
                <div class="wrapper-loading" v-if="isLoading">
                    <div class="sk-fading-circle">
                        <div class="sk-circle1 sk-circle"></div>
                        <div class="sk-circle2 sk-circle"></div>
                        <div class="sk-circle3 sk-circle"></div>
                        <div class="sk-circle4 sk-circle"></div>
                        <div class="sk-circle5 sk-circle"></div>
                        <div class="sk-circle6 sk-circle"></div>
                        <div class="sk-circle7 sk-circle"></div>
                        <div class="sk-circle8 sk-circle"></div>
                        <div class="sk-circle9 sk-circle"></div>
                        <div class="sk-circle10 sk-circle"></div>
                        <div class="sk-circle11 sk-circle"></div>
                        <div class="sk-circle12 sk-circle"></div>
                    </div>
                </div>

                <div class="alerts" v-if="messages.errors.length > 0">
                    <div class="alert alert-danger" v-if="messages.errors.length > 0">
                        <p v-for="error in messages.errors" v-html="error"></p>
                    </div>
                </div>
                
                <template v-if="ineligible">
                    <center style="padding:20px;"><b>Unfortunately, you're ineligible for this study.</b></center>
                </template>
                <template v-else-if="isStarted && !isEnded">
                    <div v-for="(questionGroup, groupIndex) in questions" class="step" v-show="step == (groupIndex + 1)">
                        <div>Step {{ groupIndex + 1 }} out of {{ questions.length }}</div>
                        <div v-for="(question, questionIndex) in questionGroup">
                            <div style="form-group">
                                <label>{{ question.name }} <span v-if="question.required">*</span></label>
                                
                                <template v-if="question.type == 'TEXT' || question.type == 'ETHNICITY' || question.type == 'ADDRESS'">
                                    <input type="text"
                                        class="form-control"
                                        :name="'question_' + question.id"
                                :placeholder="question.name"
                                        v-model="replies[question.id]"
                                    :required="question.required" />
                                </template>
                                <template v-else-if="question.type == 'TEXT_MULTIPLE_ROWS'">
                                    <textarea
                                        class="form-control"
                                        :name="'question_' + question.id"
                                :placeholder="question.name"
                                        v-model="replies[question.id]"></textarea>
                                </template>
                                <template v-else-if="question.type == 'NUMBER'">
                                    <input type="number"
                                        class="form-control"
                                        :name="'question_' + question.id"
                                :placeholder="question.name"
                                        v-model="replies[question.id]"
                                    :required="question.required" />
                                </template>
                                <template v-else-if="question.type == 'DATE' || question.type == 'BIRTHDATE'">
                                    <input type="date"
                                        class="form-control"
                                        :name="'question_' + question.id"
                                :placeholder="question.name"
                                        v-model="replies[question.id]"
                                    :required="question.required" />
                                </template>
                                <template v-else-if="question.type == 'EMAIL'">
                                    <input type="email"
                                        class="form-control"
                                        :name="'question_' + question.id"
                                :placeholder="question.name"
                                        v-model="replies[question.id]"
                                    :required="question.required" />
                                </template>
                                <template v-else-if="question.type == 'DROPDOWN'">
                                    <select
                                        class="form-control"
                                        :name="'question_' + question.id"
                                        v-model="replies[question.id]"
                                    :required="question.required">
                                        <option v-for="(option, optionIndex) in question.options" :value="option">{{ option }}</option>
                                    </select>
                                </template>
                                <template v-else-if="question.type == 'GENDER'">
                                    <select
                                        class="form-control"
                                        :name="'question_' + question.id"
                                        v-model="replies[question.id]"
                                    :required="question.required">
                                        <option value="1">MALE</option>
                                        <option value="2">FEMALE</option>
                                        <option value="3">OTHER</option>
                                    </select>
                                </template>
                                <template v-else-if="question.type == 'CHECKBOX'">
                                    <label class="checkbox-option" v-for="(option, optionIndex) in question.options">
                                        <input type="checkbox"
                                            class="form-control"
                                            :name="'question_' + question.id"
                                           :value="option"
                                          v-model="replies[question.id][optionIndex]"
                                        :required="question.required"> {{ option }}
                                    </label>
                                </template>
                                <template v-else-if="question.type == 'RADIOBUTTON'">
                                    <label class="radio-option" v-for="(option, optionIndex) in question.options">
                                        <input type="radio"
                                            class="form-control"
                                            :name="'question_' + question.id"
                                           :value="option"
                                          v-model="replies[question.id]"
                                        :required="question.required"> {{ option }}
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="buttons">
                        <button type="button" :disabled="step == 1" @click="prev()">
                            Prev
                        </button>

                        <button type="button" :disabled="nextDisabled" @click="next()">
                            <template v-if="step < questions.length">Next</template>
                            <template v-else>Submit</template>
                        </button>
                    </div>
                </template>
                <template v-else-if="isStarted && isEnded">
                    <center style="padding:20px;"><b>The participants registration has been already closed</b></center>
                </template>
                <template v-else>
                    <center style="padding:20px;"><b>The participants registration hasn't been open yet</b></center>
                </template>
            </div>
            <div class="embed-form" v-else>
                <center style="padding:20px;"><b>The data has been succesfully sent</b></center>
            </div>
        </Modal>
    </div>
</template>

<script>


export default {
    name:  'Embed',
    components: {
    },

    data() {
        return {
            isLoading:   false,
            isShow:      false,
            isSent:      false,
            step:        1,
            ineligible:  false,
            questions:   window.__neucruitSurveyQuestions,
            isStarted:   window.__neucruitSurveyStarted,
            isCompleted: window.__neucruitSurveyCompleted,
            replies:     {},
            messages: {
                timeout: null,
                success: [],
                errors:  [],
            },
        }
    },

    computed: {
        nextDisabled() {
            for (let i in this.questions[this.step - 1]) {
                let id = this.questions[this.step - 1][i].id

                if (this.questions[this.step - 1][i].required) {
                    if (!this.replies[id]) {
                        return true;
                    }
                }
            }

            return false;
        },
    },

    methods: {
        showModal() {
            this.isShow = true
        },

        closeModal() {
            this.isShow = false
        },

        next() {
            let hasIneligibleAnswer = false
            for (let i in this.questions[this.step - 1]) {
                let id = this.questions[this.step - 1][i].id

                if (this.questions[this.step - 1][i].ineligible && this.questions[this.step - 1][i].ineligible.length) {
                    if (this.replies[id]) {
                        for (let j in this.questions[this.step - 1][i].ineligible) {
                            let currentReply = this.replies[id].toLowerCase(),
                                compareWith  = this.questions[this.step - 1][i].ineligible[j].toLowerCase();

                            if (currentReply == compareWith) {
                                hasIneligibleAnswer =  true
                            }
                        }
                    }
                }
            }

            this.ineligible = hasIneligibleAnswer

            if (this.step == this.questions.length) {
                this.submit();
            } else if (this.step < this.questions.length) {
                this.step += 1;
            }
        },

        prev() {
            if (this.step > 1) {
                this.step -= 1;
            }
        },

        submit() {
            let v = this

            v.isLoading = true
            axios.post(window.location.protocol + '//' + window.location.hostname + '/api/study/' + window.__neucruitSurveyStudyId + '/participants', {
                replies: this.replies
            })
            .then(response => {
                if (response.data.id) {
                    this.isSent = true;
                    
                    for (let i in this.questions) {
                        for (let j in this.questions[i]) {
                            if (this.questions[i][j].type == 'CHECKBOX') {
                                this.replies[this.questions[i][j].id] = {}
                                for (let k in this.questions[i][j].options) {
                                    this.replies[this.questions[i][j].id][k] = null;
                                }
                            } else {
                                this.replies[this.questions[i][j].id] = null;
                            }
                        }
                    }
                } else {
                    v.appendErrorAlert(response.data.errors)
                }

                v.isLoading = false
            })
            .catch(error => {
                var errors = []
                for (let i in error.response.data.errors) {
                    for (let j in error.response.data.errors[i]) {
                        errors.push(error.response.data.errors[i][j])
                    }
                }

                v.appendErrorAlert(errors)
                v.isLoading = false
            })
        },

        reset() {
            this.step             = 1

            this.messages.errors  = []
            this.messages.success = []
        },

        appendErrorAlert(messages = [], infinity = false) {
            let v = this

            v.messages.errors = messages

            if (!infinity) {
                clearTimeout(v.messages.timeout)
                    v.messages.timeout = setTimeout(function() {
                    v.messages.errors = []
                }, 7000)
            }
        },

        appendSuccessAlert(messages = [], infinity = false) {
            let v = this

            v.messages.success = messages

            if (!infinity) {
                clearTimeout(v.messages.timeout)
                    v.messages.timeout = setTimeout(function() {
                    v.messages.success = []
                }, 7000)
            }
        },
    },

    created() {
        for (let i in this.questions) {
            for (let j in this.questions[i]) {
                if (this.questions[i][j].type == 'CHECKBOX') {
                    this.replies[this.questions[i][j].id] = {}
                    for (let k in this.questions[i][j].options) {
                        this.replies[this.questions[i][j].id][k] = null;
                    }
                } else {
                    this.replies[this.questions[i][j].id] = null;
                }
            }
        }
    },

    mounted() {
        var items = document.querySelectorAll('input[type="submit"],button[type="submit"],a.neucruit-open-modal,button.neucruit-open-modal'),
            that  = this;

        for (var i in items) {
            if (typeof items[i] == 'object') {
                items[i].addEventListener('click', function() {
                    that.showModal()
                });
            }
        }
    },
}
</script>

<style scoped lang="scss">
.vue-universal-modal {
  /* Change dimmed color */
  background-color: rgba(255, 255, 0, 0.3);
}
.vue-universal-modal-content {
  /* Align to top (flex-direction property value is set to column) */
  justify-content: flex-start;
}

.embed-form {
    width:500px;
    background:#fff;
    border-radius:4px;
    box-shadow:0 4px 4px rgba(0,0,0,.4);
    padding:20px;
    position:relative;

    .info {
        font-weight:700;
        font-size:18px;
        padding-bottom:10px;
        margin-bottom:20px;
        border-bottom:1px solid #efefef;
    }

    .step > div {
        margin-bottom:10px;
    }

    label {
        width:100%;
        font-size:16px;
        font-weight:700;
        display:inline-block;
    }

    input[type="text"], input[type="number"], input[type="email"], input[type="date"], select, textarea {
        line-break:28px;
        height:30px;
        border:1px solid #efefef;
        border-radius:2px;
        width:100%;
    }

    label.checkbox-option, label.radio-option {
        display:inline-block;
        margin-right:15px;
        font-weight:400;
        width:auto;
    }

    textarea {
        height:90px;
    }

    .buttons {
        margin-top:20px;
        padding-top:20px;
        border-top:1px solid #f5f5f5;
    }

    button {
        font-family: Avenir;
        padding-top: 10px;
        padding-right: 30px;
        padding-bottom: 10px;
        padding-left: 30px;
        background-color: rgb(109, 121, 184);
        border-top-left-radius: 3.10915px;
        border-top-right-radius: 3.10915px;
        border-bottom-right-radius: 3.10915px;
        border-bottom-left-radius: 3.10915px;
        font-weight: 800;
        font-size: 10.6469px;
        line-height: 15px;
        color: rgb(255, 255, 255);
        margin-right: 10px;
        font-style: normal;
        border:0;
    }

    button:disabled {
        opacity:0.6;
    }
}

.wrapper-loading {
    position:absolute;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background:rgba(255,255,255.9);
}

.sk-fading-circle {
  margin: -20px 0 0 -20px;
  width: 40px;
  height: 40px;
  position: absolute;
  top:50%;
  left:50%;
}

.sk-fading-circle .sk-circle {
  width: 100%;
  height: 100%;
  position: absolute;
  left: 0;
  top: 0;
}

.sk-fading-circle .sk-circle:before {
  content: '';
  display: block;
  margin: 0 auto;
  width: 15%;
  height: 15%;
  background-color: #748D96;
  border-radius: 100%;
  animation: sk-circleFadeDelay 1.2s infinite ease-in-out both;
}
.sk-fading-circle .sk-circle2 {
          transform: rotate(30deg);
}
.sk-fading-circle .sk-circle3 {
          transform: rotate(60deg);
}
.sk-fading-circle .sk-circle4 {
          transform: rotate(90deg);
}
.sk-fading-circle .sk-circle5 {
          transform: rotate(120deg);
}
.sk-fading-circle .sk-circle6 {
          transform: rotate(150deg);
}
.sk-fading-circle .sk-circle7 {
          transform: rotate(180deg);
}
.sk-fading-circle .sk-circle8 {
          transform: rotate(210deg);
}
.sk-fading-circle .sk-circle9 {
          transform: rotate(240deg);
}
.sk-fading-circle .sk-circle10 {
          transform: rotate(270deg);
}
.sk-fading-circle .sk-circle11 {
          transform: rotate(300deg);
}
.sk-fading-circle .sk-circle12 {
          transform: rotate(330deg);
}
.sk-fading-circle .sk-circle2:before {
  animation-delay: -1.1s;
}
.sk-fading-circle .sk-circle3:before {
  animation-delay: -1s;
}
.sk-fading-circle .sk-circle4:before {
  animation-delay: -0.9s;
}
.sk-fading-circle .sk-circle5:before {
  animation-delay: -0.8s;
}
.sk-fading-circle .sk-circle6:before {
  animation-delay: -0.7s;
}
.sk-fading-circle .sk-circle7:before {
  animation-delay: -0.6s;
}
.sk-fading-circle .sk-circle8:before {
  animation-delay: -0.5s;
}
.sk-fading-circle .sk-circle9:before {
  animation-delay: -0.4s;
}
.sk-fading-circle .sk-circle10:before {
  animation-delay: -0.3s;
}
.sk-fading-circle .sk-circle11:before {
  animation-delay: -0.2s;
}
.sk-fading-circle .sk-circle12:before {
  animation-delay: -0.1s;
}

@-webkit-keyframes sk-circleFadeDelay {
  0%, 39%, 100% { opacity: 0; }
  40% { opacity: 1; }
}

@keyframes sk-circleFadeDelay {
  0%, 39%, 100% { opacity: 0; }
  40% { opacity: 1; }
}

.alerts {
    color: #651818!important;
    border:1px solid #dd6262!important;
    background:#fce3e3;
    border-radius:3px;
    padding:10px;
    font-size:14px;
    margin-bottom:20px;
}

.alerts {
    p {
        margin:0;
        padding:0;
    }
}
</style>