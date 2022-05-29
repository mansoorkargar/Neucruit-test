<template>
    <div class="edit-wrapper">
        <div class="header d-flex justify-content-between">
            <div>
                <div class="first-text">{{ this.template_name }}</div>
                <div class="second-text mt-1">{{ this.design_structure }}</div>
            </div>
            <div class="d-flex align-items-center mt-3">
                <router-link to="/communications" class="btn back-btn">Cancel changes</router-link>
                <button @click="save" type="button" class="btn save-btn">Save changes</button>
            </div>
        </div>
        <div class="alert alert-danger mt-4" v-if="showError" v-html="errorMessage"></div>

        <div class="form-wrapper mt-4">
            <div class="form-group mb-4">
                <label for="template_name" class="label mb-1">Template name</label>
                <input class="form-control" type="text" name="template_name" id="template_name" v-model="template_name">
            </div>
            <div class="form-group mb-4">
                <label for="email_subject" class="label mb-1">Email subject</label>
                <input class="form-control" type="text" name="email_subject" id="email_subject" v-model="email_subject">
            </div>

            <div class="form-group mb-4">
                <label for="template_name" class="label mb-1">Content</label>
                <quill-editor
                    class="n-bg-white"
                    theme="snow"
                    toolbar="full"
                    ref="quill"
                    v-model:content="content"
                    :content.sync="content"
                    contentType="html"
                />
            </div>

            <div class="form-group mb-4">
                <div class="label mb-1">Logo</div>
                <label for="upload-photo" class="file-wrapper w-100 mb-1">
                    <div class="dashed-border d-flex align-items-center">
                        <div class="d-flex flex-grow-1 justify-content-center">
                            <img src="/images/icons/save-icon.svg" alt="">
                            <div class="text">Drag or paste file here</div>
                        </div>
                        <div class="d-flex upload-btn">
                            <img src="/images/icons/upload-icon.svg" alt="">
                            <div class="upload-text">Upload</div>
                        </div>
                    </div>
                </label>
                <div class="input-wrapper">
                    <input @change="selectFile($event)" class="form-control" type="file" name="file" id="upload-photo">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { QuillEditor } from '@vueup/vue-quill'
import { mapActions, mapGetters } from 'vuex';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    name: 'Communication-edit',

    data: () => ({
        template_name: '',
        email_subject: '',
        design_structure: '',
        file: '',
        content: '',
        communicationId: '',
        showError: false,
        errorMessage: ''
    }),

    components: { QuillEditor },

    async created () {
        await this.getCommunication({
            id: this.study.id,
            communication_id: this.$route.params.id
        });

        this.template_name = this.communication.template_name;
        this.email_subject = this.communication.email_subject;
        this.design_structure = this.communication.design_structure;
        this.content = this.communication.content;
        this.$refs.quill.setHTML( this.content )
    },

    computed: {
        ...mapGetters(['study', 'communication'])
    },

    methods: {
        ...mapActions(['editCommunications', 'getCommunication']),
        async save () {
            const fd = new FormData();
            fd.append( 'template_name', this.template_name );
            fd.append( 'email_subject', this.email_subject );
            fd.append( 'file', this.file );
            fd.append( 'content', this.content );

            await this.editCommunications( {data: fd, id: this.study.id, communication_id: this.$route.params.id} )
                .then(res => {
                    if (res.data.id) {
                        this.$router.push({ name: 'Communications' });
                    }
                })
                .catch(err => {
                    this.showError = true
                    this.errorMessage = '<b>' + err.response.data.message + '</b><br>';

                    for (let field of Object.values(err.response.data.errors)) {
                        for (let message in field) {
                            this.errorMessage += field[message] + '<br>';
                        }
                    }

                    setTimeout(() => {
                        this.showError = false
                    }, 3000)
                })
        },

        selectFile ( event ) {
            this.file = event.target.files[0]
        }
    }
}
</script>

<style lang="scss" scoped>
.edit-wrapper {
    padding:25px;

    .header {
        padding: 32px;
        background: #FFFFFF;
        box-shadow: 0 0 5.73057px rgba(0, 0, 0, 0.08);
        border-radius: 4.91192px;

        .first-text {
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

    .form-wrapper {
        background: #FFFFFF;
        border-radius: 12px;
        padding: 51px 31px;

        .label {
            font-weight: 600;
            font-size: 14px;
            line-height: 17px;
            color: #343F44;
        }

        .form-control {
            padding: 15px 16px;
            background: #FFFFFF;
            border: 1px solid #AEB2B4;
            box-sizing: border-box;
            border-radius: 10px;
        }

        .input-wrapper {
            display: none;
        }

        .file-wrapper {
            border: 1px solid #AEB2B4;
            box-sizing: border-box;
            border-radius: 10px;
            background: #fff;

            .dashed-border {
                cursor: pointer;
                background: #FFFFFF;
                border: 1px dashed #CAD1DC;
                box-sizing: border-box;
                justify-content: flex-end;
                margin: 12px 17px;
                padding: 20px;

                .text {
                    margin-left: 6px;
                    font-weight: 400;
                    font-size: 13px;
                    line-height: 17px;
                    color: #515E72;
                }

                .upload-btn {
                    background: #FFFFFF;
                    border: 1px solid #CAD1DC;
                    box-sizing: border-box;
                    border-radius: 3px;
                    padding: 7px;
                }
            }

            .form-control {
                margin: 12px 20px;
                border: 1px dashed #CAD1DC;
            }
        }
    }

    .back-btn {
        padding: 14px 23px;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        text-align: center;
        color: #6D79B8;
        margin-right: 15px;
        border: 1px solid #6D79B8;
        border-radius: 10px;
    }

    .save-btn {
        padding: 14px 23px;
        background: #6D79B8;
        border-radius: 10px;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        text-align: center;
        color: #FFFFFF;
    }
}
</style>

<style lang="scss">
.right_container .head{
    height: 86px;
}
.trial_name{
    margin-left: 25px;
    margin-top: 39px;
    margin-bottom: 19px;
}
.buttons{
    padding-left: 130px;
}
.edit-wrapper {

    .ql-toolbar.ql-snow {
        background: #F6F7FA;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        border: 1px solid #AEB2B4;
        border-bottom: none;
    }

    .ql-toolbar.ql-snow + .ql-container.ql-snow {
        border-radius: 0 0 10px 10px;
        border-top: unset;
        border: 1px solid #AEB2B4;
    }

}
</style>
