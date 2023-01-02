<template>
    <div class="card zi-2 aos-init aos-animate" data-aos="fade-up">
        <div class="card-body">
            <div class="text-center mb-5">
                <div class="btn-group btn-group-segment" role="group" aria-label="Pricing radio button group">
                    
                    <input
                        type="radio"
                        class="btn-check"
                        name="btnradio"
                        id="btnradio1"
                        :check="checkValue('search')"
                    >
                    
                    <label
                        @click="active = 'search'"
                        class="btn btn-sm"
                        for="btnradio1"
                    >
                    Search data
                    </label>

                    <input
                        type="radio"
                        class="btn-check"
                        name="btnradio"
                        id="btnradio2"
                        :check="checkValue('analyze')"
                    >

                    <label
                        @click="active = 'analyze'"
                        class="btn btn-sm"
                        for="btnradio2"
                    >
                    Analyze data
                    </label>
                </div>
            </div>
            <!-- End Radio Button Group -->

            <!-- Media -->
            <div class="d-flex align-items-end">
                <div class="flex-grow-0 ms-3" v-if="active === 'search'">
                    <span class="text-dark">
                        <span class="fs-5 align-top text-dark fw-semi-bold">$</span>
                        <span class="display-3 text-dark fw-semi-bold">0,029</span>
                        <span>per one data pack*</span>
                    </span>
                </div>
                <div class="flex-grow-0 ms-3" v-if="active === 'analyze'">
                    <span class="text-dark">
                        <span class="fs-5 align-top text-dark fw-semi-bold">$</span>
                        <span class="display-3 text-dark fw-semi-bold">0,000</span>
                        <span>per one record</span>
                    </span>
                </div>
            </div>
            <!-- End Media -->

            <hr class="my-4">

            <div class="mb-5">
                <p>You only pay for use, and all other functionalities on the platform are completely
                    free.</p>
            </div>

            <div class="d-grid">
                <a class="btn btn-primary btn-transition" href="/register">Get started</a>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            active: 'search'
        }
    },
    methods: {
        checkValue(value) {
            return this.active === value
        }
    }
}
</script>
