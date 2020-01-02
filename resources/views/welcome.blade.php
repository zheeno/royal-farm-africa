@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 hero pt-2 pt-md-5 pb-md-5">
            <div class="row">
                <div class="col-md-7 pb-5 pl-5 pt-4 hero-mask">
                    <h1 class="fa-3x bold mb-0 text wow fadeIn" data-wow-delay="0.6s"  data-wow-duration="5s">Looking to invest in a farm,</h1>
                    <h5 class="fa-2x text wow fadeIn" data-wow-delay="2s"  data-wow-duration="5s">and you don't really know where to start?</h5>
                    <p class="lead text wow fadeIn" data-wow-delay="3s"  data-wow-duration="5s">Let&apos;s help you out</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 align-text-center hero-mask">
                    <a class="btn green-btn">Get Started</a>
                    <a class="btn grey lighten-4"><span class="text">Learn More</span></a>
                </div>
            </div>
        </div>
    </div>
    <!--  -->
    <div class="row grey lighten-4 pt-5 pb-5">
        <div class="col-md-8 mx-auto align-text-center pt-5 pb-5">
            <img src="{{ asset('img/logo_no_text.png') }}" class="img-responsive mb-4" style="width:65px" />
            <p class="lead ml-5 mr-5 text">
                <strong>{{ env("APP_NAME") }}</strong> is dedicated to help you maximize
                your profits by helping you invest in competent farms
                <span class="hidden-sm">and also ensuring that the money is put to good use by provding
                the farmers with all the resources and technical know-how that
                they require.</span>
            </p>
        </div>
    </div>
    <!-- how it works -->
    <div class="row white pt-5 pb-5">
        <div class="col-12 hero-2 pt-2 pt-md-5 pb-md-5">
            <div class="row hero-2-mask">
                <div class="col-md-8 ml-auto">
                    <h1 class="fa-3x bold mb-0 text wow fadeIn" data-wow-delay="0.6s"  data-wow-duration="5s">How it works</h1>
                    <div class="row pt-3">
                        <!-- step 1 -->
                        <div class="white col-md-4 mt-2 mx-auto shadow p-3">
                            <h3 class="green-text bold h3-responsive">
                                <span class="badge badge-success">1</span>&nbsp;Follow a Farm</h3>
                            <hr />
                            <p class="text lead">Follow a farm in which you have interest in its produce</p>
                        </div>
                        <!-- step 2 -->
                        <div class="white col-md-4 mt-2 mr-auto shadow p-3">
                            <h3 class="green-text bold h3-responsive">
                                <span class="badge badge-success">2</span>&nbsp;Select a Produce</h3>
                            <hr />
                            <p class="text lead">Select a farm produce in which you'd like to invest in</p>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <!-- step 3 -->
                        <div class="white col-md-4 mt-2 mx-auto shadow p-3">
                            <h3 class="green-text bold h3-responsive">
                                <span class="badge badge-success">3</span>&nbsp;Invest</h3>
                            <hr />
                            <p class="text lead">Invest in as many available units as you wish</p>
                        </div>
                        <!-- step 2 -->
                        <div class="white col-md-4 mt-2 mr-auto shadow p-3">
                            <h3 class="green-text bold h3-responsive">
                                <span class="badge badge-success">4</span>&nbsp;Start Earning</h3>
                            <hr />
                            <p class="text lead">Receive your profits when your investment matures</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- testimonies -->
</div>
@endsection
