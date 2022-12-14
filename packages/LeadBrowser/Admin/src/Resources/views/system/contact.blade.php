@extends('admin::layouts.landing')

@section('page_title')
{{ __('admin::app.settings.sources.title') }}
@stop

@section('content-wrapper')
<div id="hireUsSection" class="bg-dark pt-5 wave-background">
    <div class="container-xl container-fluid content-space-1 content-space-md-2 px-4 px-md-8 px-lg-10">
        <div class="row justify-content-lg-between align-items-lg-center">
            <div class="col-md-10 col-lg-5 mb-9 mb-lg-0">
                <!-- Info -->
                <h1 class="text-white">Contact with us</h1>
                <p class="text-white-70">Whatever your goal - we will get your there.</p>
                <!-- End Info -->

                <div class="border-top border-white-10 my-5" style="max-width: 10rem;"></div>

                <!-- Blockquote -->
                <figure>

                    <blockquote class="blockquote blockquote-light">“We are available for you all the time.”</blockquote>

                    <figcaption class="blockquote-footer blockquote-light">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img class="avatar avatar-circle"
                                    src="https://thumbs.dreamstime.com/b/business-woman-portrait-isolated-white-close-up-face-background-smiling-female-model-office-suit-dressed-31155582.jpg"
                                    alt="Image Description">
                            </div>

                            <div class="flex-grow-1 ms-3">
                                Mariusz Malek
                                <span class="blockquote-footer-source">Founder of LeadBrowser.co</span>
                            </div>
                        </div>
                    </figcaption>
                </figure>
                <!-- End Blockquote -->
            </div>

            <div class="col-lg-6">
                <!-- Card -->
                <div class="card card-lg">
                    <div class="card-body">
                        <div class="mb-4">
                            <h3 class="card-title">Contact with us
                            </h3>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('contact.store') }}" @submit.prevent="onSubmit">

                            @csrf()

                            <div class="row gx-3">
                                <div class="col-sm-6">
                                    <!-- Form -->
                                    <div class="mb-3">
                                        <label class="form-label visually-hidden" for="email">Email address</label>
                                        <input type="email" class="form-control form-control-lg" name="email" id="email"
                                            placeholder="email@site.com" aria-label="email@site.com">
                                    </div>
                                    <!-- End Form -->
                                </div>
                                <!-- End Col -->
                                <div class="col-sm-6">
                                    <!-- Form -->
                                    <div class="mb-3">
                                        <label class="form-label visually-hidden" for="name">Name</label>
                                        <input type="text" class="form-control form-control-lg" name="name" id="name"
                                            placeholder="Name" aria-label="Name">
                                    </div>
                                    <!-- End Form -->
                                </div>
                                <!-- End Col -->
                                <div class="col-sm-12">
                                    <!-- Form -->
                                    <div class="mb-3">
                                        <label class="form-label visually-hidden" for="subject">Subject</label>
                                        <input type="text" class="form-control form-control-lg" name="subject"
                                            id="subject" placeholder="subject" aria-label="subject">
                                    </div>
                                    <!-- End Form -->
                                </div>
                                <!-- End Col -->
                            </div>
                            <!-- End Row -->

                            <!-- Form -->
                            <div class="mb-3">
                                <label class="form-label visually-hidden" for="content">Message</label>
                                <textarea class="form-control form-control-lg" name="content" id="content"
                                    placeholder="Hi there! Could you please tell me..."
                                    aria-label="Hi there! Could you please tell me..." rows="4"></textarea>
                            </div>
                            <!-- End Form -->

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Send message</button>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>
</div>
@stop
