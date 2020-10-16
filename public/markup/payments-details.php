<?php include "_header-short-w.php";?>

<!--<div class="pt-4"></div>-->
<div></div>

<div class="donated-page">
    <section class="box">
        <div class="wrap">
<form action="/">
            <p class="font-size-30 mb-5"><b>Payment details</b></p>
            <div class="text-right pb-3"><b>YOUR DETAILS</b></div>
            <div class="black-line"></div>
            <div class="pt-5"></div>
            <div class="row">
                <div class="col-1"></div>
                <div class="col-5">
                    <div class="form-group">
                        <label><b>TITLE</b> (OPTIONAL)</label>
                        <select class="form-control">
                            <option value="1">Miss</option>
                            <option value="2">Mr</option>
                        </select>
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <label><b>FIRST NAME</b></label>
                        <input type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="pt-3"></div>
            <div class="row">
                <div class="col-1"></div>
                <div class="col-5">
                    <div class="form-group">
                        <label><b>LAST NAME</b></label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <label><b>EMAIL</b></label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="text-right">
                        <label class="checkbox rPos">
                            <input type="checkbox"><span><i class="fal fa-check"></i></span>
                            <b>Stay up to date, suscribe to our Newsletter!</b>
                        </label>
                    </div>
                </div>
            </div>
            <div class="pt-5"></div>

            <div class="text-right pb-3"><b>ADDRESS & CONTACTS</b></div>
            <div class="black-line height-1"></div>
            <div class="pt-5"></div>
            <div class="row">
                <div class="col-1"></div>
                <div class="col-5">
                    <div class="form-group">
                        <label><b>FIND MY ADDRESS</b></label>
                         <input type="text" class="form-control" placeholder="Type postcode...">
                    </div>
                    <div class="text-right">
                        <a href="#" class="toggle-manual-address font-size-12 text-underline text-dark">OR ENTER MANUALLY</a>
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <label><b>CONTACT NUMBER</b> (OPTIONAL)</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="text-right">
                        <label class="checkbox rPos">
                            <input type="checkbox"><span><i class="fal fa-check"></i></span>
                            <b>Send me occasional SMS updates</b>
                        </label>
                    </div>
                </div>
            </div>

            <script>
                $(function() {
                    $('.toggle-manual-address').on('click', function (e) {
                        e.preventDefault();
                        $('.manual-address').toggle()
                    })
                } );
            </script>

            <div class="manual-address" style="display: none">
                <div class="pt-3"></div>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>ADDRESS</b> (LINE 1)</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>ADDRESS</b> (LINE 2)</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="pt-3"></div>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>CITY</b></label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>COUNTRY</b></label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="pt-3"></div>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group has-error">
                            <label><b>POST CODE</b></label>
                            <input type="text" class="form-control  is-invalid">
                            <div class="invalid-feedback"><b>*Please enter your postcode</b></div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>COUNTRY</b></label>
                            <select class="form-control">
                                <option value="1">United Kingdom</option>
                                <option value="2">USA</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-5"></div>

            <div class="gift-aid-sheet">
                <div class="mb-4"><img src="img/Gift-aid-logo-white.png" alt="" class="img-fluid"></div>
                <div class="pl-4 pr-4 mb-4">
                    <p class="font-size-20 text-white"><b>Make your donation go 25% further, for free!</b></p>
                    <p class="font-size-16 text-white">If you are a UK taxpayer, the value of your gift can be increased by 25% under the Gift Aid scheme at no extra cost to you. For example with Gift Aid, for every £1 you donate we'll receive £1.25, and it doesn't cost you a penny.</p>
                </div>
                <br>
                <div class="bg pl-4 pr-4">
                    <label class="checkbox">
                        <input type="checkbox"><span><i class="fal fa-check"></i></span>
                        <b>Yes, I am a UK taxpayer and would like Islamic Help to treat all donations I have made over the past four years and all donations I make in the future (unless I notify you otherwise) as Gift Aid donations.</b>
                    </label>
                </div>
            </div>
            <div class="pt-5"></div>

            <div class="text-right pb-3"><b>ADD A NOTE?</b></div>
            <div class="black-line height-1"></div>
            <div class="row">
                <div class="col-1"></div>
                <div class="col-10">
                    <div class="form-group">
                        <div class="pt-5"></div>
                        <label><b>NOTE</b> (ON BEHALF OF)</label>
                        <textarea rows="1" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="pt-5"></div>
            <div class="row mb-3">
                <div class="col-6">
                    <div class="toggle-view-donation">
                        <b class="mr-4">£300.00</b>
                        <span class="text-underline cursor-pointer toggle-view-donation-info">VIEW SUMMARY</span>
                    </div>
                    <span class="text-underline cursor-pointer toggle-view-donation-info">CLOSE SUMMARY</span>
                </div>
                <div class="col-6 text-right"><b>PAYMENT DETAIL</b></div>
            </div>

            <script>
                $(function() {
                    $('.toggle-view-donation-info').on('click', function (e) {
                        e.preventDefault();
                        $('.toggle-view-donation').toggleClass('open')
                        $('.donated-page .info-col').toggleClass('hide')
                    })
                } );
            </script>

            <div class="black-line height-1"></div>
            <div class="row gutter-0">
                <div class="col-6 info-col hide">
                    <div class="order-cart-list">
                        <div class="item">
                            <div class="row">
                                <div class="col-7">
                                    <p class="font-size-20 mb-0"><b>General Charity</b></p>
                                    <p class="font-size-20 mb-0">Single payment</p>
                                </div>
                                <div class="col-5 text-right"><a href="#" class="btn-remove"> <i class="fal fa-times"></i> REMOVE</a></div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-7"><p class="font-size-20 mb-0"><b>£50.00</b></p></div>
                                <div class="col-5 text-right"><input type="number" value="1" min="0" max="1000" step="1" class="color-danger"/></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row">
                                <div class="col-7">
                                    <p class="font-size-20 mb-0"><b>General Charity</b></p>
                                    <p class="font-size-20 mb-0">Single payment</p>
                                    <span>+Sadiqah</span>
                                </div>
                                <div class="col-5 text-right"><a href="#" class="btn-remove"> <i class="fal fa-times"></i> REMOVE</a></div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-7"><p class="font-size-20 mb-0"><b>£50.00</b></p></div>
                                <div class="col-5 text-right"><input type="number" value="1" min="0" max="1000" step="1" class="color-danger"/></div>
                            </div>
                        </div>
                        <div class="pt-5"></div>
                        <div class="total">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <b>DONATION TOTAL:</b>
                                </div>
                                <div class="col-6">
                                    <span>£300.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 card-col">
                    <div>
                        <div class="pt-4"></div>
                        <div class="mb-4 text-center">
                            <label class="radio mr-5">
                                <input type="radio" name="payMethod" checked><span><i class="fal fa-check"></i></span>
                                <b>PAY BY CARD</b>
                            </label>
                            <label class="radio">
                                <input type="radio" name="payMethod"><span><i class="fal fa-check"></i></span>
                                <b>PAY BY PAL</b>
                            </label>
                        </div>

                        <div class="row">
                            <div class="col-12 name-card-col">
                                <div class="form-group">
                                    <label><b>NAME ON CARD</b></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label><b>CARD NUMBER</b></label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="row gutter-5">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label><b>EXPIRY DATE</b></label>
                                            <input type="text" class="form-control" placeholder="MM / YY">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label><b>CVV</b></label>
                                            <input type="text" class="form-control" placeholder="CVV">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-danger border-white btn-submit">Pay Now</button>
                    </div>
                </div>
            </div>
</form>
        </div>
    </section>
</div>


<?php include "_footer.php";?>

</body>
</html>
