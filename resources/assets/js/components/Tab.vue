<template>
    <div v-show="isActive"><slot></slot></div>
</template>

<script>
    export default{
        props: {
            name: { required: true },
            icon: { required: false },
            selected: { default: false }
        },
        data() {
            return {
                isActive: false
            };
        },
        created() {
            this.isActive = this.selected;
        }
    }
</script>