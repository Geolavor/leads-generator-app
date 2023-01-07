<template>
    <div>
        <div v-if="finish">
            <div>
                <div class="text-center">
                    <div class="w-75 w-sm-50 mx-auto mb-4">
                        <img class="img-fluid" src="/vendor/leadBrowser/admin/assets/images/payment-illustration.svg" alt="Welcome!"/>
                    </div>

                    <h4 class="h1">Thank you!</h4>
                    <p>Thank you for your purchase! Your account has been updated and you can now use additional functionalities from the selected plan.</p>
                </div>
            </div>
        </div>
        <div v-else>

            <h2 class="relative font-serif text-xl font-bold">
                <span class="side-title">
                    Additional
                </span>
            </h2>

            <div class="form-group">
                <label for="promotion-code" class="required">Promotion code</label>
                <input type="text" class="control" name="promotion-code">
            </div>

            <h2 class="relative font-serif text-xl font-bold">
                <span class="side-title">
                    Customer information
                </span>
            </h2>

            <div class="form-group">
                <label for="name" class="required">Name</label>

                <input type="text" class="control" name="name">
            </div>

            <div class="form-group">
                <label for="email" class="required">Email</label>

                <input type="text" class="control" name="email">
            </div>

            <div class="form-group">
                <label for="line1" class="required">Line 1</label>

                <input type="text" class="control" name="line1">
            </div>

            <div class="form-group">
                <label for="line2" class="required">Line 2</label>

                <input type="text" class="control" name="line2">
            </div>

            <div class="form-group">
                <label for="city" class="required">City</label>

                <input type="text" class="control" name="city">
            </div>

            <div class="form-group">
                <label for="state" class="required">State</label>

                <input type="text" class="control" name="state">
            </div>

            <div class="form-group">
                <label for="country" class="required">Country</label>

                <input type="text" class="control" name="country">
            </div>

            <div class="form-group">
                <label for="postal_code" class="required">Postal code</label>

                <input type="text" class="control" name="postal_code">
            </div>


            <h2 class="relative font-serif text-xl font-bold">
                <span class="side-title">
                    Payment information
                </span>
            </h2>

            <div class="form-group">
                <label for="card-name" class="required">Card name</label>
                <input type="text" class="control" name="card-name">
            </div>

            <div class="form-group">
                <div class="relative">
                    <label for="card-element" class="leading-7 text-sm text-gray-600">Credit Card Info</label>
                    <div id="card-element"></div>
                </div>
            </div>
            <div class="card-footer">
                <button
                    class="btn btn-dark"
                    @click="processPayment"
                    :disabled="paymentProcessing"
                    v-text="paymentProcessing ? 'Processing' : 'Pay Now'"
                ></button>
                <div style="align-self: center; padding-left: 12px;">
                    <div style="display: flex; justify-content: center;">
                        <div style="padding-right: 2px; color: rgb(159, 159, 159); font-size: 90%; padding-top: 3px;">
                            Secure payments by
                        </div>
                        <a href="https://stripe.com" target="_blank" style="padding-left: 2px;">
                            <svg viewBox="0 0 60 25" xmlns="http://www.w3.org/2000/svg" width="60" height="25" class="UserLogo variant-- "><title>Stripe logo</title><path fill="var(--userLogoColor, #0A2540)" d="M59.64 14.28h-8.06c.19 1.93 1.6 2.55 3.2 2.55 1.64 0 2.96-.37 4.05-.95v3.32a8.33 8.33 0 0 1-4.56 1.1c-4.01 0-6.83-2.5-6.83-7.48 0-4.19 2.39-7.52 6.3-7.52 3.92 0 5.96 3.28 5.96 7.5 0 .4-.04 1.26-.06 1.48zm-5.92-5.62c-1.03 0-2.17.73-2.17 2.58h4.25c0-1.85-1.07-2.58-2.08-2.58zM40.95 20.3c-1.44 0-2.32-.6-2.9-1.04l-.02 4.63-4.12.87V5.57h3.76l.08 1.02a4.7 4.7 0 0 1 3.23-1.29c2.9 0 5.62 2.6 5.62 7.4 0 5.23-2.7 7.6-5.65 7.6zM40 8.95c-.95 0-1.54.34-1.97.81l.02 6.12c.4.44.98.78 1.95.78 1.52 0 2.54-1.65 2.54-3.87 0-2.15-1.04-3.84-2.54-3.84zM28.24 5.57h4.13v14.44h-4.13V5.57zm0-4.7L32.37 0v3.36l-4.13.88V.88zm-4.32 9.35v9.79H19.8V5.57h3.7l.12 1.22c1-1.77 3.07-1.41 3.62-1.22v3.79c-.52-.17-2.29-.43-3.32.86zm-8.55 4.72c0 2.43 2.6 1.68 3.12 1.46v3.36c-.55.3-1.54.54-2.89.54a4.15 4.15 0 0 1-4.27-4.24l.01-13.17 4.02-.86v3.54h3.14V9.1h-3.13v5.85zm-4.91.7c0 2.97-2.31 4.66-5.73 4.66a11.2 11.2 0 0 1-4.46-.93v-3.93c1.38.75 3.1 1.31 4.46 1.31.92 0 1.53-.24 1.53-1C6.26 13.77 0 14.51 0 9.95 0 7.04 2.28 5.3 5.62 5.3c1.36 0 2.72.2 4.09.75v3.88a9.23 9.23 0 0 0-4.1-1.06c-.86 0-1.44.25-1.44.9 0 1.85 6.29.97 6.29 5.88z" fill-rule="evenodd"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { loadStripe } from '@stripe/stripe-js';
    export default {
        props: {
            plan_id: {
                type: [Number, String]
            },
            stripe_key: {
                type: String
            }
        },
        data() {
            return {
                stripe: {},
                cardElement: {},
                customer: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    address: '',
                    city: '',
                    state: '',
                    zip_code: ''
                },
                paymentProcessing: false,
                finish: false
            }
        },
        async mounted() {
            if(!this.stripe_key) return;
            this.stripe = await loadStripe(this.stripe_key);
            const elements = this.stripe.elements();
            this.cardElement = elements.create('card', {
                classes: {
                    base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out'
                }
            });
            this.cardElement.mount('#card-element');
        },
        methods: {
            async processPayment() {
                this.paymentProcessing = true;
                const {paymentMethod, error} = await this.stripe.createPaymentMethod(
                    'card', this.cardElement, {
                        billing_details: {
                            name: this.customer.first_name + ' ' + this.customer.last_name,
                            email: this.customer.email,
                            address: {
                                line1: this.customer.address,
                                city: this.customer.city,
                                state: this.customer.state,
                                postal_code: this.customer.zip_code
                            }
                        }
                    }
                );
                if (error) {
                    this.paymentProcessing = false;
                    console.error(error);
                } else {
                    
                    this.customer.payment_method = paymentMethod.id;
                    this.customer.plan_id = this.plan_id;

                    axios.post('/subscription', this.customer)
                        .then((response) => {
                            this.paymentProcessing = false;
                            this.finish = true
                            // console.log(response);
                        })
                        .catch((error) => {
                            this.paymentProcessing = false;
                            // console.error(error);
                        });
                }
            }
        }
    }
</script>