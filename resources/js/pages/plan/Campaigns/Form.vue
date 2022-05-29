<template>
    <transition name="fade">
        <div class="popup-modal">
            <div class="window">
                <div class="form_header py-4 px-5">
                    <h4 class="mb-2">New bookmark list</h4>
                    <p>Create a new bookmark list.</p>

                    <button class="close-modal" @click="$parent.closeForm">×</button>
                </div>
                <div class="form_body py-4 px-5">
                    <div class="form-group mb-4">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="name">Name</label>
                            </div>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="name" v-model="form.name"
                                    :class="{'is-invalid': !!this.errors.name}" />
                                <div class="invalid-feedback" v-if="this.errors.name">
                                    <div v-for="(msg, i) in this.errors.name" v-bind:key="i">{{ msg }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="description">Description</label>
                            </div>
                            <div class="col-sm-8">
                                <textarea id="description" class="form-control"
                                    :class="{'is-invalid': !!this.errors.description}"
                                    rows="3" v-model="form.description"></textarea>
                                <div class="invalid-feedback" v-if="this.errors.description">
                                    <div v-for="(msg, i) in this.errors.description" v-bind:key="i">{{ msg }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Type</label>
                            </div>
                            <div class="col-sm-8">
                                <select v-model="form.campaign_type_id" class="form-control"
                                    :class="{'is-invalid': !!this.errors.campaign_type_id}">
                                    <option value="">Choose...</option>
                                    <option v-for="type in types" :value="type.id" :key="type.id">{{ type.name }}</option>
                                </select>
                                <div class="invalid-feedback" v-if="this.errors.campaign_type_id">
                                    <div v-for="(msg, i) in this.errors.campaign_type_id" v-bind:key="i">{{ msg }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Status</label>
                            </div>
                            <div class="col-sm-8">
                                <select v-model="form.status" class="form-control">
                                    <option v-for="(name, key) in statuses" :key="key" :value="key">{{ name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form_footer txt-right">
                    <div class="p-3 d-inline-block">
                        <button class="n-btn n-bg-grd-light txt-white" @click="$parent.closeForm">Close</button>
                    </div>
                    <div class="p-3 d-inline-block">
                        <button class="n-btn n-bg-primary-dark txt-white" @click="submitForm">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>

import CrudApi from '../../../services/CrudApi';

export default {
    props: ['model', 'types', 'statuses'],
    name: 'CampaignForm',
    data() {
        const form = {
            name: '',
            description: '',
            campaign_type_id: '',
            status: 1,
        };

        return {
            form: this.model || form,
            errors: [],
            validateFields: ['name', 'description', 'campaign_type_id']
        }
    },
    methods: {
        async submitForm() {
            if (!this.validateForm()) {
                return false;
            }

            const api = new CrudApi('campaigns');
            try {
                if (this.model) {
                    await api.update(this.model.id, this.model);
                } else {
                    await api.create(this.form);
                }
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }

                return false;
            }

            this.$parent.refreshPage();
            document.querySelector('body').style.overflow = 'initial';
        },
        validateForm() {
            let isValid = true;

            for(const field of this.validateFields) {
                if (!this.form[field]) {
                    isValid = false;
                    this.errors[field] = [`The ${field.replaceAll('_', ' ')} field is required.`];
                }
            }

            return isValid;
        }
    }
}
</script>

<style scoped>
    /* css class for the transition */
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.3s;
    }
    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }

    .popup-modal {
        background-color: rgba(0, 0, 0, 0.5);
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 0.5rem;
        display: flex;
        align-items: center;
        z-index: 9999;
    }

    .window {
        background: #fff;
        border-radius: 5px;
        box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);
        width: 680px;
        max-width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    .form_header, .form_body {
        border-bottom: 1px solid #e8e8e9;
        position: relative;
    }

    .form_header .close-modal {
        position: absolute;
        padding: 1em;
        right: 0;
        top: 0;
        background: #fff;
        font-size: 22px;
        opacity: .5;
    }

    .form_header .close-modal:hover {
        opacity: 1;
    }

    .form_header h4 {
        font-weight: 900;
    }
</style>
