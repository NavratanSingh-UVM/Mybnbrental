@extends('frontend.layouts.master')
@section('content')
<main id="content">
    <section class="pt-2 pb-4 page-title shadow">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pt-6 pt-lg-2 pb-2 lh-15">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List Your Property</li>
                </ol>
            </nav>
            <h1 class="fs-30 lh-16 mb-1 text-dark font-weight-600">Sign Up In 60 sec.</h1>
        </div>
    </section>
    
    <section class="pt-8 pb-8" data-animated-id="2">
        <div class="container-fluid">
            <div class="listyourproperty">
                <h6>Listing your property on MyBNBRentals.com offers a multitude of benefits, providing a unique platform to showcase your space and connect with travelers from around the world. Here are compelling reasons why you should consider listing your property on MyBNBRentals.com:</h6>
            
                <div class="row">
                    <div class="col">
                        <div class="boxstyle">
                            <strong>Global Exposure</strong>
                            <p>Reach a diverse and international audience of travelers. MyBNBRentals.com connects hosts with a global community, expanding your property's visibility beyond geographical boundaries.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="boxstyle">
                            <strong>Customizable Pricing</strong>
                            <p>Have control over your pricing strategy. Set flexible nightly rates, adjust prices based on seasons or special events, and choose any additional fees or charges according to your preferences.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="boxstyle">
                            <strong>Flexible Hosting Options</strong>
                            <p>Tailor your hosting experience to meet your needs. Whether you want to rent out your entire property, a private room, or a shared space, MyBNBRentals.com accommodates a variety of hosting arrangements.</p>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="boxstyle">
                            <strong>Transparent Communication</strong>
                            <p>Communicate directly with potential guests through our messaging system. Answer inquiries, provide additional information, and build a connection with guests before they book.</p>
                        </div>
                    </div>                    
                    
                    <div class="col">
                        <div class="boxstyle">
                            <strong>Secure Booking Process</strong>
                            <p>Benefit from a secure and streamlined booking process. MyBNBRentals.com ensures that all transactions and communication between hosts and guests occur within the platform, offering a safe and trustworthy environment for both parties.</p>
                        </div>
                    </div>
            </div>
            
            <div class="row">
                    <div class="col">
                        <div class="boxstyle">
                            <strong>Personalized Hosting Experience</strong>
                            <p>Showcase your property's unique features and amenities. Highlight what makes your space special, whether it's a stunning view, stylish decor, or exceptional amenities.</p>
                        </div>
                    </div>                    
                    
                    <div class="col">
                        <div class="boxstyle">
                            <strong>Host Support and Resources</strong>
                            <p>Access a dedicated support team available 24/7 to assist you with any inquiries or concerns. Additionally, take advantage of resources, tips, and guides to optimize your hosting experience and ensure success.</p>
                        </div>
                    </div>                    
                    
                    <div class="col">
                        <div class="boxstyle">
                            <strong>Guest Reviews and Ratings</strong>
                            <p>Encourage guests to leave reviews after their stay. Positive reviews enhance your property's credibility and attract more bookings. Responding to reviews demonstrates your commitment to guest satisfaction.</p>
                        </div>
                    </div>                    
                    
                    <div class="col">
                        <div class="boxstyle">
                            <strong>Community of Hosts</strong>
                            <p>Join a community of like-minded hosts who share experiences, insights, and tips. Connect with other hosts to learn from their successes and contribute to the collaborative spirit of the hosting community.</p>
                        </div>
                    </div>  
                    
                    <div class="col">
                        <div class="boxstyle">
                            <strong>Flexibility and Convenience</strong>
                            <p>Manage your property listings, reservations, and communication conveniently through the MyBNBRentals.com platform. It offers a user-friendly interface for a hassle-free hosting experience.</p>
                        </div>
                    </div>                    
                    
                </div>
            
            </div>
        </div>
    </section>
    
    <section class="bg-gray-01 pt-8 pb-8">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-lg-6"><img src="{{ asset('frontend-assets/img/list-1.jpg') }}" alt=""></div>
                <div class="col-lg-6">
                    <div class="textstyle">
                        <strong>Last Minute Deals:</strong>
                        <p>Listing your property on MyBNBRentals.com opens the door to a world of opportunities, connecting you with travelers eager to experience unique and authentic stays. Join our community, share your space, and embark on a rewarding journey of hospitality and exploration. </p>
                        <a href="#" class="btn btn-lg btn-primary mt-2">List Your Property Now.</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-color-01 pt-8 pb-8">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="textstyle textstylewhite">
                        <strong>Calendar Sync:</strong>
                        <p>No need to update multiple sites - we can sync your availability with any external calendar.
                        </p>
                        <hr>
                        <strong>No Booking or Service Fees:</strong>
                        <p>Travelers are more likely to use our site (and pay your rental rate) because we don't charge
                            them any additional fees.</p>
                        <hr>
                        <strong>Cost-effective advertising:</strong>
                        <p>With a free listing, you can advertise your rental with no upfront costs. Pay just 8% on confirmed bookings and manage everything through our easy-to-use dashboard. It’s that simple.</p>
                        <hr>
                        <strong>Secure and simple:</strong>
                        <p>My Bnb Rentals listing gives you a secure and easy way to take bookings and payments online. Plus, it’s simple to create and update your advert.</p>
                         
                        
                        
                    </div>
                </div>
                <div class="col-lg-6"><img src="{{ asset('frontend-assets/img/list-2.jpg') }}" alt=""></div>
            </div>
        </div>
    </section>
    
    
    <section class="section how-it-works">
       <div class="container">
          <h3>Here's how it works</h3>
          <div class="step">
             <div class="line right"></div>
             <span class="circle"><span class="number">1</span></span>
             <div class="content">
                <i class="icon icon-pen"></i>
                <p>You set up your free listing in minutes.</p>
             </div>
          </div>
          <div class="step">
             <div class="line"></div>
             <span class="circle"><span class="number">2</span></span>
             <div class="content"><i class="icon icon-looking-glass"></i>Guests search and find the perfect place—yours.</div>
          </div>
          <div class="step">
             <div class="line"></div>
             <span class="circle"><span class="number">3</span></span>
             <div class="content"><i class="icon icon-contact"></i>They contact you about staying in your home.</div>
          </div>
          <div class="step">
             <div class="line left"></div>
             <span class="circle"><span class="number">4</span></span>
             <div class="content"><i class="icon icon-money"></i>If you accept the booking, your guest pays on our secure website.</div>
          </div>
       </div>
    </section>
    
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="col-md-7">
                    <div class="textstyle">
                        <h2>Feature Your Property and Elevate Your Listing for Only <span>$50/month!</span></h2>
                        <p>At MyBNBRentals.com, we understand the importance of standing out in a sea of extraordinary properties. That's why we're excited to introduce our Featured Property option – an exclusive opportunity to showcase your space and capture the attention of discerning travelers.</p>
                    </div>
                </div>
                <div class="col-md-5">
                    <img src="{{ asset('frontend-assets/img/featureproperty.jpg') }}" >
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="featureyourproperty">
                <h2>Why Feature Your Property</h2>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Prime Visibility</strong>
                        <p>Your property will be prominently displayed on our homepage and search results, ensuring it catches the eye of every visitor to our platform.</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Increased Bookings</strong>
                        <p>Featured properties receive more views, leading to a higher chance of inquiries and bookings. Maximize your property's potential with enhanced visibility.</p>
                    </div>
                </div>
            </div>
            
            <div class="textstyle">
                <h2>How It Works:</h2>
                <p>For a nominal fee of $50/month, you can opt to feature your property and enjoy the perks of increased visibility and enhanced recognition.</p>
                
                <hr>
                
                <h2>Ready to Elevate Your Listing? Here's How:</h2>
                <ul class="listnu">
                    <li>Log in to your MyBNBRentals.com host account.</li>
                    <li>Navigate to your property dashboard.</li>
                    <li>Select the "Feature Your Property" option.</li>
                    <li>Complete the simple payment process to start enjoying the benefits of a featured listing.</li>
                </ul>
                
                <hr>   
                
                <h2>Terms and Conditions:</h2>
                <ul>
                    <li>The Featured Property option is available for $50/month per property.</li>
                    <li>Payments are processed securely through our platform.</li>
                </ul>
                
                <p>Don't miss out on this opportunity to make your property stand out! Feature your space today and let it shine on MyBNBRentals.com.</p>
                
                <a href="" class="btn btn-lg btn-primary mt-2">Feature Your Property Now</a>
                
                <p class="mt-3">Feel free to customize the details and terms according to your specific platform and business model.</p>
            </div>
            
        </div>
    </section>

    
</main>
@endsection
@push('js')
<script>
    $("#owner-register-forms").on("submit",function(e){
    e.preventDefault();
    showLoader();
    $.ajax({
        url:site_url+"/auth/owner-register",
        type: "POST",
        data:new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success:function(res){
            hideLoader();
            console.log(res);
            if(res.status=='1'){
                toastr.success(res.msg);
                window.setTimeout(() => {
                    window.location.href=res.url; 
                 }, 2000);

            }else{
                toastr.error(res.msg);
            }
        },error: function(xhr, ajaxOptions, thrownError){
            hideLoader();
            $(".full_name_error").text("");
            $(".username_error").text("");
            $(".phone_error").text("");
            $(".password_error").text("");
            $(".cnf_password_error").text("");
            $(".verify_error").text("");
            let error = xhr.responseJSON.errors;
            $(".full_name_error").text(error.full_name);
            $(".username_error").text(error.username);
            $(".phone_error").text(error.phone);
            $(".password_error").text(error.password);
            $(".cnf_password_error").text(error.cnf_password);
            $(".verify_error").text(error.verify);
            $(".verify_error").text(error.phone);
        }
    })
})
</script>

@endpush