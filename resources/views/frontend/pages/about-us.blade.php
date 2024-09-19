@extends('frontend.layouts.master')
@section('content')
<section style="background-image: url({{ asset('frontend-assets/img/bg-about-us.jpg') }})" class="bg-img-cover-center py-10 pt-md-10 pb-md-10 bg-overlay">
    <div class="container position-relative z-index-2 text-center">
      <div class="mxw-721">
        <h1 class="text-white fs-30 fs-md-42 lh-15 font-weight-normal mt-4 mb-10" data-animate="fadeInRight">Welcome to MyBNBRentals.com – Your Gateway to Unforgettable Stays!</h1> </div>
    </div>
  </section>

  <section class="bg-patten-03 bg-gray-01 pb-5">
    <div class="container">
      <div class="card border-0 mt-n13 z-index-3 mb-2">
        <div class="card-body p-6 px-lg-5 py-lg-5">
          <p class="text-center px-lg-11 fs-15 lh-17">At MyBNBRentals.com, we understand that every journey begins with a comfortable and welcoming space to call home. Whether you're a seasoned traveler or embarking on your first adventure, we are here to redefine your accommodation experience. Our platform is designed with a passion for connecting people to unique, extraordinary spaces around the globe, creating memories that last a lifetime.</p>
        <br>
          <div class="row">
              <div class="col-md-6">
                  <img src="https://www.mybnbrentals.com/public/frontend-assets/img/gallery-08.jpg" >
              </div>
              <div class="col-md-6">
                  <h2 class="text-heading"> Who We Are:</h2>
                  <p>MyBNBRentals.com is more than just a booking platform; we are a community of hosts and travelers coming together to share in the joy of exploration and discovery. Founded with a vision to make travel more accessible and personalized, we've crafted a space where individuals can find the perfect home away from home, and hosts can showcase their unique properties to a global audience.</p>
              </div>
          </div>
        <br><br>
          <div class="row">
              <div class="col-md-6">
                  <h2 class="text-heading"> Our Mission:</h2>
                  <p>Our mission is simple yet profound – to inspire and empower travel experiences by fostering connections between people and places. We believe in the transformative power of travel and the ability of a well-curated space to enhance your journey. Through our platform, we aim to break down barriers, cultivate understanding, and make the world feel a bit smaller by bringing together a diverse community of hosts and travelers.</p>
              </div>
              <div class="col-md-6">
                  <img src="https://www.mybnbrentals.com/public/frontend-assets/img/gallery-11.jpg" >
              </div>              
          </div>        
        
        
        
        </div>
      </div>
    </div>
  </section>

<section class="pt-6">
  <div class="container">
      <h2 class="text-heading mb-4 fs-22 fs-md-32 text-center lh-16 px-md-13"> What Sets Us Apart</h2>
      <div class="listyourproperty">
        <div class="row">
            <div class="col">
              <div class="boxstyle">
                  <strong>Diverse Selection</strong>
                  <p>From cozy urban apartments to luxurious beachfront villas, our diverse selection of rentals ensures that there's a perfect space for every traveler and every occasion.</p>
              </div>
            </div>
            
            <div class="col">
              <div class="boxstyle">
                  <strong>Personalized Experiences</strong>
                  <p>We believe in the power of choice. Customize your stay based on your preferences, whether you seek a peaceful retreat, a vibrant city escape, or an adventure-filled getaway.</p>
              </div>
            </div>
            
            <div class="col">
              <div class="boxstyle">
                  <strong>Host Excellence</strong>
                  <p>Our hosts are the heart of MyBNBRentals.com. Passionate individuals who open their doors to welcome guests from around the world, they strive to make your stay memorable and authentic.</p>
              </div>
            </div>            

            <div class="col">
              <div class="boxstyle">
                  <strong>Global Community</strong>
                  <p>Join a community that spans the globe. Connect with like-minded travelers, discover hidden gems, and experience local culture in a way that only our platform can offer.</p>
              </div>
            </div>

        </div>
      </div>
  </div>
</section>

<section class="pt-6 whychoose">
  <div class="container">
      <h2 class="text-heading mb-4 fs-22 fs-md-32 text-center lh-16 px-md-13"> Why Choose MyBNBRentals.com</h2>
      <div class="row">
          <div class="col-md-6">
            <div class="textstyle">
                <strong>Trust and Safety:</strong>
                <p>Your safety and security are paramount. We implement robust verification processes for hosts and guests to ensure a trustworthy and secure environment.</p>
                <hr>
                <strong>Seamless Booking:</strong>
                <p>Our user-friendly platform ensures a seamless booking experience. Discover, book, and manage your reservations with ease, giving you more time to focus on the excitement of your upcoming journey.</p>
                <hr>
                <strong>24/7 Support:</strong>
                <p>Our dedicated support team is available around the clock to assist you. Whether you have a question about a property or need assistance during your stay, we're here to help.</p>
                <p>Welcome to MyBNBRentals.com – Where Extraordinary Experiences Begin! Join us on this journey, and let's create unforgettable memories together.</p>
            </div>
          </div>
          <div class="col-md-6">
              <img src="https://www.mybnbrentals.com/public/frontend-assets/img/gallery-10.jpg" >
          </div>              
      </div>      
      
  </div>
</section>

@endsection