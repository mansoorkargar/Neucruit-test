<template>
    <div class="modal-backdrop">
        <div id="modal" class="modal-wrapper">
            <img src="/images/check-img.png" alt="">
            <div>
                <h2>We’ve received your registration form!</h2>
                <p class="message">Hold tight, your study page will be generated soon. We
                    will send you an email once set-up has complete</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'question-modal'
}
</script>

<style lang="scss" scoped>
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
    display: flex;
    align-items: flex-start;
    padding: 35px;
    background-color: white;
    border: 1px solid #DEE2E6;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.12), 0 20px 20px rgba(0, 0, 0, 0.08);
    border-radius: 8px;
    position: fixed;
    transform: translate(-50%, -50%);
    top: 50%;
    left: 50%;
    z-index: 999999;

    h2 {
        font-weight: 600;
        font-size: 20px;
        line-height: 25px;
    }

    .message {
        font-size: 14px;
        line-height: 22px;
        color: rgba(84, 89, 94, 0.6);
    }

    img {
        width: 56px;
        margin-right: 24px;
    }
}
</style>
