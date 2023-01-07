<template>
    <div>
        <modal id="welcomeModelId" :is-open="isOpen && welcomeModal">   
            <div slot="header-title">
                <h5>Welcome!</h5>
            </div>
            <div slot="body">
                <div class="text-center">
                    <div class="w-75 w-sm-50 mx-auto mb-4">
                        <img class="img-fluid" src="/vendor/leadBrowser/admin/assets/images/welcome-illustration.svg" alt="Welcome!"/>
                    </div>

                    <h4 class="h1">Welcome to LeadBrowser</h4>
                    <p>Go ahead and search and take advantage of analyzing your own data for free. But before that, tell us something about yourself.</p>

                    <div v-if="false">
                        <div class="col-12 mb-3">
                            <span>Company</span>
                            <contact-component></contact-component>
                        </div>

                        <div class="col-12 mb-3">
                            <span>Phone number</span>
                            <input class="form-control" type="number" plceholder="+48 27294932"></input>
                        </div>

                        <div class="col-12 mb-3">
                            <span>Who you are?</span>
                            <div class="input-group input-group-md-down-break">
                                <label class="form-control" for="whoSeller">
                                    <span class="form-check">
                                        <input type="radio" class="form-check-input" name="whoYouAreRadio" id="whoSeller">
                                        <span class="form-check-label">Seller</span>
                                    </span>
                                </label>
                                <label class="form-control" for="whoEngineer">
                                    <span class="form-check">
                                        <input type="radio" class="form-check-input" name="whoYouAreRadio" id="whoEngineer" checked="">
                                        <span class="form-check-label">Engineer</span>
                                    </span>
                                </label>
                                <label class="form-control" for="whoCeo">
                                    <span class="form-check">
                                        <input type="radio" class="form-check-input" name="whoYouAreRadio" id="whoCeo">
                                        <span class="form-check-label">CEO</span>
                                    </span>
                                </label>
                                <label class="form-control" for="whoOther">
                                    <span class="form-check">
                                        <input type="radio" class="form-check-input" name="whoYouAreRadio" id="whoOther">
                                        <span class="form-check-label">Other</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <span>What you do?</span>
                            <textarea
                                class="js-count-characters form-control"
                                id="shortDescriptionLabel"
                                v-model="description"
                                placeholder="Describe what you do (in English), and our artificial intelligence will take your activity into account when searching for new results."
                                maxlength="70"
                            ></textarea>
                        </div>

                        <div class="col-12 mb-3">
                            <span>What would you like to get out of LeadBrowser?</span>
                            <div class="input-group input-group-md-down-break">
                                <label class="form-control" for="discover">
                                    <span class="form-check">
                                        <input type="radio" class="form-check-input" name="typeRadio" id="discover">
                                        <span class="form-check-label">Discover and scout companies</span>
                                    </span>
                                </label>
                                <label class="form-control" for="ecosystem">
                                    <span class="form-check">
                                        <input type="radio" class="form-check-input" name="typeRadio" id="ecosystem">
                                        <span class="form-check-label">Measure your own tech ecosystem</span>
                                    </span>
                                </label>
                                <label class="form-control" for="other">
                                    <span class="form-check">
                                        <input type="radio" class="form-check-input" name="typeRadio" id="other">
                                        <span class="form-check-label">Other</span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div slot="footer">
                <div class="d-block text-center py-sm-5">
                    <button class="btn btn-primary btn-transition" @click="toggleWelcomeModal">Save and go!</button>
                </div>
            </div>
        </modal>
    </div>
</template>
<script>
import { mapState, mapActions } from "vuex";
export default {
    props: {
        show: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            isOpen: false,
            description: ''
        }
    },
    mounted() {
        if(this.show) {
            this.isOpen = true
        }
    },
    computed: {
        ...mapState({
            welcomeModal: state => state.welcomeModal
        }),
    },
    methods: {
        ...mapActions(["toggleWelcomeModal"]),
        save() {

        },
        pushFieldValue: function(key, { target }, indexKey) {
         
        },
    }
};
</script>
