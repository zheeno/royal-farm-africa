@extends('layouts.app')
@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Contact Us</title>
@endsection

@section('content')
<div class="container p-5">
    <div class="row mb-5 pb-5">
        <div class="col-md-7 mx-auto">
        <script id="bx24_form_inline" data-skip-moving="true">
                (function(w,d,u,b){w['Bitrix24FormObject']=b;w[b] = w[b] || function(){arguments[0].ref=u;
                        (w[b].forms=w[b].forms||[]).push(arguments[0])};
                        if(w[b]['forms']) return;
                        var s=d.createElement('script');s.async=1;s.src=u+'?'+(1*new Date());
                        var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
                })(window,document,'https://royalfarmsafrica.bitrix24.com/bitrix/js/crm/form_loader.js','b24form');

                b24form({"id":"4","lang":"en","sec":"0xm159","type":"inline"});
        </script>
        </div>

        <div class="col-md-4 mx-auto">
            <h3 class="fa-3x text bold">Contact Us</h3>
            <div class="row">
                <div class="col-12">
                    <p class="lead">If you'd like to have a conversation with us,
                        don't hesistate to give us a call
                    </p>
                </div>
                <div class="col-12">
                    <h4 class="h4-responsive green-text bold">Helplines</h4>
                    <span><span class="fa fa-phone green-ic"></span> <span class="text">‭+234 813 867 0436‬</span></span>
                    <br /><br />
                    <span><span class="fa fa-at green-ic"></span> <span class="text">‭{{ 'support@'.str_replace('http://', '', env('APP_URL')) }}‬</span></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection