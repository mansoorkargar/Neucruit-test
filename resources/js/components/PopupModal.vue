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

export default {
    name: 'PopupModal',
    props: ['keepOpen'],
    data: () => ({
        isVisible: false
    }),
    methods: {
        open() {
            this.isVisible = true;
        },

        close() {
            this.isVisible = false;
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
        width: 480px;
        max-width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    .base_modal,
    .base_modal__header,
    .base_modal__body {
        position: relative;
        padding: 1em;
    }

    .base_modal__header {
        padding:0;
    }

    .close-modal {
        position: absolute;
        padding: 10px;
        right: 0;
        top: -10px;
        font-size: 22px;
        opacity: .5;
        cursor: pointer;
        z-index:100;
    }

    .close-modal:hover {
        opacity: 1;
    }
</style>
