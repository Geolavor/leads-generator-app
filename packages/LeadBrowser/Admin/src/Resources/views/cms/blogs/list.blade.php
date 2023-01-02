@extends('admin::layouts.landing')

@section('page_title')
    {{ __('admin::app.cms.blogs.title') }}
@stop

@section('content-wrapper')
    <div class="container content-space-2 content-space-lg-3">
      <div class="row justify-content-lg-between">
        <div class="col-12">
          <div class="d-grid gap-7 mb-7">

            @foreach ($collection as $item)
              <div class="card card-flush card-stretched-vertical">
                <div class="row">
                  <div class="col-sm-5">
                    <img class="card-img" src="{{ $item->image_url }}" alt="Image Description">
                  </div>
                  <!-- End Col -->

                  <div class="col-sm-7">
                    <!-- Card Body -->
                    <div class="card-body">
                      <div class="mb-2">
                        <a class="card-link" href="#">#topic</a>
                      </div>

                      <h3 class="card-title">
                        <a class="text-dark" href="/blog/{{ $item->url_key }}">{{ $item->blog_title }}</a>
                      </h3>

                      <p class="card-text">Great news we're eager to share.</p>

                      @if($item->author)
                        <!-- Card Footer -->
                        <div class="card-footer">
                          <div class="d-flex">
                            <div class="flex-shrink-0">
                              <a class="avatar avatar-circle" href="#">
                                <img class="avatar-img" src="{{ $item->author->image_url }}" alt="Image Description">
                              </a>
                            </div>

                            <div class="flex-grow-1 ms-3">
                              <a class="card-link link-dark" href="#">{{ $item->author->name }}</a>
                              <p class="card-text small">{{ $item->created_at }}</p>
                            </div>
                          </div>
                        </div>
                        <!-- End Card Footer -->
                      @endif
                    </div>
                    <!-- End Card Body -->
                  </div>
                  <!-- End Col -->
                </div>
                <!-- End Row -->
              </div>
            @endforeach

          </div>

          <!-- Sticky Block End Point -->
          <div id="stickyBlockEndPoint"></div>

        </div>

      </div>

    </div>
@stop
