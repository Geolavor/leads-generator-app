@extends('admin::layouts.landing')

@section('page_title')
{{ $blog->blog_title }}
@endsection

@section('head')
@isset($blog->meta_title)
<meta name="title" content="{{ $blog->meta_title }}" />
@endisset

@isset($blog->meta_description)
<meta name="description" content="{{ $blog->meta_description }}" />
@endisset

@isset($blog->meta_keywords)
<meta name="keywords" content="{{ $blog->meta_keywords }}" />
@endisset
@endsection

@section('content-wrapper')
<div class="container content-space-t-3 content-space-t-lg-4 content-space-b-2">

    <div class="w-lg-65 mx-lg-auto">
        <div class="mb-4">
            <h1 class="h2">{{ $blog->blog_title }}</h1>
        </div>

        @if($blog->author)
            <div class="row align-items-sm-center mb-5">
                <div class="col-sm-7 mb-4 mb-sm-0">
                    <!-- Media -->
                    <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img class="avatar avatar-circle" src="{{ $blog->author->image_url }}" alt="Image Description">
                    </div>

                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-0">
                        <a class="text-dark" href="./blog-author-profile.html">{{ $blog->author->name }}</a>
                        </h5>
                        <span class="d-block small">{{ $blog->created_at }}</span>
                    </div>
                    </div>
                    <!-- End Media -->
                </div>
                <!-- End Col -->

                <div class="col-sm-5">
                    <div class="d-flex justify-content-sm-end align-items-center">
                    <span class="text-cap mb-0 me-2">Share:</span>

                    <div class="d-flex gap-2">
                        <a class="btn btn-soft-secondary btn-sm btn-icon rounded-circle" href="#">
                        <i class="bi-facebook"></i>
                        </a>
                        <a class="btn btn-soft-secondary btn-sm btn-icon rounded-circle" href="#">
                        <i class="bi-twitter"></i>
                        </a>
                        <a class="btn btn-soft-secondary btn-sm btn-icon rounded-circle" href="#">
                        <i class="bi-instagram"></i>
                        </a>
                        <a class="btn btn-soft-secondary btn-sm btn-icon rounded-circle" href="#">
                        <i class="bi-telegram"></i>
                        </a>
                    </div>
                    </div>
                </div>
                <!-- End Col -->
            </div>
        @endif

        @if($blog)
            {!! DbView::make($blog)->field('html_content')->render() !!}
        @endif

    </div>

    <!-- <div class="my-4 my-sm-8">
        <img class="img-fluid rounded-lg" src="./assets/img/1920x800/img5.jpg" alt="Image Description">
    </div> -->

</div>
@endsection
