<template>
    <div :class="`${classes} ${fullPage ? 'full-page' : ''}`">
        <div class="lds-spinner">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            classes: {
                type: String,
                default: 'spinner-container'
            },
            fullPage: {
                type: Boolean,
                default: false
            }
        },

        mounted: function () {
            if (this.fullPage) {
                $('body').css('overflow', 'hidden');
            }
        },

        beforeDestroy: function () {
            if (this.fullPage) {
                $('body').css('overflow', 'unset');
            }
        }
    }

</script>
