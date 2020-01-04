<div class="row p-5 black-lighten-3">
    @guest()
    <div class="col-12 align-text-center">
            <h1 class="white-text h1-responsive align-text-center">Sponsor a farm now</h1>
            <a class="btn green-btn active" href="/register">Register Now</a>
    </div>
    @endguest
    <div class="col-md-10 mx-auto p-2 p-md-5">
        <div class="row">
            <div class="col-md-3 mx-auto" style="margin-top:20px">
                <h4 class="white-text bold h4-responsive">About Us</h4>
                <small><a class="grey-text" href="/">About</a></small><br />
                <small><a class="grey-text" href="/">Blog</a></small><br />
                <small><a class="grey-text" href="/">Terms</a></small><br />
                <small><a class="grey-text" href="/">Privacy</a></small><br />
            </div>
            <div class="col-md-3 mx-auto" style="margin-top:20px">
                <h4 class="white-text bold h4-responsive">Service</h4>
                <small><a class="grey-text" href="/">Downloads</a></small><br />
                <small><a class="grey-text" href="/">Referal</a></small><br />
                <small><a class="grey-text" href="/">Announcements</a></small><br />
                </div>
            <div class="col-md-3 mx-auto" style="margin-top:20px">
                <h4 class="white-text bold h4-responsive">Support</h4>
                <small><a class="grey-text" href="/">FAQ</a></small><br />
                <small><a class="grey-text" href="/">Support Center</a></small><br />
                <small><a class="grey-text" href="/">Submit a Request</a></small><br />
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-11 mx-auto p-3 border-top align-text-center">
            <small class="grey-text">&copy;2017 - {{ Date('Y') }}<br />{{ env("APP_NAME") }}<br /> All rights reserved.</small>
            </div>
        </div>
    </div>
</div>