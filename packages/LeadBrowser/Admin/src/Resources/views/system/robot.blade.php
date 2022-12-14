@extends('admin::layouts.system')

@section('page_title')
{{ __('admin::app.settings.sources.title') }}
@stop

@section('content-wrapper')
<div>
    <div class="mb-7">
        <h2>Robot</h2>
        <h4>Effective Date: January 1, 2022, Last Updated: January 1, 2022</h4>
        <br>
        <p>
            What is a robot? Every month our competition launches a robot that searches certain websites.
            Our AI LeadBrowser Robot tool works in an innovative way and search all* pages only in real time.
            Our tool works similar to a web browser where you insert input and get the data. But with the difference that it focuses on business data.
        </p>
        <p>
            What is LeadBrowser robot doing on your website? The robot only analyzes public web pages and navigates at a slow pace. It never visits more than one page every two seconds for a website to make sure other visitors aren’t slowed down by the crawling.
        </p>
        <p>
            Does it respect robots.txt file? Yes. The robot strictly respect robots.txt, both disallow and allow rules (we do not, however, support nonstandard extensions unless stated otherwise).
        </p>
        <p>
            If you think that LeadBrowser robot is someway misbehaving on your website or if you have any questions about it, please don’t hesitate to contact us at contact@konstelacja.
        </p>
    </div>
</div>
@stop
