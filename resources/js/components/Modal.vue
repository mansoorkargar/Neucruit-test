<template>
    <transition name="fade">
        <div class="popup-modal" v-if="isVisible">
            <div class="window">
                <div class="base_modal">
                    <div class="base_modal__header">
                        <span v-if="!keepOpen" class="close-modal" @click="close()">×</span>
                    </div>
                    <div class="base_modal__body">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'modal',
    props: ['selectedCommunication', 'showModal'],
    data() {
        return  {
            showModal: true
        }
    },

    async created () {
        console.log(this.selectedCommunication, 'selectedCommunication')
    },
    computed: {
        ...mapGetters( [ 'communication' ] )
    },

    methods:{
        ...mapActions( [ 'getCommunication' ] ),
    }
}
</script>

<style lang="scss" scoped>
.closeIcon {
    width: 100%;
    display: flex;
    justify-content: end;
    align-items: center;
    margin-bottom: 18px;
}
.closeIcon img {
    width: 20px;
    cursor:pointer
}
.modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal-wrapper {
    width: 100%;
    max-width: 562px;
    padding: 35px;
    background-color: white;
    border: 1px solid #DEE2E6;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.12), 0 20px 20px rgba(0, 0, 0, 0.08);
    border-radius: 30px;
    position: fixed;
    transform: translate(-50%, -50%);
    top: 50%;
    left: 50%;
    z-index: 999999;
}
</style>

<style lang="scss">
.modal-wrapper {
    img {
        width: 100% ;
    }
}
</style>
