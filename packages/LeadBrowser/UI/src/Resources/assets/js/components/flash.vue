<template>
    <div :class="'alert alert-' + flash.type" role="alert">
        <div class="d-flex">
            <div class="flex-shrink-0" v-if="icons[flash.type]">
                <i :class="'bi-' + icons[flash.type]"></i>
            </div>
            <div class="flex-grow-1 ms-2">
                {{ flash.message }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" @click="remove"></button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['flash'],

        data: function() {
            return {
                icons: {
                    'success': 'check-circle',
                    'warning': 'exclamation-circle',
                    'error': 'bug',
                    'info': 'info-circle',
                }
            }
        },

        created: function() {
            var self = this;
            
            setTimeout(function() {
                self.$emit('onRemoveFlash', self.flash);
            }, 5000);
        },

        methods: {
            remove: function() {
                this.$emit('onRemoveFlash', this.flash);
            }
        }
    }
</script>