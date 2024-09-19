<footer class="bg-dark pt-8 pb-6 footer text-muted">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-6 mb-md-0">
                <a class="d-block mb-2" href="#"> <img src="{{ asset('frontend-assets/img/footer-logo.png') }}" alt=""> </a>
                <div class="lh-26 font-weight-500">
                    <p class="mb-0">Fort Lauderdale, Florida, United States</p> 
                    <a class="d-block text-muted hover-white" href="mailto:beachforsale@yahoo.com">support@mybnbrentals.com</a> 
                    <a class="d-block text-lighter font-weight-bold fs-15 hover-white" href="tel:+19546553494">+1 954-655-3494</a> 
                    <a class="d-block text-muted hover-white" href="javascript::void(0)">www.mybnbrentals.com</a> 
                </div>
            </div>
            <div class="col-md-6 col-lg-2 mb-6 mb-md-0">
            </div>
            <div class="col-md-6 col-lg-2 mb-6 mb-md-0">
                <h4 class="text-white fs-16 my-4 font-weight-500">Quick links</h4>
                <ul class="list-group list-group-flush list-group-no-border">
                    <li class="list-group-item bg-transparent p-0"> <a href="{{ route('frontend.index') }}" class="text-muted lh-26 font-weight-500 hover-white">Home</a> </li>
                    <li class="list-group-item bg-transparent p-0"> <a href="{{ route('frontend.abouts') }}" class="text-muted lh-26 font-weight-500 hover-white">About Us</a> </li>
                    <li class="list-group-item bg-transparent p-0"> <a href="#" class="text-muted lh-26 font-weight-500 hover-white">Area Attractions</a> </li>
                    <li class="list-group-item bg-transparent p-0"> <a href="{{ route('frontend.contact.us') }}" class="text-muted lh-26 hover-white font-weight-500">Contact Support</a> </li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-4 mb-6 mb-md-0">
                <h4 class="text-white fs-16 my-4 font-weight-500">Sign Up for Our Newsletter</h4>
                {{-- <p class="font-weight-500 text-muted lh-184">Lorem ipsum dolor sit amet, consecte tur cing elit. Suspe ndisse suscipit sagittis </p> --}}
                <form>
                    <div class="input-group input-group-lg mb-6">
                        <input type="text" name="email" required class="form-control bg-white shadow-none border-0 z-index-1" placeholder="Your email">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </div>
                </form>
                <ul class="list-inline mb-0">
                    <li class="list-inline-item mr-0"> <a href="#" class="text-white opacity-3 fs-25 px-4 opacity-hover-10"><i class="fab fa-twitter"></i></a> </li>
                    <li class="list-inline-item mr-0"> <a href="#" class="text-white opacity-3 fs-25 px-4 opacity-hover-10"><i class="fab fa-facebook-f"></i></a> </li>
                    <li class="list-inline-item mr-0"> <a href="#" class="text-white opacity-3 fs-25 px-4 opacity-hover-10"><i class="fab fa-instagram"></i></a> </li>
                    <li class="list-inline-item mr-0"> <a href="#" class="text-white opacity-3 fs-25 px-4 opacity-hover-10"><i class="fab fa-linkedin-in"></i></a> </li>
                </ul>
            </div>
        </div>
        <div class="mt-0 mt-md-10 row">
            <ul class="list-inline mb-0 col-md-6 mr-auto">
                <li class="list-inline-item mr-6"> <a href="#" class="text-muted lh-26 font-weight-500 hover-white">Terms of Use</a> </li>
                <li class="list-inline-item"> <a href="#" class="text-muted lh-26 font-weight-500 hover-white">Privacy Policy</a> </li>
            </ul>
            <p class="col-md-auto mb-0 text-muted"> © 2023 My BNB Rentals. All Rights Reserved | Designed By : <a target="_blank" href="https://www.createonlineweb.com/"> Create Online Web </a></p>
        </div>
    </div>
</footer>
<div class="position-fixed pos-fixed-bottom-right p-6 z-index-10"> 
    <a href="#" class="gtf-back-to-top bg-white text-primary hover-white bg-hover-primary shadow p-0 w-52px h-52 rounded-circle fs-20 d-flex align-items-center justify-content-center" title="Back To Top">
        <i class="fal fa-arrow-up"></i>
    </a> 
</div>