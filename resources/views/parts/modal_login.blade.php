<div class="modal fade loginModal" id="loginModal" tabindex="-1" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="text-center">
                    <div class="h2">Login</div>
                    <p>You can use your email address or your Facebook profile to log in</p>
                    <a class="btn-fb" href="//www.facebook.com/v3.2/dialog/oauth?client_id=2322573224428800&amp;scope=email&amp;redirect_uri=https://www.islamichelp.org.uk/wp-json/facebook/auth">
                        <i class="fab fa-facebook-f"></i><span>Login with Facebook</span>
                    </a>
                </div>

                <div class="line or"></div>
                <form action="/">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Email address <sup>*</sup></label>
                                <input type="text" class="form-control" placeholder="example@islamichelp.org.uk">
                            </div>
                            <div class="mt-n2">
                                <label class="checkbox">
                                    <input type="checkbox" checked>
                                    <span><i class="fas fa-check"></i></span>
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Password <sup>*</sup></label>
                                <input type="text" class="form-control" placeholder="*******">
                            </div>
                            <div class="mt-n2">
                                <a href="javascript:void(0)" onclick="$('.forgot-pass').css('display', 'block')" class="font-size-12 text-dark letter-spacing-0">Forgot password?</a>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4"></div>
                    <div class="text-center">
                        <button class="btn btn-red">
                            <span>Login</span>
                        </button>
                    </div>

                    <div class="forgot-pass" style="display: none">
                        <div class="line"></div>
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="form-group">
                                    <label>Forgot password? <sup>*</sup></label>
                                    <input type="text" class="form-control" placeholder="example@islamichelp.org.uk">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 pt-4">
                                <button class="btn btn-red">Send Email</button>
                            </div>
                        </div>
                        <p class="font-size-12 letter-spacing-0 text-red mt-0">Just enter your email, and we will send you a new password.</p>
                    </div>


                    <div class="footer">
                        Not registered? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#createModal">Create a New Account Here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade loginModal" id="createModal" tabindex="-1" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="text-center">
                    <div class="h2">+ Create account</div>
                    <p>By creating an account with us, you will be able to move through the donation checkout process faster, view and track your donations in your account area.</p>

                    <a class="btn-fb" href="https://www.facebook.com/v3.2/dialog/oauth?client_id=2322573224428800&amp;scope=email&amp;redirect_uri=https://www.islamichelp.org.uk/wp-json/facebook/auth">
                        <i class="fab fa-facebook-f"></i><span>Login with Facebook</span>
                    </a>
                </div>

                <div class="line or"></div>
                <form action="/">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>First Name <sup>*</sup></label>
                                <input type="text" class="form-control" placeholder="Matt">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Last Name <sup>*</sup></label>
                                <input type="text" class="form-control" placeholder="Tennant">
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 d-none d-md-block"></div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Email address <sup>*</sup></label>
                                <input type="text" class="form-control" placeholder="example@islamichelp.org.uk">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Password <sup>*</sup></label>
                                <input type="text" class="form-control" placeholder="*******">
                            </div>
                        </div>
                    </div>
                    <div class="pt-4"></div>
                    <div class="text-center">
                        <button class="btn btn-red">Create A New Account</button>
                    </div>
                    <div class="footer">
                        Already have an account? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#loginModal">Login here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>