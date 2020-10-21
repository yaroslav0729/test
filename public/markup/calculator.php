<?php include "_header-short-w.php";?>


<section class="calculator">
    <div class="wrap">
        <div class="title">
            <div class="top">
                <div class="row align-items-center">
                    <div class="col-6">
                        <b>Your Zakat Calculator</b>
                    </div>
                    <div class="col-6 text-right">
                        <div class="toggle-title">
                            <div>WHAT DO I NEED? <i class="far fa-chevron-down"></i></div>
                            <div><i class="fal fa-times"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <div class="line"></div>
                <div class="font-size-16"><b>WHAT DO I NEED?</b></div>
                <div class="pt-5"></div>
                <div>
                    <p>Some helper copy here; iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit. Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit quia voluptas.</p>
                </div>
                <div class="pt-5"></div>
                <div class="text-right">
                    <a href="#" class="text-underline font-size-16 text-white"><b>VISIT FAQS</b></a>
                </div>
            </div>
        </div>
        <nav class="general-content-tabs">
            <ul class="nav nav-tabs nav-fill" id="myTab">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-1-tab" data-toggle="tab" href="#tab-1" role="tab" aria-selected="true">CALCULATE MY ZAKAT</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-2-tab" data-toggle="tab" href="#tab-2" role="tab"  aria-selected="false">WHAT ID ZAKAT?</a>
                </li>
            </ul>
        </nav>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-1" role="tabpanel" >
                <div class="row align-items-end gutter-5">
                    <div class="col-3"></div>
                    <div class="col-5">
                        <div class="form-group mb-0">
                            <label><b>Base value of nisab</b></label>
                            <select class="form-control">
                                <option value="1">Silver</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-1"><button class="btn btn-primary h-form-control">£268.83</button></div>
                </div>
                <div class="pt-5"></div>


                <div>Enter below, your <b>total</b> assets from the past lunar year, that apply to you. </div>
                <div class="line"></div>
                <div class="text-right text-uppercase"><b>your assets</b></div>
                <div class="pt-5"></div>

                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>value of gold</b></label>
                            <input type="text" class="form-control" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>value of silver</b></label>
                            <input type="text" class="form-control" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>Cash in hand / in bank accounts</b></label>
                            <input type="text" class="form-control" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>cash deposited for future purpose</b></label>
                            <input type="text" class="form-control" placeholder="£ 0.00">
                            <small>*E.g. Saving for Hajj</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>Given out in loans</b></label>
                            <input type="text" class="form-control" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>other investments</b></label>
                            <input type="text" class="form-control" placeholder="£ 0.00">
                            <small>*E.g. Business investments, shares, saving certificates, pensions funded by money in ones possesssion</small>
                        </div>
                    </div>
                </div>

                <div class="pt-5"></div>
                <div class="line"></div>
                <div class="text-right text-uppercase"><b>Trade goods</b></div>
                <div class="pt-5"></div>

                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>value of stock</b></label>
                            <input type="text" class="form-control" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                </div>

                <div class="pt-5"></div>
                <div class="line"></div>
                <div class="text-right text-uppercase"><b>Liabilities</b></div>
                <div class="pt-5"></div>

                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>Borrowed money / items bought on credit</b></label>
                            <input type="text" class="form-control" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>wages due to employees</b></label>
                            <input type="text" class="form-control" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>taxes / rent / utility bills due immediately</b></label>
                            <input type="text" class="form-control" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                </div>
                <div class="pt-5"></div>

                <div class="calc">
                    <div class="line"></div>
                    <div class="pt-5"></div>
                    <div class="font-size-30 mb-4 text-center"><b>Calculate my Zakat</b></div>
                    <div class="text-center mb-5">
                        <button class="btn btn-secondary mr-1">Reset</button>
                        <button class="btn btn-info ml-1">Calculate now</button>
                    </div>
                    <div class="item">
                        <b>Total Assets</b>
                        <div class="row align-items-center gutter-0">
                            <div class="col-6">For your lunar year</div>
                            <div class="col-6 text-right font-size-30"><b>£0.00</b></div>
                        </div>
                    </div>
                    <div class="item">
                        <b>Zakat Payable</b>
                        <div class="row align-items-center gutter-0">
                            <div class="col-6">For your lunar year</div>
                            <div class="col-6 text-right font-size-30"><b>£0.00</b></div>
                        </div>
                    </div>

                    <div class="item bg-primary-light">
                        <b>Total Assets</b>
                        <div class="row align-items-center gutter-0">
                            <div class="col-6">For your lunar year</div>
                            <div class="col-6 text-right font-size-30 text-info"><b>£31'030.00</b></div>
                        </div>
                    </div>
                    <div class="item bg-danger-light">
                        <b>Zakat Payable</b>
                        <div class="row align-items-center gutter-0">
                            <div class="col-6">For your lunar year</div>
                            <div class="col-6 text-right font-size-30 text-danger"><b>£775.75</b></div>
                        </div>
                    </div>
                </div>

                <div class="down bg-danger-light">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="total">
                                ZAKAT TOTAL
                                <b>£0.00</b>
                                <b class="text-danger">£755.00</b>
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            <a href="#" class="btn btn-danger">Danate my Zakat</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-2" role="tabpanel">

                <div class="text">
                    <h2>What is Zakat</h2>
                    <p>Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
                    <div class="pt-5"></div>

                    <h2>Is Zakat obligatory?</h2>
                    <p>Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
                    <div class="pt-5"></div>

                    <h2>Why do we donate Zakat?</h2>
                    <p>Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
                    <div class="pt-5"></div>

                    <div class="blockquote">
                        <i>"Quote example perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium."</i>
                        <div>QUOTE REFERENCE</div>
                    </div>
                    <div class="pt-5"></div>

                    <h2>Who can receive Zakat?</h2>
                    <p>Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
                    <div class="pt-5"></div>

                    <h2>How is Zakat calculated?</h2>
                    <p>Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
                    <div class="pt-5"></div>

                    <h2>How is Nisaab measured?</h2>
                    <p>Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
                    <div class="pt-5"></div>

                    <h2>Should I use gold/silver to calculate Nisaab?</h2>
                    <p>Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
                    <div class="pt-5"></div>
                </div>

                <div class="bg-primary-light p-5 mb-2 br-5">
                    <p class="font-size-20"><b>Gold:</b></p>
                    <div class="line"></div>
                    <p class="font-size-16">Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem.
                    </p>
                </div>

                <div class="bg-primary-light p-5 mb-2 br-5">
                    <p class="font-size-20"><b>Silver:</b></p>
                    <div class="line"></div>
                    <p class="font-size-16">Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem.
                    </p>
                </div>

                <div class="pt-5"></div>
                <div class="text-center">
                    <a href="#" class="btn btn-info">Calculate my Zakat</a>
                </div>

            </div>
        </div>

    </div>
</section>



<?php include "_footer.php";?>

</body>
</html>
