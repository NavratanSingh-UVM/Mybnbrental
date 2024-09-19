<header class="main-header navbar-dark bg-secondary header-sticky header-sticky-smart header-mobile-lg">
	<div class="sticky-area bg-secondary">
		<div class="container">
			<nav class="navbar navbar-expand-lg bg-transparent px-0">
				<a class="navbar-brand" href="{{ route('frontend.index') }}"> <img src="{{ asset('frontend-assets/img/logo.png') }}" alt=""> </a>
				<div class="d-flex d-lg-none ml-auto">
					<button class="navbar-toggler border-0 px-0" type="button" data-toggle="collapse" data-target="#primaryMenu06" aria-controls="primaryMenu06" aria-expanded="false" aria-label="Toggle navigation"> 
						<span class="text-white fs-24"><i class="fal fa-bars"></i></span> 
					</button>
				</div>
				<div class="collapse navbar-collapse mt-3 mt-lg-0" id="primaryMenu06">
					<ul class="navbar-nav hover-menu main-menu px-0 mx-lg-n4">
						
						{{-- <li class="nav-item py-2 py-lg-5 px-0 px-lg-4"> 
							<a class="nav-link p-0" href="{{ route('frontend.index') }}">Home</a>
						</li> --}}

						{{-- <li class="nav-item py-2 py-lg-5 px-0 px-lg-4"> 
							<a class="nav-link p-0" href="{{ route('frontend.abouts') }}">About Us</a>
						</li>  --}}

						<li class="nav-item py-2 py-lg-5 px-0 px-lg-4"> 
							<a class="nav-link p-0" href="{{ route('location.property') }}">Destinations</a>
						</li>

						{{-- <li class="nav-item py-2 py-lg-5 px-0 px-lg-4"> 
							<a class="nav-link p-0" href="index.php#explore">Explore</a>
						</li> --}}
						{{--<li class="nav-item py-2 py-lg-5 px-0 px-lg-4"> 
							<a class="nav-link p-0" href="{{ route('frontend.contact.us') }}">Contact Us</a>
						</li>--}}
						<li class="nav-item py-2 py-lg-5 px-0 px-lg-4"> 
							<a class="nav-link p-0" href="{{ route('frontend.partner.listing') }}">Partner Listings</a>
						</li>
						@if(auth()->check())
						@role(['Traveller','Owner','Partner'])
						<li class="nav-item py-2 py-lg-5 px-0 px-lg-4"> 
							<a class="nav-link p-0" href="@if(auth()->user()->getRoleNames()->first() =='Traveller'){{route('traveller.dashboard')}}@else {{route('owner.dashboard')}} @endif">Dashboard</a>
						</li>
						@elserole(['super-admin'])
						<li class="nav-item py-2 py-lg-5 px-0 px-lg-4"> 
							<a class="nav-link p-0" data-toggle="modal" href="#login-register-modal"> Login/Sign Up</a>
						</li>
						@endrole
						@else
							<li class="nav-item py-2 py-lg-5 px-0 px-lg-4"> 
								<a class="nav-link p-0" data-toggle="modal" href="#login-register-modal">Login/Sign Up</a>
							</li>
						@endif
						<li class="nav-item">
							<a class="nav-link p-0" href="{{ route('frontend.list.our.property') }}">List Your Property</a>
						</li>
					</ul>
				</div>
			</nav>
		</div>
	</div>
</header>
<div class="modal fade login-register login-register-modal" id="login-register-modal" tabindex="-1" role="dialog" aria-labelledby="login-register-modal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered mxw-571" role="document">
		<div class="modal-content">
			<div class="modal-header border-0 p-0">
				<div class="nav nav-tabs row w-100 no-gutters" id="myTab" role="tablist">
					<a class="nav-item col-sm-3 ml-0 nav-link pr-6 py-4 pl-9 active fs-18" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
					<a class="nav-item col-sm-3 ml-0 nav-link py-4 px-6 fs-18" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
					<div class="nav-item col-sm-6 ml-0 d-flex align-items-center justify-content-end">
						<button type="button" class="close m-0 fs-23" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>
			</div>
			<div class="modal-body p-4 py-sm-7 px-sm-8">
				<div class="tab-content shadow-none p-0" id="myTabContent">
					<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
						<form class="form" id="owner_login_form" method="post">
							@csrf
							<div class="form-check">
							   <input name="Check" value="Owner" id="flexRadioDefault1" type="radio">Owner
                               <input name="Check" value="Traveller" id="flexRadioDefault2" type="radio">Traveller
						       <input name="Check" value="Partner" id="flexRadioDefault3" type="radio">Partner
							 </div>
							<div class="form-group mb-4">
								<label for="username" class="sr-only">Username</label>
								<div class="input-group input-group-lg">
								<div class="input-group-prepend ">
									<span class="input-group-text bg-gray-01 border-0 text-muted fs-18" id="inputGroup-sizing-lg">
									<i class="far fa-user"></i></span>
								</div>
								<input type="text" class="form-control border-0 shadow-none fs-13" id="username" name="username"  placeholder="Your email">
								</div>
								<span class="username_error text-danger"></span>
							</div>
							
							<div class="form-group mb-4">
								<label for="password" class="sr-only">Password</label>
								<div class="input-group input-group-lg">
								<div class="input-group-prepend ">
									<span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
									<i class="far fa-lock"></i>
									</span>
								</div>
								<input type="password" class="form-control border-0 shadow-none fs-13" id="password" name="password"  placeholder="Password">
								<div class="input-group-append">
									<span class="input-group-text bg-gray-01 border-0 text-body fs-18">
									   <i class="fas fa-eye" id="toggle_password"></i>
									</span>
								</div>
								</div>
								<span class="password_error text-danger"></span>
							</div>
							<div class="d-flex mb-4">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="remember-me" name="remember-me">
									<label class="form-check-label" for="remember-me">
										Remember me
									</label>
								</div>
								<a href="{{route('admin.forget.password')}}" class="d-inline-block ml-auto text-orange fs-15">Lost password?</a>
							</div>
							<button type="submit" class="btn btn-primary btn-lg btn-block">Log in</button>
						</form>
					</div>
					<div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
						<form class="form" id="owner-register-form" method="post">
							<p>Enter your details to be a member.</p>
							@csrf
							<div class="form-group mb-4">
								<label for="full-name" class="sr-only">Full name</label>
								<div class="input-group input-group-lg">
								<div class="input-group-prepend ">
									<span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
									<i class="far fa-address-card"></i></span>
								</div>
								<input type="text" class="form-control border-0 shadow-none fs-13" id="full-name" name="full_name" placeholder="Full name">
							</div>
							<span class="full_name_error text-danger"></span>
							</div>
							<div class="form-group mb-4">
								<label for="reg_username" class="sr-only">Username</label>
								<div class="input-group input-group-lg">
								<div class="input-group-prepend ">
									<span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
									<i class="far fa-user"></i></span>
								</div>
								<input type="text" class="form-control border-0 shadow-none fs-13" id="reg_username" name="username" placeholder="Your email">
								</div>
								<span class="username_error text-danger"></span>
							</div>
							<div class="form-group mb-4">
								<label for="username" class="sr-only">Phone</label>
								<div class="row">
									<div class="col-3 p-0">
										<div class="input-group input-group-lg">
											<select class="form-control" name="country_code">
												<option value="">Select Country Code</option>
												<option value="93">+93/Afghanistan</option>
												<option value="355">+355/Albania</option>
												<option value="213">+213/Algeria</option>
												<option value="1684">+1684/American samoa</option>
												<option value="376">+376/Andorra</option>
												<option value="244">+244/Angola</option>
												<option value="1264">+1264/Anguilla</option>
												<option value="1268">+1268/Antigua and barbuda</option>
												<option value="54">+54/Argentina</option>
												<option value="374">+374/Armenia</option>
												<option value="297">+297/Aruba</option>
												<option value="61">+61/Australia</option>
												<option value="43">+43/Austria</option>
												<option value="994">+994/Azerbaijan</option>
												<option value="1242">+1242/Bahamas</option>
												<option value="880">+880/Bangladesh</option>
												<option value="1246">+1246/Barbados</option>
												<option value="375">+375/Belarus</option>
												<option value="32">+32/Belgium</option>
												<option value="501">+501/Belize</option>
												<option value="229">+229/Benin</option>
												<option value="1441">+1441/Bermuda</option>
												<option value="975">+975/Bhutan</option>
												<option value="591">+591/Bolivia</option>
												<option value="387">+387/Bosnia and herzegovina</option>
												<option value="267">+267/Botswana</option>
												<option value="55">+55/Brazil</option>
												<option value="1284">+1284/British Virgin Islands</option>
												<option value="673">+673/Brunei darussalam</option>
												<option value="359">+359/Bulgaria</option>
												<option value="226">+226/Burkina faso</option>
												<option value="257">+257/Burundi</option>
												<option value="855">+855/Cambodia</option>
												<option value="237">+237/Cameroon</option>
												<option value="1">+1/Canada</option>
												<option value="238">+238/Cape verde</option>
												<option value="1345">+1345/Cayman islands</option>
												<option value="236">+236/Central african republic</option>
												<option value="235">+235/Chad</option>
												<option value="56">+56/Chile</option>
												<option value="86">+86/China</option>
												<option value="61">+61/Christmas island</option>
												<option value="61">+61/Cocos (keeling) islands</option>
												<option value="57">+57/Colombia</option>
												<option value="269">+269/Comoros</option>
												<option value="242">+242/Congo</option>
												<option value="243">+243/Congo, the democratic republic</option>
												<option value="682">+682/Cook islands</option>
												<option value="506">+506/Costa Rica</option>
												<option value="225">+225/Cote d'ivoire</option>
												<option value="385">+385/Croatia</option>
												<option value="53">+53/Cuba</option>
												<option value="357">+357/Cyprus</option>
												<option value="420">+420/Czech republic</option>
												<option value="420">+420/Czechoslovakia</option>
												<option value="45">+45/Denmark</option>
												<option value="253">+253/Djibouti</option>
												<option value="1767">+1767/Dominica</option>
												<option value="1809">+1809/Dominican republic</option>
												<option value="593">+593/Ecuador</option>
												<option value="20">+20/Egypt</option>
												<option value="503">+503/El salvador</option>
												<option value="240">+240/Equatorial guinea</option>
												<option value="291">+291/Eritrea</option>
												<option value="372">+372/Estonia</option>
												<option value="251">+251/Ethiopia</option>
												<option value="500">+500/Falkland islands (malvinas)</option>
												<option value="298">+298/Faroe islands</option>
												<option value="679">+679/Fiji</option>
												<option value="358">+358/Finland</option>
												<option value="33">+33/France</option>
												<option value="689">+689/French polynesia</option>
												<option value="241">+241/Gabon</option>
												<option value="220">+220/Gambia</option>
												<option value="502">+502/Gautemala</option>
												<option value="995">+995/Georgia</option>
												<option value="49">+49/Germany</option>
												<option value="233">+233/Ghana</option>
												<option value="350">+350/Gibraltar</option>
												<option value="30">+30/Greece</option>
												<option value="299">+299/Greenland</option>
												<option value="1473">+1473/Grenada</option>
												<option value="502">+502/Guatemala</option>
												<option value="224">+224/Guinea</option>
												<option value="245">+245/Guinea-bissau</option>
												<option value="592">+592/Guyana</option>
												<option value="509">+509/Haiti</option>
												<option value="504">+504/Honduras</option>
												<option value="852">+852/Hong kong</option>
												<option value="36">+36/Hungary</option>
												<option value="354">+354/Iceland</option>
												<option value="91">+91/India</option>
												<option value="62">+62/Indonesia</option>
												<option value="98">+98/Iran</option>
												<option value="964">+964/Iraq</option>
												<option value="353">+353/Ireland</option>
												<option value="44">+44/Isle of man</option>
												<option value="972">+972/Israel</option>
												<option value="39">+39/Italy</option>
												<option value="1876">+1876/Jamaica</option>
												<option value="81">+81/Japan</option>
												<option value="962">+962/Jordan</option>
												<option value="7">+7/Kazakhstan</option>
												<option value="254">+254/Kenya</option>
												<option value="686">+686/Kiribati</option>
												<option value="965">+965/Kuwait</option>
												<option value="996">+996/Kyrgyzstan</option>
												<option value="856">+856/Laos</option>
												<option value="371">+371/Latvia</option>
												<option value="961">+961/Lebanon</option>
												<option value="266">+266/Lesotho</option>
												<option value="231">+231/Liberia</option>
												<option value="423">+423/Liechtenstein</option>
												<option value="370">+370/Lithuania</option>
												<option value="352">+352/Luxembourg</option>
												<option value="853">+853/Macau</option>
												<option value="389">+389/Macedonia</option>
												<option value="261">+261/Madagascar</option>
												<option value="265">+265/Malawi</option>
												<option value="60">+60/Malaysia</option>
												<option value="960">+960/Maldives</option>
												<option value="223">+223/Mali</option>
												<option value="356">+356/Malta</option>
												<option value="692">+692/Marshall islands</option>
												<option value="222">+222/Mauritania</option>
												<option value="230">+230/Mauritius</option>
												<option value="52">+52/Mexico</option>
												<option value="691">+691/Micronesia</option>
												<option value="373">+373/Moldova</option>
												<option value="377">+377/Monaco</option>
												<option value="976">+976/Mongolia</option>
												<option value="1664">+1664/Montserrat</option>
												<option value="212">+212/Morocco</option>
												<option value="258">+258/Mozambique</option>
												<option value="95">+95/Myanmar</option>
												<option value="264">+264/Namibia</option>
												<option value="674">+674/Nauru</option>
												<option value="977">+977/Nepal</option>
												<option value="31">+31/Netherlands</option>
												<option value="599">+599/Netherlands antilles</option>
												<option value="687">+687/New caledonia</option>
												<option value="64">+64/New zealand</option>
												<option value="505">+505/Nicaragua</option>
												<option value="227">+227/Niger</option>
												<option value="234">+234/Nigeria</option>
												<option value="683">+683/Niue</option>
												<option value="6723">+6723/Norfolk island</option>
												<option value="1670">+1670/Northern mariana islands</option>
												<option value="47">+47/Norway</option>
												<option value="968">+968/Oman</option>
												<option value="92">+92/Pakistan</option>
												<option value="680">+680/Palau</option>
												<option value="507">+507/Panama</option>
												<option value="675">+675/Papua new guinea</option>
												<option value="595">+595/Paraguay</option>
												<option value="51">+51/Peru</option>
												<option value="63">+63/Philippines</option>
												<option value="870">+870/Pitcairn</option>
												<option value="48">+48/Poland</option>
												<option value="351">+351/Portugal</option>
												<option value="1">+1/Puerto Rico</option>
												<option value="974">+974/Qatar</option>
												<option value="40">+40/Romania</option>
												<option value="7">+7/Russian federation</option>
												<option value="250">+250/Rwanda</option>
												<option value="590">+590/Saint Barthelemy</option>
												<option value="1869">+1869/Saint kitts and nevis</option>
												<option value="1758">+1758/Saint lucia</option>
												<option value="1599">+1599/Saint Martin</option>
												<option value="508">+508/Saint pierre and miquelon</option>
												<option value="1784">+1784/Saint vincent and the grenadines</option>
												<option value="685">+685/Samoa</option>
												<option value="378">+378/San marino</option>
												<option value="239">+239/Sao tome and principe</option>
												<option value="966">+966/Saudi arabia</option>
												<option value="221">+221/Senegal</option>
												<option value="381">+381/Serbia</option>
												<option value="382">+382/Serbia and montenegro</option>
												<option value="248">+248/Seychelles</option>
												<option value="232">+232/Sierra leone</option>
												<option value="65">+65/Singapore</option>
												<option value="421">+421/Slovakia</option>
												<option value="386">+386/Slovenia</option>
												<option value="677">+677/Solomon islands</option>
												<option value="252">+252/Somalia</option>
												<option value="27">+27/South Africa</option>
												<option value="34">+34/Spain</option>
												<option value="94">+94/Sri lanka</option>
												<option value="249">+249/Sudan</option>
												<option value="597">+597/Suriname</option>
												<option value="268">+268/Swaziland</option>
												<option value="46">+46/Sweden</option>
												<option value="41">+41/Switzerland</option>
												<option value="963">+963/Syrian arab republic</option>
												<option value="992">+992/Tajikistan</option>
												<option value="255">+255/Tanzania</option>
												<option value="66">+66/Thailand</option>
												<option value="670">+670/Timor-leste</option>
												<option value="228">+228/Togo</option>
												<option value="690">+690/Tokelau</option>
												<option value="676">+676/Tonga</option>
												<option value="1868">+1868/Trinidad and Tobago</option>
												<option value="216">+216/Tunisia</option>
												<option value="90">+90/Turkey</option>
												<option value="993">+993/Turkmenistan</option>
												<option value="1649">+1649/Turks and Caicos Islands</option>
												<option value="688">+688/Tuvalu</option>
												<option value="971">+971/UAE</option>
												<option value="256">+256/Uganda</option>
												<option value="380">+380/Ukraine</option>
												<option value="+44">++44/United Kingdom</option>
												<option value="598">+598/Uruguay</option>
												<option value="1340">+1340/US Virgin Islands</option>
												<option value="1" selected="">+1/USA</option>
												<option value="998">+998/Uzbekistan</option>
												<option value="678">+678/Vanuatu</option>
												<option value="39">+39/Vatican city</option>
												<option value="58">+58/Venezuela</option>
												<option value="84">+84/Vietnam</option>
												<option value="681">+681/Wallis and futuna</option>
												<option value="967">+967/Yemen</option>
												<option value="260">+260/Zambia</option>
												<option value="263">+263/Zimbabwe</option>
											</select>
										</div>
										<span class="country_code_error text-danger"></span>
									</div>
									<div class="col-9 p-0">
										<div class="input-group input-group-lg">
											<div class="input-group-prepend ">
												<span class="input-group-text bg-gray-01 border-0 text-muted fs-18" id="inputGroup-sizing-lg">
												<i class="far fa-phone"></i></span>
											</div>
											<input type="text" class="form-control border-0 shadow-none fs-13" id="phone" name="phone"  placeholder="Your phone">
											</div>
											<span class="phone_error text-danger"></span>
									</div>
								</div>


							</div>
							<div class="form-group mb-4">
								<label for="type" class="sr-only">Type</label>
								<div class="input-group input-group-lg">
									<select name="type" id="type" class="form-control border-0 shadow-none fs-13">
										<option value="">Select Type</option>
										@foreach (App\Http\Helper\Helper::getRoles() as $role)
											<option value="{{$role->name}}">{{$role->name}}</option>
										@endforeach
									</select>
								</div>
								<span class="type_error text-danger"></span>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-4">
										<label for="reg_password" class="sr-only">Password</label>
										<div class="input-group input-group-lg">
										<div class="input-group-prepend ">
											<span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
											<i class="far fa-lock"></i>
											</span>
										</div>
										<input type="password" class="form-control border-0 shadow-none fs-13" id="reg_password" name="password" placeholder="Password">
										<div class="input-group-append">
											<span  class="input-group-text bg-gray-01 border-0 text-body fs-18">
									     	<i class="fas fa-eye" id="toggle_pwd"></i>
											</span>
										</div>
										</div>
									</div>
									<span class="password_error text-danger"></span>                               
								</div>
								<div class="col-md-6">
									<div class="form-group mb-4">
										<label for="cnf_password" class="sr-only">Confirm Password</label>
										<div class="input-group input-group-lg">
										<div class="input-group-prepend ">
											<span  class="input-group-text bg-gray-01 border-0 text-muted fs-18">
											<i class="far fa-lock"></i>
											</span>
										</div>
										<input type="password" class="form-control border-0 shadow-none fs-13" id="cnf_password" name="cnf_password" placeholder="Confirm Password">
										<div class="input-group-append">
											<span  class="input-group-text bg-gray-01 border-0 text-body fs-18">
									     	<i class="fas fa-eye" id="toggle_cfpwd"></i>
											</span>
										</div>
										</div>
									</div>
									<span class="cnf_password_error text-danger"></span>   
								</div>
							</div>
							<div class="d-flex p-2 border re-capchar align-items-center mb-4">
								<div class="form-check">
								<input class="form-check-input" type="checkbox" value="1" id="verify" name="verify" >
									<label class="form-check-label" for="verify">I'm not a robot</label>
								</div>
							</div>    
							<span class="verify_error text-danger"></span>                     
							<button type="submit" class="btn btn-primary btn-lg btn-block onwer-register">Sign up</button>
						</form>
						<div class="mt-2">By creating an account, you agree to My BNB Rentals Terms of Use and Privacy Policy. You also agree to receive mobile text alerts and notifications.
							<a class="text-heading" href="javascript:void(0)"><u>Terms of Use</u> </a> and
							<a class="text-heading" href="javascript:void(0)"><u>Privacy Policy</u></a>.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
   