<template>
    <div class="communication-wrapper">
        <div class="header">
            <div class="first-text">Email Templates</div>
            <div class="second-text mt-1">Enabled email templates will be sent to participants once statuses are changed.</div>
        </div>

        <div class="wrapper">
            <div class="d-flex flex-wrap mt-3">
                <div class="communication" v-for="communication in communications" :key="communication.id">
                    <div class="d-flex align-items-center">
                        <label :for="`checkbox-${communication.id}`" class="checkbox-ios">
                            <input class="apple-switch"
                                   type="checkbox"
                                   @change="handleChange(communication.id, communication.enabled)"
                                   :true-value="1"
                                   :false-value="0"
                                   :id='`checkbox-${communication.id}`'
                                   v-model="communication.enabled">
                            <span class="checkbox-ios-switch"></span>
                        </label>
                        <div class="enabled-text">{{ communication.enabled ? 'Enabled' : 'Disabled' }}</div>
                    </div>
                    <div class="content mt-2" v-if="communication.content">
                        <div v-html="communication.content"></div>
                    </div>
                    <div class="description">
                        <div class="email-subject">{{ communication.email_subject }}</div>
                        <div class="template-name">{{ communication.template_name }}</div>
                    </div>
                    <div class="actions d-flex justify-content-between">
                        <button @click="openModal(communication)" class="preview">Preview</button>
                        <router-link :to="`/edit/${communication.id}`" class="edit">Edit template</router-link>
                    </div>
                </div>
            </div>
        </div>

        <popup-modal ref="popup">
            <div class="popup-wrapper h3">
                <div class="content" v-html="selectedCommunication.content"></div>
                <hr>
                <div class="actions">
                    <router-link :to="`/edit/${selectedCommunication.id}`" class="edit">Edit template</router-link>
                </div>
            </div>
        </popup-modal>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import PopupModal from "../../../components/PopupModal";

export default {
    name: 'Communications',
    components: { PopupModal },

    data: () => ({
        selectedCommunication: null,
    }),

    async created () {
        await this.getCommunications(this.study);
    },
    
    computed: {
        ...mapGetters(['study', 'communications']),
    },

    methods: {
        ...mapActions(['getCommunications', 'editEnabled']),

        openModal(communication) {
            this.selectedCommunication = communication
            this.$refs.popup.open()
        },

        handleChange (id, data) {
            this.editEnabled({id: this.study.id, communication_id: id, data: {enabled: data}})
            //this.getCommunications(this.study)
        }
    }
}
</script>

<style lang="scss" scoped>

.right_container .head {
        height: 88px !important;
}

.communication-wrapper {
    margin: 25px;

    .header {
        padding: 31px 46px 35px 33px;
        background: #FFFFFF;
        box-shadow: 0 0 5.73057px rgba(0, 0, 0, 0.08);
        border-radius: 5px;

        .first-text {
            margin-bottom: 13px;
            font-weight: 400;
            font-size: 22px;
            line-height: 27px;
            letter-spacing: 0.01em;
            color: #3E4756;
        }

        .second-text {
            font-weight: 400;
            font-size: 16px;
            line-height: 20px;
            letter-spacing: 0.01em;
            color: #3E4756;
        }
    }

    .wrapper {
        margin-top: 31px;
        padding: 17px 32px;
        background: #FFFFFF;
        border-radius: 5px;
        box-shadow: 0 0 5.73057px rgba(0, 0, 0, 0.08);
    }

    .enabled-text {
        font-weight: 700;
        font-size: 12px;
        line-height: 15px;
        letter-spacing: 0.01em;
        color: #343F44;
    }

    .communication-content {
        padding: 38px 32px 0;
        border-radius: 12px;
    }

    .enabled {
        margin-left: 8px;
        font-weight: 700;
        font-size: 12px;
        line-height: 15px;
        letter-spacing: 0.01em;
        color: #343F44;
    }
    .trial_name{
        margin-left: 29px;
        margin-top: 7px;
        margin-bottom: 28px;
    }
    .communication {
        position: relative;
        width: 340px;
        margin: 0 25px 38px 0;
        padding: 10px 14px 24px 14px;
        background: #fff;
        border: 1px solid #D6D9DA;
        box-sizing: border-box;
        border-radius: 6px;
        min-height: 396px;
        .content {
            background: #F6F7FA;
            border-radius: 13.2902px;
            padding: 12px 74px 0;
            height: 165px;
            overflow:hidden;
        }

        .description {
            margin: 16px 0 70px;

            .email-subject {
                font-weight: 400;
                font-size: 22px;
                line-height: 27px;
                letter-spacing: 0.01em;
                color: #343F44;
                margin: 16px 0 6px;
            }

            .template-name {
                margin-top: 6px;
                font-weight: 700;
                font-size: 12px;
                line-height: 15px;
                letter-spacing: 0.01em;
                color: #343F44;
            }
        }

        .checkbox-ios {
            display: inline-block;
            height: 28px;
            line-height: 28px;
            margin-right: 10px;
            position: relative;
            vertical-align: middle;
            font-size: 14px;
            user-select: none;
        }
        .checkbox-ios .checkbox-ios-switch {
            position: relative;
            display: inline-block;
            box-sizing: border-box;
            width: 48px;
            height: 24px;
            border: 1px solid rgba(0, 0, 0, .1);
            border-radius: 25%/50%;
            vertical-align: top;
            background: #eee;
            transition: .2s;
        }
        .checkbox-ios .checkbox-ios-switch:before {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            display: inline-block;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: white;
            box-shadow: 0 3px 5px rgba(0, 0, 0, .3);
            transition: .15s;
        }
        .checkbox-ios input[type=checkbox] {
            display: block;
            width: 0;
            height: 0;
            position: absolute;
            z-index: -1;
            opacity: 0;
        }
        .checkbox-ios input[type=checkbox]:not(:disabled):active + .checkbox-ios-switch:before {
            box-shadow: inset 0 0 2px rgba(0, 0, 0, .3);
        }
        .checkbox-ios input[type=checkbox]:checked + .checkbox-ios-switch {
            background: #6D79B8;
        }
        .checkbox-ios input[type=checkbox]:checked + .checkbox-ios-switch:before {
            transform:translateX(25px);
        }

        /* Hover */
        .checkbox-ios input[type="checkbox"]:not(:disabled) + .checkbox-ios-switch {
            cursor: pointer;
            border-color: rgba(0, 0, 0, .3);
        }

        /* Disabled */
        .checkbox-ios input[type=checkbox]:disabled + .checkbox-ios-switch {
            filter: grayscale(70%);
            border-color: rgba(0, 0, 0, .1);
        }
        .checkbox-ios input[type=checkbox]:disabled + .checkbox-ios-switch:before {
            background: #eee;
        }

        /* Focus */
        .checkbox-ios.focused .checkbox-ios-switch:before {
            box-shadow: inset 0px 0px 4px #ff5623;
        }
    }

    .actions {
        position: absolute;
        bottom: 22px;

        .preview {
            background: unset;
            font-weight: 600;
            font-size: 14px;
            line-height: 17px;
            color: #6D79B8;
            padding: 0px 46px;
            display: inline-block;
        }

        .edit {
            margin-left: 12px;
            padding: 14px 30px;
            background: #6D79B8;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            line-height: 20px;
            text-align: center;
            color: #FFFFFF;

        }
    }

    .head-text-main {
        padding: 10px 0 20px;
        font-size: 25px;
        color: rgb(103, 101, 102);
    }

    .base_modal__body {
        .actions {
            margin-top: 33px;
            position: unset;
            text-align: right;

            .edit {
                margin-left: unset;
            }
        }
    }
}
</style>

<style lang="scss">
.communication-wrapper {
    .window {
        border-radius: 30px;
    }

    .close-modal {
        font-size: 34px;
        top: -20px;
    }
}

.communication {
    .content {
        p {
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }
    }
}

.content {
    img {
        width: 100%;
        margin-bottom: 15px;
    }

}
.pagination {
    justify-content: end;
    .page-link {
        cursor: pointer;
        color: grey;
    }

    .page-item {
        button {
            border-radius: unset;
        }
    }
}

.maintbl tr:nth-child(even) {
    background-color: #f1f1f1;
}
.maintbl tr:nth-child(odd) {
    background-color: #fff;
}

.headerSortUp {
    background: url("data:image/gif;base64, R0lGODlhFQAJAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAkAAAIXjI+AywnaYnhUMoqt3gZXPmVg94yJVQAAOw==") no-repeat 99%;
}
.headerSortDown {
    background: url("data:image/gif; base64, R0lGODlhFQAEAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAQAAAINjI8Bya2wnINUMopZAQA7") no-repeat 99%;
}
table thead tr {
    background-repeat: no-repeat;
    background-position: center right;
    cursor: pointer;
}

table thead tr th {
    font-weight: bold;
    padding: 20px;
}

.table > :not(:first-child) {
    border-top: unset;
}
</style>