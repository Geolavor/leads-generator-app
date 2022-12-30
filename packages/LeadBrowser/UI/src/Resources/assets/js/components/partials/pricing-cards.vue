<template>
    <div>
        <div class="d-flex justify-content-center mb-5">
            <div class="form-check form-switch form-switch-between" @click="toggleActive">
                <label class="form-check-label">Monthly</label>
                <input class="form-check-input" type="checkbox" v-model="active">
                <label class="form-check-label form-switch-promotion">
                    Annually
                    <span class="form-switch-promotion-container">
                        <span class="form-switch-promotion-body">
                            <svg class="form-switch-promotion-arrow" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                viewBox="0 0 99.3 57" width="48">
                                <path fill="none" stroke="#bdc5d1" stroke-width="4" stroke-linecap="round"
                                    stroke-miterlimit="10" d="M2,39.5l7.7,14.8c0.4,0.7,1.3,0.9,2,0.4L27.9,42"></path>
                                <path fill="none" stroke="#bdc5d1" stroke-width="4" stroke-linecap="round"
                                    stroke-miterlimit="10" d="M11,54.3c0,0,10.3-65.2,86.3-50"></path>
                            </svg>
                            <span class="form-switch-promotion-text">
                                <span class="badge bg-primary rounded-pill ms-1">Save up to 30%</span>
                            </span>
                        </span>
                    </span>
                </label>
            </div>
        </div>
        <div class="row mb-3">
            
            <div class="col-md mb-3">
                <div class="card card-lg form-check form-check-select-stretched h-100 zi-1">
                    <div class="card-header text-center">
                        <span class="card-subtitle">Free</span>
                        <h2 class="card-title display-3 text-dark">$0</h2>
                        <p class="card-text">Free plan</p>
                    </div>

                    <div class="card-body d-flex justify-content-center">
                        <!-- List Checked -->
                        <ul class="list-checked list-checked-primary mb-0">
                            <li class="list-checked-item">Free search by websites</li>
                            <li class="list-checked-item">Unlimited verifications</li>
                            <li class="list-checked-item">Free website verification</li>
                            <li class="list-checked-item">Free e-mail verification</li>
                            <li class="list-checked-item">CRM functionality</li>
                        </ul>
                        <!-- End List Checked -->
                    </div>

                    <div class="card-footer border-0 text-center pt-0" v-if="!isUser">
                        <div class="d-grid mb-2">
                            <a type="button" :href="'/register'"
                                class="form-check-select-stretched-btn btn btn-primary btn-transition w-100">Select plan</a>
                        </div>
                        <p class="card-text small">
                            <i class="bi-question-circle me-1"></i> Terms &amp; conditions apply
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md mb-3" v-for="(plan, index) in getCollection" :key="index">
                <div class="card card-lg form-check form-check-select-stretched h-100 zi-1">
                    <div class="card-header text-center">
                        <span class="card-subtitle">{{ plan.name }}</span>
                        <h2 class="card-title display-3 text-dark">${{ plan.price }}</h2>
                        <p class="card-text">{{ plan.description }}</p>
                    </div>

                    <div class="card-body d-flex justify-content-center">
                        <!-- List Checked -->
                        <ul class="list-checked list-checked-primary mb-0">
                            <li class="list-checked-item"><b>{{ plan.value }} coins</b></li>
                            <li class="list-checked-item">Free search by websites</li>
                            <li class="list-checked-item">Unlimited verifications</li>
                            <li class="list-checked-item">Free website verification</li>
                            <li class="list-checked-item">Free e-mail verification</li>
                            <li class="list-checked-item">CRM functionality</li>
                        </ul>
                        <!-- End List Checked -->
                    </div>

                    <div class="card-footer border-0 text-center pt-0">
                        <div class="d-grid mb-2">
                            <a type="button" :href="'/plan/' + plan.slug"
                                class="form-check-select-stretched-btn btn btn-primary btn-transition w-100">Select plan</a>
                        </div>
                        <p class="card-text small">
                            <i class="bi-question-circle me-1"></i> Terms &amp; conditions apply
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
export default {
    props: {
        collection: {
            type: Array,
            default: []
        },
        is_user: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            active: false
        }
    },
    computed: {
        getCollection() {
            return this.collection
            // return this.collection.filter(x => x.is_monthly === (this.active ? 1 : 0));
        },
        isUser() {
            return this.is_user
        }
    },
    methods: {
        toggleActive() {
            this.active = !this.active
        },
        checkValue(value) {
            return this.active === value
        }
    }
}
</script>
