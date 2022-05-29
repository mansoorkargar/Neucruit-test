<template>
    <div class="p-5 page_vontent">
        <div class="page_header">
            <div class="row">
                <div class="col-md-8 mb-2">
                    <h1 class="h2 txt-black">COVID-19 study - Campaigns</h1>
                </div>
                <div class="col-md-4 txt-right mb-2">
                    <button class="n-btn n-bg-primary-dark txt-white" @click="openForm()">Create Campaign</button>
                </div>
            </div>

            <div class="header-banner p-5 mt-4 mb-5">
                <h2>{{ activeCount ? activeCount : 'No' }} Active Campaigns</h2>
            </div>
        </div>

        <div class="page_content">
            <div v-if="showForm">
                <campaign-form ref="modalForm" :types="types" :model="model" :statuses="statuses" />
            </div>

            <div v-if="items.length">
                <data-table :items="items" :cols="cols" :searchable="searchable">
                    <dataset-item tag="tbody">
                        <template #default="{ row }">
                            <tr>
                                <td>{{ row.name }}</td>
                                <td>{{ row.typeName }}</td>
                                <td>
                                    <span v-if="row.statusText" :class="`st-${row.status}`">{{ row.statusText }}</span>
                                </td>
                                <td>{{ row.description }}</td>

                                <td width="15%" class="actions">
                                    <button class="btn">
                                        <img :src="'/images/icons/eye-icon.png'" width="20">
                                    </button>
                                    <button class="btn" @click="openForm(row.id)">
                                        <img :src="'/images/icons/edit-icon.svg'" width="20">
                                    </button>
                                    <button class="btn fl-right" @click="deleteAction(row.id)">
                                        <img :src="'/images/icons/trash.svg'" width="20">
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </dataset-item>
                </data-table>
            </div>
            <div v-else>
                <div class="txt-center">
                    <button class="n-btn n-bg-primary-dark txt-white" @click="openForm()">Create First Campaign</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import CrudApi from '../../../services/CrudApi';
import CampaignForm from './Form';
import DataTable from '../../../components/DataTable';

const api = new CrudApi('campaigns');

export default {
    name: 'Campaigns',
    components: {
        CampaignForm,
        DataTable
    },
    data() {
        return {
            items: [],
            types: [],
            model: null,
            showForm: false,
            activeCount: 0,
            cols: [
                { name: 'Name', field: 'name', sort: ''},
                { name: 'Type', field: 'typeName', sort: '' },
                { name: 'Status', field: 'statusText', sort: ''},
                { name: 'Description', field: 'description', sort: '' },
            ],
            searchable: [
                'name', 'typeName', 'statusText', 'description'
            ],
            statuses: {
                0: 'Pending',
                1: 'Active'
            }
        }
    },
    mounted() {
        this.refreshPage();
    },
    methods: {
        async refreshPage() {
            this.showForm = false;
            this.model = null;
            this.getItmes();
            this.getTypes();
        },
        async getItmes() {
            try {
                const response = await api.all();
                this.activeCount = 0;
                this.items = response.data.data.map((item) => {
                    item.typeName = item.type ? item.type.name : '';
                    if (item.status === 1) {
                        this.activeCount++;
                    }

                    item.statusText = this.getStatus(item.status);

                    return item;
                });
            } catch (error) {
                console.log(error.response);
            }
        },
        async getTypes() {
            const api = new CrudApi('campaign-types');
            try {
                const response = await api.all();
                this.types = response.data.data;
            } catch (error) {
                console.log(error.response);
            }

        },
        async openForm(id) {
            if (id) {
                const response = await api.find(id);
                this.model = response.data.data;
            }
            this.showForm = true;
            document.querySelector('body').style.overflow = 'hidden';
        },
        async deleteAction(id) {
            if (confirm('Want to delete?') === true) {
                try {
                    await api.delete(id);
                    this.refreshPage();
                } catch(error) {
                    alert('Failed to delete item');
                }
            }
        },
        closeForm() {
            this.showForm = false;
            this.model = null,
            document.querySelector('body').style.overflow = 'initial';
        },
        getStatus(index) {
            if (this.statuses[index]) {
                return this.statuses[index];
            }

            return '';
        }
    }
}
</script>

<style scoped>
    .header-banner {
        background: linear-gradient(99.34deg, #00C7A8 3.88%, #75C1AA 99.4%);
        border-radius: 12px;
    }
    .header-banner h2 {
        color: #fff;
        font-weight: 900;
        font-size: 22px;
    }
    .st-0 {
        color: #6D79B8;
        border: 1px solid #6D79B8;
        border-radius: 4px;
        padding: 5px 10px;
    }
    .st-1 {
        color: #00C7A8;
        border: 1px solid #00C7A8;
        border-radius: 4px;
        padding: 5px 10px;
    }

    .actions {
        min-width: 160px;
    }

    .page_vontent {
        max-height: calc(100vh - 72px);
        overflow: auto;
    }
</style>
