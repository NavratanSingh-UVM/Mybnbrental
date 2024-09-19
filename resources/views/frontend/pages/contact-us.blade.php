@extends('frontend.layouts.master')
@section('content')
<main id="content">
    <section class="pt-2 pb-4 page-title shadow">
      <div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb pt-6 pt-lg-2 pb-2 lh-15">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Get In Touch</li>
          </ol>
        </nav>
        <h1 class="fs-30 lh-16 mb-1 text-dark font-weight-600">Contact Us </h1> </div>
    </section>
    <section class="pt-8 pb-9" data-animated-id="2">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="border-bottom pb-7">
                        <h2 class="text-heading mb-2 fs-22 lh-15 pr-6">For more information about our services, get in touch with our expert consultants. We're always eager to hear from you!</h2>
                        <p class="mb-6"> Lorem ipsum dolor sit amet, consec tetur cing elit. Suspe ndisse suscorem ipsum dolor sit ametcipsu </p>
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <input type="text" placeholder="First Name" class="form-control form-control-lg border-0" name="first-name"> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <input type="text" placeholder="Last Name" name="last-name" class="form-control form-control-lg border-0"> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <input placeholder="Your Email" class="form-control form-control-lg border-0" type="email" name="email"> </div>
                                </div>
                                <div class="col-md-6 px-2">
                                    <div class="form-group mb-4">
                                        <input type="text" placeholder="Your Phone" name="phone" class="form-control form-control-lg border-0"> </div>
                                </div>
                            </div>
                            <div class="form-group mb-6">
                                <textarea class="form-control border-0" placeholder="Message" name="message" rows="5"></textarea>
                            </div>
                            <button type="submit" class="btn btn-lg btn-primary px-9">Submit</button>
                        </form>
                    </div>
                    <div class="pt-7">            

                        <div class="row mt-8">
                            <div class="col-md-12 mb-12">
                                <div class="media"> <span class="fs-32 text-primary mr-4"><i class="fal fa-phone"></i></span>
                                    <div class="media-body mt-3">
                                        <h4 class="fs-16 lh-2 mb-1 text-dark">Contact</h4>
                                        <div class="row mb-1">
                                            <div class="col-3"> <span>Call Us</span> </div>
                                            <div class="col-9"> <a href="tel:+19546553494" class="text-heading font-weight-500">+1 954-655-3494</a> </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-3"> <span>Email Us</span> </div>
                                            <div class="col-9"> <a href="mailto:beachforsale@yahoo.com" class="text-body">beachforsale@yahoo.com</a> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 primary-sidebar sidebar-sticky" id="sidebar">
                    <div class="primary-sidebar-inner">
                        <div class="card">
                            <div class="card-body text-center pt-7 pb-6 px-0"> <img src="{{ asset('frontend-assets/img/contact-widget.jpg') }}" alt="Want to become an Estate Agent ?">
                                <div class="text-dark mb-6 mt-n2 font-weight-500">Want to become an
                                    <p class="mb-0 fs-18">Estate Agent?</p>
                                </div> <a href="#" class="btn btn-primary">Register</a> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
</main>
@endsection