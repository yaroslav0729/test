@php

    $tabCalculatorTitle = "";
    $tabWhatZakatTitle = "";

    $whatIsZakatTitle = "";
    $whatIsZakatText = "";

    $whatIsObligatoryTitle = "";
    $whatIsObligatoryText = "";

    $whatIsWhyWeDonateTitle = "";
    $whatIsWhyWeDonateText = "";

    $whatIsReceiveTitle = "";
    $whatIsReceiveText = "";

    $whatIsHowCalculatedTitle = "";
    $whatIsHowCalculatedText = "";

    $whatIsHowNisaabTitle = "";
    $whatIsHowNisaabText = "";

    $whatIsShouldUseTitle = "";
    $whatIsShouldUseText = "";

    $whatIsGoldTitle = "";
    $whatIsGoldText = "";

    $whatIsSilverTitle = "";
    $whatIsSilverText = "";

    $btnTitle = "";
    $btnLink = "";

    $dropdownWhatDoINeedTitle = "";
    $dropdownWhatDoINeedText = "";

    $dropdownLinkTitle = "";
    $dropdownLink = "";

    $priceSilver = "";
    $priceGold = "";

    if (isset($parameters['tab_calc_title'])) {
        $tabCalculatorTitle = $parameters['tab_calc_title'];
    }

    if (isset($parameters['tab_what_zakat_title'])) {
        $tabWhatZakatTitle = $parameters['tab_what_zakat_title'];
    }

    if (isset($parameters['w_i_zakat_title'])) {
        $whatIsZakatTitle = $parameters['w_i_zakat_title'];
    }

    if (isset($parameters['w_i_zakat_text'])) {
        $whatIsZakatText = $parameters['w_i_zakat_text'];
    }


    if (isset($parameters['w_i_obligatory_title'])) {
        $whatIsObligatoryTitle = $parameters['w_i_obligatory_title'];
    }

    if (isset($parameters['w_i_obligatory_text'])) {
        $whatIsObligatoryText = $parameters['w_i_obligatory_text'];
    }


    if (isset($parameters['w_i_donate_title'])) {
        $whatIsWhyWeDonateTitle = $parameters['w_i_donate_title'];
    }

    if (isset($parameters['w_i_donate_text'])) {
        $whatIsWhyWeDonateText = $parameters['w_i_donate_text'];
    }


    if (isset($parameters['w_i_receive_title'])) {
        $whatIsReceiveTitle = $parameters['w_i_receive_title'];
    }

    if (isset($parameters['w_i_receive_text'])) {
        $whatIsReceiveText = $parameters['w_i_receive_text'];
    }


    if (isset($parameters['w_i_calc_title'])) {
        $whatIsHowCalculatedTitle = $parameters['w_i_calc_title'];
    }

    if (isset($parameters['w_i_calc_text'])) {
        $whatIsHowCalculatedText = $parameters['w_i_calc_text'];
    }


    if (isset($parameters['w_i_nisaab_title'])) {
        $whatIsHowNisaabTitle = $parameters['w_i_nisaab_title'];
    }

    if (isset($parameters['w_i_nisaab_text'])) {
        $whatIsHowNisaabText = $parameters['w_i_nisaab_text'];
    }


    if (isset($parameters['w_i_should_title'])) {
        $whatIsShouldUseTitle = $parameters['w_i_should_title'];
    }

    if (isset($parameters['w_i_should_text'])) {
        $whatIsShouldUseText = $parameters['w_i_should_text'];
    }


    if (isset($parameters['w_i_gold_title'])) {
        $whatIsGoldTitle = $parameters['w_i_gold_title'];
    }

    if (isset($parameters['w_i_gold_text'])) {
        $whatIsGoldText = $parameters['w_i_gold_text'];
    }


    if (isset($parameters['w_i_silver_title'])) {
        $whatIsSilverTitle = $parameters['w_i_silver_title'];
    }

    if (isset($parameters['w_i_silver_text'])) {
        $whatIsSilverText = $parameters['w_i_silver_text'];
    }

    if (isset($parameters['w_i_btn_title'])) {
        $btnTitle = $parameters['w_i_btn_title'];
    }

    if (isset($parameters['w_i_btn_link'])) {
        $btnLink = $parameters['w_i_btn_link'];
    }

    if (isset($parameters['dropdown_title'])) {
        $dropdownWhatDoINeedTitle = $parameters['dropdown_title'];
    }

    if (isset($parameters['dropdown_text'])) {
        $dropdownWhatDoINeedText = $parameters['dropdown_text'];
    }

    if (isset($parameters['dropdown_link_title'])) {
        $dropdownLinkTitle = $parameters['dropdown_link_title'];
    }

    if (isset($parameters['dropdown_link'])) {
        $dropdownLink = $parameters['dropdown_link'];
    }

    if (isset($parameters['price_silver'])) {
        $priceSilver = $parameters['price_silver'];
    }

    if (isset($parameters['price_gold'])) {
        $priceGold = $parameters['price_gold'];
    }

@endphp

<div class="row">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Tab Calculate Title:</label>
            <input class="form-control" name="parameters[tab_calc_title]"
                   placeholder="Tab Calculate Title" value="{{ $tabCalculatorTitle }}"/>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Tab What is Zakat Title:</label>
            <input class="form-control" name="parameters[tab_what_zakat_title]"
                   placeholder="Tab What is Zakat Title" value="{{ $tabWhatZakatTitle }}"/>
        </div>
    </div>
</div>
<div class="col-12 mt-5"></div>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-calculate-tab" data-toggle="tab" href="#nav-calculate" role="tab"
           aria-controls="nav-calculate" aria-selected="true">Calculate my Zakat</a>
        <a class="nav-item nav-link" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab"
           aria-controls="nav-description" aria-selected="false">What is Zakat</a>
        <a class="nav-item nav-link" id="nav-dropdown-tab" data-toggle="tab" href="#nav-dropdown" role="tab"
           aria-controls="nav-dropdown" aria-selected="false">What do I need (dropdown)</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-calculate" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row mt-4">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Price Silver:</label>
                    <input type="number" class="form-control" name="parameters[price_silver]"
                           placeholder="Price silver" value="{{ $priceSilver }}"/>
                </div>

                <div class="form-group">
                    <label>Price Gold:</label>
                    <input type="number" class="form-control" name="parameters[price_gold]"
                           placeholder="Price silver" value="{{ $priceGold }}"/>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-description" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="row mt-5">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>What is Zakat title:</label>
                    <input class="form-control" name="parameters[w_i_zakat_title]"
                           placeholder="What is Zakat title" value="{{ $whatIsZakatTitle }}"/>
                </div>

                <div class="form-group">
                    <label>What is Zakat text:</label>
                    <textarea class="form-control" name="parameters[w_i_zakat_text]"
                              rows="5" placeholder="Text">{!! $whatIsZakatText !!}</textarea>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Zakat obligatory title:</label>
                    <input class="form-control" name="parameters[w_i_obligatory_title]"
                           placeholder="Zakat obligatory title" value="{{ $whatIsObligatoryTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Zakat obligatory text:</label>
                    <textarea class="form-control" name="parameters[w_i_obligatory_text]"
                              rows="5" placeholder="Zakat obligatory text">{!! $whatIsObligatoryText !!}</textarea>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Why do we donate Zakat title:</label>
                    <input class="form-control" name="parameters[w_i_donate_title]"
                           placeholder="Why do we donate Zakat title" value="{{ $whatIsWhyWeDonateTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Why do we donate Zakat text:</label>
                    <textarea class="form-control" name="parameters[w_i_donate_text]"
                              rows="5"
                              placeholder="Why do we donate Zakat text">{!! $whatIsWhyWeDonateText !!}</textarea>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Who can receive Zakat title:</label>
                    <input class="form-control" name="parameters[w_i_receive_title]"
                           placeholder="Who can receive Zakat title" value="{{ $whatIsReceiveTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Who can receive Zakat text:</label>
                    <textarea class="form-control" name="parameters[w_i_receive_text]"
                              rows="5" placeholder="Who can receive Zakat text">{!! $whatIsReceiveText !!}</textarea>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>How is Zakat calculated title:</label>
                    <input class="form-control" name="parameters[w_i_calc_title]"
                           placeholder="How is Zakat calculated title" value="{{ $whatIsHowCalculatedTitle }}"/>
                </div>

                <div class="form-group">
                    <label>How is Zakat calculated text:</label>
                    <textarea class="form-control" name="parameters[w_i_calc_text]"
                              rows="5"
                              placeholder="How is Zakat calculated text">{!! $whatIsHowCalculatedText !!}</textarea>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>How is Nisaab measured title:</label>
                    <input class="form-control" name="parameters[w_i_nisaab_title]"
                           placeholder="How is Nisaab measured title" value="{{ $whatIsHowNisaabTitle }}"/>
                </div>

                <div class="form-group">
                    <label>How is Nisaab measured text:</label>
                    <textarea class="form-control" name="parameters[w_i_nisaab_text]"
                              rows="5" placeholder="How is Nisaab measured text">{!! $whatIsHowNisaabText !!}</textarea>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Should I use gold/silver to calculate Nisaab title:</label>
                    <input class="form-control" name="parameters[w_i_should_title]"
                           placeholder="Title" value="{{ $whatIsShouldUseTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Should I use gold/silver to calculate Nisaab text:</label>
                    <textarea class="form-control" name="parameters[w_i_should_text]"
                              rows="5" placeholder="Text">{!! $whatIsShouldUseText !!}</textarea>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Gold title:</label>
                    <input class="form-control" name="parameters[w_i_gold_title]"
                           placeholder="Gold title" value="{{ $whatIsGoldTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Gold text:</label>
                    <textarea class="form-control" name="parameters[w_i_gold_text]"
                              rows="3" placeholder="Gold text">{!! $whatIsGoldText !!}</textarea>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Silver title:</label>
                    <input class="form-control" name="parameters[w_i_silver_title]"
                           placeholder="Gold title" value="{{ $whatIsSilverTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Silver text:</label>
                    <textarea class="form-control" name="parameters[w_i_silver_text]"
                              rows="3" placeholder="Gold text">{!! $whatIsSilverText !!}</textarea>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Calculate Zakat button Title:</label>
                    <input class="form-control" name="parameters[w_i_btn_title]"
                           placeholder="Calculate Zakat button Title" value="{{ $btnTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Calculate Zakat button link:</label>
                    <input class="form-control" name="parameters[w_i_btn_link]"
                           placeholder="Calculate Zakat button link" value="{{ $btnLink }}"/>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane fade" id="nav-dropdown" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="row mt-4">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>What is Zakat title:</label>
                    <input class="form-control" name="parameters[dropdown_title]"
                           placeholder="What is Zakat title" value="{{ $dropdownWhatDoINeedTitle }}"/>
                </div>

                <div class="form-group">
                    <label>What is Zakat text:</label>
                    <textarea class="form-control" name="parameters[dropdown_text]"
                              rows="7" placeholder="Text">{!! $dropdownWhatDoINeedText !!}</textarea>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Link title:</label>
                    <input class="form-control" name="parameters[dropdown_link_title]"
                           placeholder="Link title" value="{{ $dropdownLinkTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Link:</label>
                    <input class="form-control" name="parameters[dropdown_link]"
                           placeholder="Link" value="{{ $dropdownLink }}"/>
                </div>
            </div>
        </div>
    </div>

</div>




