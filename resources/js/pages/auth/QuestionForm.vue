<template>
    <div class="main">
        <div class="d-flex">
            <div class="left">
                <auth-header></auth-header>
            </div>

            <div class="right p-4">
                <div v-if="showError">
                    <div v-for="error in errors[0]" class="alert alert-danger" role="alert">
                        <div >{{ error.toString() }}</div>
                    </div>
                </div>
                <div class="registration-form-wrapper">
                    <div class="p-5 n-bg-white registration-form-wrap" v-if="questionList">
                        <h2 class="mb-5 txt-center header-text">Registration Form</h2>
                        <form @submit.prevent="saveForm" class="form_wrapper_body">
                            <div v-for="question in questionList" :key="question.id">
                                <div class="textarea" v-if="question.type.name === 'TEXT_MULTIPLE_ROWS'">
                                    <p class="question">{{ question.question }}</p>
                                    <textarea
                                        class="form-control"
                                        :required="question.is_required"
                                        @change="handleChangeInputs($event, question.id)"
                                        :name="`textarea_${question.id}`"
                                    ></textarea>
                                </div>
                                <div class="checkbox" v-if="question.type.name === 'CHECKBOX'">
                                    <p class="question">{{ question.question }}</p>
                                    <div class="checkbox-group" v-for="checkbox in question.options.split(';')">
                                        <input
                                            class="form-check-input"
                                            :key="checkbox"
                                            @change="handleChangeInputs($event, question.id)"
                                            :required="question.is_required"
                                            type="checkbox"
                                            :name="`checkbox_${question.id}`"
                                            :value="checkbox">
                                        <label>{{ checkbox }}</label>
                                    </div>
                                </div>
                                <div class="text" v-if="question.type.name === 'TEXT'">
                                    <p class="question">{{ question.question }}</p>
                                    <input
                                        class="form-control"
                                        :required="question.is_required"
                                        @change="handleChangeInputs($event, question.id)"
                                        :name="`text_${question.id}`"
                                    >
                                </div>
                                <div class="number" v-if="question.type.name === 'NUMBER'">
                                    <p class="question">{{ question.question }}</p>
                                    <input
                                        class="form-control"
                                        type="number"
                                        :required="question.is_required"
                                        @change="handleChangeInputs($event, question.id)"
                                        :name="`number_${question.id}`"
                                    >
                                </div>
                                <div class="select form-group" v-if="question.type.name === 'DROPDOWN'">
                                    <p class="question">{{ question.question }}</p>
                                    <select class="form-control" :name="`select_${question.id}`" @change="handleChangeInputs($event, question.id)">
                                        <option :value="option" v-for="option in question.options.split(';')" :key="option">{{ option }}</option>
                                    </select>
                                </div>
                                <div class="radio" v-if="question.type.name === 'RADIOBUTTON'">
                                    <p class="question">{{ question.question }}</p>
                                    <div class="d-flex">
                                        <div class="radio-group" v-for="radio in question.options.split(';')">
                                            <input
                                                class="form-check-input"
                                                :key="radio"
                                                @change="handleChangeInputs($event, question.id)"
                                                :required="question.is_required" type="radio"
                                                :name="`radio_${question.id}`" :value="radio"
                                            >
                                            <label>{{ radio }}</label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="form-group mb-1">
                                <button type="submit" class="n-btn n-bg-primary txt-white submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <question-modal v-if="showModal"/>
    </div>
</template>

<script>

import AuthHeader from "./Header";
import { mapActions, mapGetters } from "vuex";
import QuestionModal from "../../components/QuestionModal";

export default {
    name: "Question",
    components: {
        QuestionModal,
        AuthHeader
    },
    data() {
        return {
            form: {
                recruiting: "",
                studyQuestion: "",
                studyDescription: "",
                copyPaste: "",
                studyLink: "",
                studyMinutes: "",
                studyStart: "",
                studyEnd: "",
                participants: "",
                lookingFor: "",
                studyPart: "",
                notes: "",
                questions: ""
            },
            errors: [],
            showError: false,
            showModal: false,
            userLocal: null,
            answers: {},
        };
    },

    async created () {
        await this.getQuestionList()
        await this.getQuestionTypesList()

        const user = JSON.parse(localStorage.getItem('vuex'));

        if (user) {
            this.userLocal = user.id
        }
    },

    computed: {
      ...mapGetters(['questionList', 'questionTypesList', 'user'])
    },

    methods: {
        ...mapActions([ 'getQuestionList', 'getQuestionTypesList', 'setAnswers']),

        handleChangeInputs (e, question_id) {
            this.answers[e.target.name] = {
                name: e.target.name,
                answer: e.target.value,
                user_id: this.user.id,
                question_id
            }
        },

        async saveForm() {
            this.errors = []

            await this.setAnswers({form: this.answers, token: this.user.token})
                .then((res) => {
                    if (res.success) {
                        this.showModal = true
                        // this.$router.push('/')
                    }
                })
                .catch(err => {
                    if (err.response.status === 401) {
                        this.errors.push({user: 'User not found!'})
                    } else {
                        this.errors.push(err.response.data.errors)
                    }

                    this.showError = true
                    setTimeout(() => {
                        this.showError = false
                    }, 3000)
                })
        }
    }
}
</script>

<style lang="scss" scoped>
.registration-form-wrapper {
    .header-text {
        font-weight: 600;
        font-size: 28px;
        line-height: 35px;
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

    .registration-form-wrap {
        border: 1px solid #E0E0E0;
        box-sizing: border-box;
        border-radius: 12px;
    }

    .form_wrapper_body {
        height: 70vh;
        overflow-y: scroll;
        padding-right: 24px;
    }

    .radio-group {
        margin-right: 10px;
    }
}
</style>
