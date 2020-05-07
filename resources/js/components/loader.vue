<template>
    <div class="position-absolute h-100 w-100 overlay d-flex align-items-center justify-content-center flex-column">
        <span class="spinner-border spinner-border-lg text-primary"></span>
        <strong class="my-3 text-dark">{{text}}</strong>
    </div>
</template>

<script>
    export default {
        name: 'loader',
        props: {
            text: {
                type: String,
            },
        }
    }
</script>

<style lang="css" scoped>
    .overlay {
        z-index: 99;
        left: 0;
        top: 0;
        background-color: rgba(255, 255, 255, .95);
    }
    .spinner-border-lg {
        width:2.5rem;
        height: 2.5rem;
    }
</style>
