<div class="foodpack-qurbani-widget" >
    <div class="foodpack-qurbani-widget__img">
        <img src="/img/package-white.svg" alt="">
    </div>
    <div class="foodpack-qurbani-widget__text">
        Give Qurbani Now
    </div>
</div>

<div class="modal modal--foodpack-qurbani">
    <div class="modal--foodpack-qurbani__content">
    <button class="modal--foodpack-qurbani__close">×</button>
        <div class="modal--foodpack-qurbani__title">
            <p>Give Your Qurbani Today from £25</p>
        </div>
        <form class="modal--foodpack-qurbani__form">
            <div class="modal--foodpack-qurbani__tabs">
                <div class="modal--foodpack-qurbani__tabs_container">
                    <div class="modal--foodpack-qurbani__tab active">
                        First
                    </div>
                </div>
                <div class="modal--foodpack-qurbani__tabs_body">
                    <div class="modal--foodpack-qurbani__tabs_body_content">
                        <p>Please select one or more countries.</p>
                        <div class="modal--foodpack-qurbani__items">
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn dark modal--foodpack-qurbani__btn mt-5">Add to cart</button>

        </form>
    </div>
</div>

<style>
.foodpack-qurbani-widget {
    background: #F97866;
    border-radius: 20px;
    bottom: 10px;
    box-shadow: 1px 2px 3px 0 rgba(0, 0, 0, 0.3);
    color: #f4f1e9;
    cursor: pointer;
    display: none;
    align-items: center;
    max-width: 300px;
    padding: 5px 8px;
    position: fixed;
    right: 10px;
    width: auto;
    z-index: 10;
    font-weight: 700;
    line-height: 24px;
}


@media screen and (max-width: 700px) {
    .foodpack-qurbani-widget {
        bottom: 85px !important;
    }
}

.foodpack-qurbani-widget__img {
    width: 30px;
}

.foodpack-qurbani-widget__text {
    padding: 0 5px;
    font-size: 14px;
    font-family: 'Noto Sans JP', sanserif;
}

.foodpack-qurbani-widget:hover {
    background: #9f303c;
}

.modal--foodpack-qurbani {
    background: rgba(34, 34, 34, 0.8) !important;
}

.modal--foodpack-qurbani p{
    margin: 0;
}

.modal--foodpack-qurbani__image {
    height: 40px!important;
}

.modal--foodpack-qurbani__image2 {
    height: 40px!important;
}

.modal--foodpack-qurbani__close {
    background: transparent;
    color: #fff;
    cursor: pointer;
    font-family: serif;
    font-weight: bold;
    font-size: 32px;
    line-height: 1;
    position: absolute;
    right: 0;
    text-align: center;
    top: 0;
    transition: transform .3s ease-in;
    opacity: 1;
    padding: 10px 15px;
    border: none;
}

.modal--foodpack-qurbani__close:hover {
    transform: translateY(-2px);
}

.modal--foodpack-qurbani.open {
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal--foodpack-qurbani__content {
    height: auto;
    max-height: 80%;
    line-height: 1.4;
    width: 90%;
    max-width: 900px;
    overflow-x: hidden;
    overflow-y: auto;
    background: #f4f1e9;
    box-shadow: 15px 15px 15px 3px rgb(0 0 0 / 20%);
    font-size: 12px;
    position: relative;
    border-radius: 10px;
}

.modal--foodpack-qurbani__title {
    background: #232051;
    color: #f4f1e9;
    font-size: 20px;
    font-weight: 700;
    padding: 15px 50px;
}

.modal--foodpack-qurbani__title p {
    margin: 0;
    text-align: center;
}

.modal--foodpack-qurbani__description {
    background: #fcfcfc;
    border-bottom: 1px solid #ccc;
    font-size: 14px;
    padding: 15px 20px;
    text-align: center;
}

.modal--foodpack-qurbani__form {
    padding: 30px;
    font-size: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.modal--foodpack-qurbani__items {
    padding: 40px 20px;
    width: 100%;
    display: flex;
    flex-wrap: wrap;
}

.modal--foodpack-qurbani label {
    cursor: pointer;
    display: flex;
    font-size: 16px;
    margin-bottom: 10px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    margin-right: 25px;
    width: 70%;
}

.modal--foodpack-qurbani__price {
    font-weight: bold;
    color: #F97866;
    margin-left: 20%;
}

.modal--foodpack-qurbani input {
    display: none
}


.modal--foodpack-qurbani input:checked~.fas {
    color: #232051;
}

.modal--foodpack-qurbani .fas {
    color: rgba(159, 48, 60, 0.1);
    margin: 0 10px;
    transition: all 0.3s ease-in;
}

@media (max-width: 930px) {
    .modal--foodpack-qurbani label {
        cursor: pointer;
        display: flex;
        font-size: 16px;
        margin-bottom: 10px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        margin-right: 0;
        width: 100%;
    }

    .modal-foodpack-qurbani__item {
        width: 100%;
        padding: 0;
        display: block;
    }

    .modal--foodpack-qurbani__name{
       padding-right: 15px;
    }

    .modal--foodpack-qurbani .fas {
        margin: 0 10px 0 0;
    }
}

.modal--foodpack-qurbani__btn.btn {
    background: #F97866;
    color: #fff;
    margin: 0 auto;
    transition: all 0.3s ease-in;
    min-height: 60px;
}

.modal--foodpack-qurbani__btn .spinner-border {
    width: 1.5rem;
    height: 1.5rem;
}

.modal--foodpack-qurbani__btn.btn:hover {
    background: #9f303c;
}

.modal--foodpack-qurbani__tab {
    background: #fcfcfc;
    border-bottom: 1px solid #ccc;
    font-size: 14px;
    padding: 15px 20px;
    text-align: center;
    width: 30%;
    display: inline-block;
    margin-right: 2%;
    cursor: pointer;
}
.modal--foodpack-qurbani__tab.active {
    background: #232051;
    color: #f4f1e9;
}
.modal--foodpack-qurbani__tabs {
    width: 100%;
}
.modal--foodpack-qurbani__tabs_body_content{
    padding-top: 10px;
}
.modal--foodpack-qurbani .modal--foodpack-qurbani__number input {
    display: inherit;
}

.modal--foodpack-qurbani__number input[type=number]+.input-group .btn {
    padding: 1px 12px;
}
.modal--foodpack-qurbani .modal--foodpack-qurbani__number {
    margin-left: 30%;
    margin-top: 10px;
}
.modal--foodpack-qurbani__items .fas {
    font-size: 26px;
    position: relative;
}

.qurbani-row {
    display: flex;
    flex-wrap: wrap;
    padding: 0!important;
}


@media (max-width: 767px) {
    .text-xs-center {
        text-align: center;
    }

    .top-0-xs {
        top: 0%!important;
    }

    .xs-align-center {
        display: flex!important;
        justify-content: center;
    }

    .modal--foodpack-qurbani__price {
        font-weight: bold;
        color: #F97866;
        margin-left: 20%;
    }

    .modal--foodpack-qurbani .modal--foodpack-qurbani__number {
        margin-left: 10%;
        margin-top: 10px;
    }
}
</style>
