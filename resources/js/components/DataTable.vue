<template>
    <dataset
        v-slot="{ ds }"
        :ds-data="items"
        :ds-search-in="searchable"
        :ds-sortby="sortBy"
    >

        <div class="tbl_header">
            <div class="txt-right">
                <dataset-search class="search d-inline-block" ds-search-placeholder="Search" />
            </div>
        </div>

        <div class="tbl_body">
            <table class="table d-table txt-black">
                <thead>
                    <tr>
                        <th v-for="(th, index) in cols" :key="th.field" :class="['sort', th.sort]">
                            {{ th.name }} <span class="gg-select" @click="sort($event, index)"></span>
                        </th>
                    </tr>
                </thead>
            
                <slot></slot>
            </table>
        </div>

        <div class="tbl_footer">
            <div class="row">
                <div class="col-4">
                    <select class="per-page form-control" v-model="perPage" @change="ds.showEntries(perPage)">
                        <option v-for="entire in pageEntires" :key="entire">{{ entire }}</option>
                    </select>
                </div>
                <div class="col-8">
                    <div class="txt-right">
                        <ul class="pagination d-inline-flex">
                            <li v-for="(item, index) in ds.dsPages" :key="index" :class="['page-item', item === ds.dsPage && 'active']">
                                <a class="page-link" href="#" @click.prevent="ds.setActive(item)">
                                    {{ item }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </dataset>
</template>

<script>

export default {
    name: 'DataTable',
    props: ['items', 'cols', 'searchable', 'showActions'],
    data () {
        return {
            perPage: 10,
            pageEntires: [10, 25, 30, 50]
        }
    },
    computed: {
        sortBy() {
            return this.cols.reduce((acc, o) => {
                if (o.sort) {
                    o.sort === 'asc' ? acc.push(o.field) : acc.push('-' + o.field)
                }

                return acc
            }, [])
        }
    },
    methods: {
        sort(event, i) {
            let toset
            const sortEl = this.cols[i]
            if (!event.shiftKey) {
                this.cols.forEach((o) => {
                if (o.field !== sortEl.field) {
                    o.sort = ''
                }
                })
            }
            if (!sortEl.sort) {
                toset = 'asc'
            }
            if (sortEl.sort === 'desc') {
                toset = event.shiftKey ? '' : 'asc'
            }
            if (sortEl.sort === 'asc') {
                toset = 'desc'
            }
            sortEl.sort = toset
        }
    }
}
</script>
