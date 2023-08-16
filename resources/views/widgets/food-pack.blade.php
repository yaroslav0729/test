@if (\App\Models\FoodPackSettings::getStatus())
<div class="foodpack-widget" >
    <div class="foodpack-widget__img">
        <img src="/img/package-white.svg" alt="">
    </div>
    <div class="foodpack-widget__text">
        Give a food pack now
    </div>
</div>

<div class="modal modal--foodpack">
    <div class="modal--foodpack__content">
    <button class="modal--foodpack__close">×</button>
        <div class="modal--foodpack__title">
            <p>Donate A Ramadan Family Food Pack Today</p>
        </div>
        <div class="modal--foodpack__description">
            <p>Donate a Ramadan Food Pack from £40</p>
        </div>
        <form class="modal--foodpack__form">
            <div class="modal--foodpack__tabs">
                <div class="modal--foodpack__tabs_container">
                    <div class="modal--foodpack__tab active">
                        First
                    </div>
                </div>
                <div class="modal--foodpack__tabs_body">
                    <div class="modal--foodpack__tabs_body_content">
                        <p>Please select one or more countries.</p>
                        <div class="modal--foodpack__items">
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn dark modal--foodpack__btn">Add to cart</button>

        </form>
    </div>
</div>

<style>
.foodpack-widget {
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
    .foodpack-widget {
        bottom: 85px !important;
    }
}

.foodpack-widget__img {
    width: 30px;
}

.foodpack-widget__text {
    padding: 0 5px;
    font-size: 14px;
    font-family: 'Noto Sans JP', sanserif;
}

.foodpack-widget:hover {
    background: #9f303c;
}

.modal--foodpack {
    background: rgba(34, 34, 34, 0.8) !important;
}

.modal--foodpack p{
    margin: 0;
}

.modal--foodpack__close {
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

.modal--foodpack__close:hover {
    transform: translateY(-2px);
}

.modal--foodpack.open {
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal--foodpack__content {
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

.modal--foodpack__title {
    background: #232051;
    color: #f4f1e9;
    font-size: 20px;
    font-weight: 700;
    padding: 15px 50px;
}

.modal--foodpack__title p {
    margin: 0;
    text-align: center;
}

.modal--foodpack__description {
    background: #fcfcfc;
    border-bottom: 1px solid #ccc;
    font-size: 14px;
    padding: 15px 20px;
    text-align: center;
}

.modal--foodpack__form {
    padding: 30px;
    font-size: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.modal--foodpack__items {
    padding: 40px 20px;
    width: 100%;
    display: flex;
    flex-wrap: wrap;
}

.modal-foodpack__item {
    width: 100%;
    padding: 0 35px 15px 0;
    display: flex;
}

.modal--foodpack label {
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

.modal--foodpack__price {
    font-weight: bold;
    color: #F97866;
    margin-left: auto;
}

.modal--foodpack input {
    display: none
}


.modal--foodpack input:checked~.fas {
    color: #232051;
}

.modal--foodpack .fas {
    color: rgba(159, 48, 60, 0.1);
    margin: 0 10px;
    transition: all 0.3s ease-in;
}

@media (max-width: 930px) {
    .modal--foodpack label {
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

    .modal-foodpack__item {
        width: 100%;
        padding: 0;
        display: block;
    }

    .modal--foodpack__name{
       padding-right: 15px;
    }

    .modal--foodpack .fas {
        margin: 0 10px 0 0;
    }
}

.modal--foodpack__btn.btn {
    background: #F97866;
    color: #fff;
    margin: 0 auto;
    transition: all 0.3s ease-in;
    min-height: 60px;
}

.modal--foodpack__btn .spinner-border {
    width: 1.5rem;
    height: 1.5rem;
}

.modal--foodpack__btn.btn:hover {
    background: #9f303c;
}

.modal--foodpack__tab {
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
.modal--foodpack__tab.active {
    background: #232051;
    color: #f4f1e9;
}
.modal--foodpack__tabs {
    width: 100%;
}
.modal--foodpack__tabs_body_content{
    padding-top: 10px;
}
.modal--foodpack .modal--foodpack__number input {
    display: inherit;
}
.modal--foodpack__number {
    display: inline-block;
    margin-left: auto;
    margin-bottom: 15px;
}

.modal--foodpack__number input[type=number]+.input-group .btn {
    padding: 1px 12px;
}
.mobile-template .modal--foodpack__number {
    margin-left: 0px;
    margin-top: 10px;
}
.modal--foodpack__items .fas {
    font-size: 26px;
    position: relative;
}
</style>
@endif
