<template>
    <div id="secondary_navbar">
        <ul>
            <li>
                <router-link to="/design">
                    <span class="dot txt-center txt-white n-bg-primary-dark" :class="{checkmark: tabs.design.done}">
                        1
                    </span>
                    <span class="name txt-primary-dark">Design</span>
                </router-link>
            </li>
            <li :class="{active: isActiveTab('Outreach'), disbled: tabs.outreach.disbled}">
                <router-link to="/outreach">
                    <span class="dot txt-center txt-white n-bg-primary-dark" :class="{checkmark: tabs.outreach.done}">
                        2
                    </span>
                    <span class="name txt-primary-dark">Outreach</span>
                </router-link>
            </li>
            <li :class="{active: isActiveTab('Manage'), disbled: tabs.manage.disbled}">
                <router-link to="/manage">
                    <span class="dot txt-center txt-white n-bg-primary-dark" :class="{checkmark: tabs.manage.done}">
                        3
                    </span>
                    <span class="name txt-primary-dark">Manage</span>
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'SecondaryNavbar',
    data() {
        let tabs = {
            design: {
                done: true,
                disbled: false
            },
            outreach: {
                done: false,
                disbled: true
            },
            manage: {
                done: false,
                disbled: true
            },
        };

        if (this.$parent.$route.name === 'Design') {
            tabs.design.done = false;
        }

        if (this.$parent.$route.name === 'Outreach') {
            tabs.outreach.disbled = false;
        }

        if (this.$parent.$route.name === 'Manage') {
            tabs.outreach = {
                done: true,
                disbled: false
            };
            tabs.manage.disbled = false;
        }
        return {
            active: '',
            tabs: tabs
        }
    },
    methods: {
        isActiveTab(tabName) {
            return tabName === this.$route.name;
        },
        aasd() {
            console.log(this.tabs);
        }
    }
}
</script>
