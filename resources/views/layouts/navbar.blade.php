<nav class="navbar navbar-light navbar-expand-lg bg-vio osahan-menu fixed-top">
  <div class="container-fluid" style="justify-content: unset; padding-bottom: 1%;">
    <a class="toggle ml-2 d-lg-none d-xl-none d-sm-block" style="font-size: 30px; color: #ffff;" href="#">
      <i class="mdi mdi-menu"></i>
    </a>
    <a class="navbar-brand d-lg-none d-xl-none d-sm-block" href="{{url('/')}}" style="width: 140px;">
      <img src="{{url('/images/full-logo.png')}}" alt="logo">
    </a>
    <a class="navbar-brand d-none d-lg-block d-xl-block mt-2 p-0 m-0" href="{{url('/')}}" style="width: 250px;">
      <img src="{{url('/images/full-logo.png')}}" alt="logo">
    </a>
    <div class="navbar-collapse" id="navbarNavDropdown">
      <div class="navbar-nav mr-auto mt-2 mt-lg-0 margin-auto top-categories-search-main">
        <div class="top-categories-search" style="z-index: 99;">
          <div class="input-group" id="searchProductsGroup" style="border-radius: 5px;padding-right: 10px;padding-left: 10px;">
            <span class="input-group-btn categories-dropdown">
              <select class="form-control-select" id="setPincode">
              @if(isset($alwaysPIN) && $alwaysPIN > 0)
                <option selected="selected" value="{{$alwaysPIN}}">{{$alwaysPIN}}</option>
              @else
                <option selected="selected" value="0">Your Pincode</option>
              @endif
              </select>
            </span>
            @if($mobile == 0) 
              <input class="form-control" placeholder="Search Products, Category and More" aria-label="Search Products, Category and More" type="text" id="searchProducts">
            @else
              <input class="form-control" placeholder="Search Products" aria-label="Search Products" type="text" id="searchProducts">
            @endif
            <span class="input-group-btn">
              <button class="btn btn-search " type="button" @if($mobile == 1) style="padding: 0 13px;" @endif ><i class="fas fa-search"></i></button>
            </span>
          </div>
          <ul class="list-group hide" style="margin-top: 10px; width: 100%; border-radius: 3px;" id="ListProducts"></ul>
        </div>
      </div>
      <div class="my-2 my-lg-0">
        <ul class="list-inline main-nav-right">
          <li class="list-inline-item cart-btn @if(isset($mobile) && $mobile == 1) hide @endif ">
            @if(isset($userId) && $userId > 0) 
              <a href="{{url('/profile')}}" class="btn btn-link">
                <i class="mdi mdi-account" style="font-size: 22px;"></i>Hi, {{$userName}}
              </a>
            @else
              <a href="#" data-target="#bd-example-modal" data-toggle="modal" class="btn btn-link">
                <i class="mdi mdi-account" style="font-size: 22px;"></i>Login/Sign Up
              </a>
            @endif
          </li>
          <li class="list-inline-item cart-btn">
            <a href="{{url('/cart')}}" class="btn btn-link border-none @if($mobile == 1) pt-3 pl-3 @endif ">
              <i class="mdi mdi-cart"></i> 
              My Cart <span id="cartHtml"> @if($cartCount > 0) <small class="cart-value">{{$cartCount}}</small> @endif </span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-light osahan-menu-2 d-none d-lg-block d-xl-block" style="margin-top: 65px;">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0 margin-auto">
        <li class="nav-item">
          <a class="nav-link shop" href="{{url('/')}}">
            <span class="mdi mdi-store"></span> Super Store
          </a>
        </li>
        @foreach($categories as $key => $value)
          @if($key > 8) @break @endif
          <li class="nav-item">
            <a href="{{url('/products/'.$value->id)}}" class="nav-link">{{$value->name}}</a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</nav>
<div class="d-lg-none d-xl-none d-sm-block" style="margin-top: 100px;"></div>

<div class="modal fade login-modal-main" id="bd-example-modal">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body pt-0" style="margin-top: -5px;">
        <div class="login-modal">
          <div class="row" style="display: initial !important;">
            <div class="pad-left-0">
              <button type="button" class="close close-top-right" data-dismiss="modal" aria-label="Close" id="beModelClose">
                <span aria-hidden="true"><i class="mdi mdi-close"></i></span>
                <span class="sr-only">Close</span>
              </button>
              <form>
                <div class="login-modal-right">
                  <div class="tab-content">
                    <div class="tab-pane active" id="loginModel" role="tabpanel">
                      <form action="{{url('/login')}}" method="POST" role="form" id="loginForm">
                        <h5 class="heading-design-h5">Login to your account</h5>
                        <fieldset class="form-group">
                          <label for="emailormobile">Enter Email/Mobile Number</label>
                          <input type="text" class="form-control" placeholder="Email/Mobile Number" id="emailormobile" name="emailormobile">
                          <div class="invalid-feedback">Email/Mobile Number Required.</div>
                        </fieldset>
                        <fieldset class="form-group">
                          <label for="password">Enter Password</label>
                          <input type="password" class="form-control" placeholder="********" id="password" name="password">
                          <div class="invalid-feedback">Password Required.</div>
                        </fieldset>
                        <fieldset class="form-group">
                          <button type="button" id="loginBtn" class="btn btn-lg btn-secondary2 btn-block">Enter to your account</button>
                        </fieldset>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="rememberme">
                          <label class="custom-control-label" for="rememberme">Remember me</label>
                        </div>
                      </form>
                    </div>

                    <div class="tab-pane" id="registerModel" role="tabpanel">
                      <h5 class="heading-design-h5">Register Now!</h5>
                      <fieldset class="form-group">
                        <label for="regName">Name</label>
                        <input type="text" class="form-control" placeholder="Enter User Name" id="regName">
                        <div class="invalid-feedback">User Name Required.</div>
                      </fieldset>
                      <fieldset class="form-group">
                        <label for="regMobile">Mobile</label>
                        <input type="number" class="form-control" placeholder="Enter Mobile Number" id="regMobile">
                        <div class="invalid-feedback" id="divRegMobile">Mobile Number Required.</div>
                      </fieldset>
                      <fieldset class="form-group">
                        <label for="regEmail">E-Mail</label>
                        <input type="email" class="form-control" placeholder="Enter Email Address" id="regEmail">
                        <div class="invalid-feedback" id="divregEmail">Email Required.</div>
                      </fieldset>
                      <fieldset class="form-group">
                        <button type="button" class="btn btn-lg btn-secondary2 btn-block" id="regProceed">Proceed</button>
                      </fieldset>
                    </div>

                    <div class="tab-pane " id="otpModel" role="tabpanel">
                      <h5 class="heading-design-h5">Enter OTP</h5>
                      <fieldset class="form-group">
                        <label for="regOTP">Enter OTP</label>
                        <input type="text" class="form-control" placeholder="Enter OTP" id="regOTP">
                        <div class="invalid-feedback" >OTP Required.</div>
                      </fieldset>
                      <fieldset class="form-group">
                        <button type="button" class="btn btn-lg btn-secondary2 btn-block" id="regSubmit">submit</button>
                      </fieldset>
                    </div>

                    <div class="tab-pane " id="passwordModel" role="tabpanel">
                      <h5 class="heading-design-h5">Login to your account</h5>
                      <fieldset class="form-group">
                        <label for="regPassword">Enter Password</label>
                        <input type="password" class="form-control" placeholder="Enter Password" id="regPassword">
                        <div class="invalid-feedback" >Password Required.</div>
                      </fieldset>
                      <fieldset class="form-group">
                        <label for="regCPassword">Confirm Password </label>
                        <input type="password" class="form-control" placeholder="Confirm Password" id="regCPassword">
                        <div class="invalid-feedback" id="divregCPassword">Password Required.</div>
                      </fieldset>
                      <div class="custom-control custom-checkbox mb-1">
                        <input type="checkbox" class="custom-control-input" id="regAgree" name="regAgree">
                        <label class="custom-control-label" for="regAgree">I Agree with <a href="#">Term and Conditions</a></label>
                      </div>
                      <fieldset class="form-group">
                        <button type="button" class="btn btn-lg btn-secondary2 btn-block" id="regCreate">Create Your Account</button>
                      </fieldset>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="text-center login-footer-tab">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#loginModel" role="tab"><i class="mdi mdi-lock"></i> LOGIN</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#registerModel" role="tab"><i class="mdi mdi-pencil"></i> REGISTER</a>
                      </li>
                    </ul>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>