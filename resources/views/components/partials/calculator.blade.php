<div>
    <calculator-component></calculator-component>
</div>

@push('scripts')

<script type="text/x-template" id="calculator-template">
    <div>
        <div class="card card-lg zi-2" data-aos="fade-up">
            <div class="card-body">
                <form>
                    <!-- Radio Button Group -->
                    <div class="text-center mb-5">
                    
                    </div>
                    <!-- End Radio Button Group -->

                    <!-- Range Slider -->
                    <div class="display-4 text-dark text-center">
                        Cost: @{{ value }} search coins
                    </div>
                    <div class="d-flex justify-content-center mb-5">
                        Approximate time to acquire all data:
                        <span class="text-primary ms-1">10 minutes</span>
                    </div>
                    <!-- End Range Slider -->
                </form>
            <!-- End Row -->
            </div>

            <div class="card-footer">
                <button class="btn btn-primary w-100" type="submit">
                    <i class="bi bi-search"></i> Start live search
                </button>
            </div>
        </div>
    </div>
</script>

<script>
    Vue.component('calculator-component', {
        template: '#calculator-template',
        inject: ['$validator'],
        data: function() {
            return {
                value: 0,
            }
        },
        mounted: function() {
            // var this_this = this;
            // $(document).ready(function(){
            //     var target = document.getElementById('expected_items');
            //     this_this.value = target.value
            //     console.log(target.value)
            // });
        },
        computed: {
            getInputValue() {
                var target = document.getElementById('expected_items');
                return target.value
            }
        }
    })
</script>

@endpush