<template>
    <div class="dashboard_container">
        <div class="container">
            <div class="get_start_section">
                <div>
                </div>
            </div>
            <div class="tutorial_section d-flex">
                <div class="video">
                    <img :src="'/images/icons/video.svg'" class="manage_icon" alt="manage">
                </div>
                <div class="tutorial_info_section">
                    <p>Neucruit tutorial: How to get started</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Home',
    data() {
        return {
            user: null
        }
    }
}
</script>
