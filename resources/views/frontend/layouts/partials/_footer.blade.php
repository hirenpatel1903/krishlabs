
<footer class="section-footer border-top">
    <div class="container">
        <section class="footer-bottom  row" >
            <div class="col-md-4">
                <p class="text-muted"> {{setting('site_footer')}} <a href="{{ route('/') }}">{{setting('site_name')}}</a></p>
            </div>
            <div class="col-md-8 text-md-center" >
                <div class="float-right">
                    <span>{{setting('site_email')}}</span>
                    <span  class="px-2">{{setting('site_phone_number')}}</span>
                    <span  class="px-2">{{setting('site_address')}}</span>
                </div>
            </div>
        </section>
    </div>
</footer>
