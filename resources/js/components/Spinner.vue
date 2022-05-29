<template>
  <div class="spinner-wrapper">
    <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
  </div>
</template>

<script>

export default {
    name: 'Spinner',
    props: [],
    data () {
        return {
        }
    },
    computed: {
    },
    methods: {
    }
}
</script>

<style lang="scss" scoped>
.spinner-wrapper {
  position: absolute;
  top:0;
  left:0;
  right:0;
  bottom:0;
  background:#fff;
  opacity:.95;
  z-index: 1001;
}
.lds-ring {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
  top:50%;
  left:50%;
  margin-left:-40px;
  margin-top:-40px;
}
.lds-ring div {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 64px;
  height: 64px;
  margin: 8px;
  border: 8px solid #6d7ab7;
  border-radius: 50%;
  animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #6d7ab7 transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
  animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
  animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
  animation-delay: -0.15s;
}
@keyframes lds-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
