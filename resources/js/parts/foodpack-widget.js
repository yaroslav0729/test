import { refreshCardAddHtml, number_format } from './cart';

$(function () {
    const widgetBtn = document.querySelector('.foodpack-widget');
    const foodpackModal = document.querySelector('.modal--foodpack');

    if (!foodpackModal) return;

    const modalBody = document.querySelector('.modal--foodpack__content');
    const itemsContainer = document.querySelector('.modal--foodpack__items');
    const btnCloseModal = document.querySelector('.modal--foodpack__close');
    const foodpackForm = document.querySelector('.modal--foodpack__form');
    const submitBtn = document.querySelector('.modal--foodpack__btn');
    const modalTabsContainer = document.querySelector('.modal--foodpack__tabs_container');
    const modalTabsBody = document.querySelector('.modal--foodpack__tabs_body');
    const btnSpinner = `<div class="spinner-border" role="status">
    <span class="sr-only">Loading...</span>
    </div>`;
    let total;


    checkRoute();

    async function checkRoute() {
        const routePath = window.location.pathname;
        await $.ajax({
            url: `/foodpack/show?page_url=${routePath}`,
            type: 'GET',
            processData: true,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                if (!response.show) return;
                getItemsList();
            },
        });
    }

    async function getItemsList() {
        await $.ajax({
            url: '/foodpack/price',
            type: 'GET',
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                if (!response.length) return;
                widgetBtn.style.display = 'flex';
                renderItemsList(response);
                if(!sessionStorage.getItem('foodpackModalFirstTimeOpened')) {
                    foodpackModal.classList.add('open');
                    sessionStorage.setItem('foodpackModalFirstTimeOpened', "1");
                }
            },
        });
    }

    function renderItemsList(items) {

        const groups = items.reduce((groups, item) => {
            const group = (groups[item.price] || []);
            group.push(item);
            groups[item.price] = group;
            return groups;
        }, {});

        let tabs = '';
        let tabsContent = '';
        for (const [key, value] of Object.entries(groups)) {
            tabs += '<div class="modal--foodpack__tab" data-key="'+key+'">£'+key+'</div>';

            let content = '<div class="modal--foodpack__tabs_body_content" data-key="'+key+'">' +
                '<p>Please select one or more countries.</p>' +
                '<div class="modal--foodpack__items"  >';

            let listHtml = value.map(item => {
                return `
                    <div class="modal-foodpack__item">
                    <label>
                <input type="checkbox" name="countries[]" value="${item.id}" data-price="${item.price}">
                <i class="fas fa-check-circle"></i>
                    <span class="modal--foodpack__name">${item.name}</span>
                    <span class="modal--foodpack__price">£${item.price}</span>
                </label>
                <div class="modal--foodpack__number"><input type="number" input_number_spinner_food
                                data-id="${item.id}" value="1"
                                min="1" max="1000" step="1" class="color-danger" /></div>
                </div>
                `
            });
            content += listHtml.join('') + '</div></div>';
            tabsContent += content;
        }
        modalTabsContainer.innerHTML = tabs;
        modalTabsBody.innerHTML = tabsContent;

        document.querySelectorAll('.modal--foodpack__tab').forEach(item => {
            item.addEventListener('click', changeTab)
        });
        hideAllTabs();
        document.querySelector('.modal--foodpack__tabs_body_content:first-child').style.display = 'block';
        document.querySelector('.modal--foodpack__tab:first-child').classList.add("active");
        $(".modal--foodpack__number [input_number_spinner_food]").inputSpinner();

        foodpackForm.querySelectorAll('[input_number_spinner_food]').forEach(item => {
            item.addEventListener("change", function (event) {
                let checkbox = event.target.closest(".modal-foodpack__item").querySelector('[type="checkbox"]');
                    if(!checkbox.checked) {
                        checkbox.click();
                    }
            })
        });
    }

    if (widgetBtn) {
        widgetBtn.addEventListener('click', onShowFoodpackModal);
        btnCloseModal.addEventListener('click', onHideFoodpackModal);
        foodpackForm.addEventListener('submit', onSubmitForm);
        foodpackModal.addEventListener('click', onBackgroundClick)
    }

    function changeTab(e) {
        e.preventDefault();
        hideAllTabs();
        document.querySelector('.modal--foodpack__tabs_body_content[data-key="'+e.target.dataset.key+'"]').style.display = 'block';
        e.target.classList.add("active");
    }

    function hideAllTabs() {
        hide(document.querySelectorAll('.modal--foodpack__tabs_body_content'));

        var elems = document.querySelectorAll(".modal--foodpack__tab");
        [].forEach.call(elems, function(el) {
            el.classList.remove("active");
        });
    }

    function hide (elements) {
        elements = elements.length ? elements : [elements];
        for (var index = 0; index < elements.length; index++) {
            elements[index].style.display = 'none';
        }
    }

    function onShowFoodpackModal(e) {
        e.preventDefault();
        foodpackModal.classList.add('open');
    }

    function onHideFoodpackModal(e) {
        e.preventDefault();
        foodpackModal.classList.remove('open');
    }

    async function onSubmitForm(e) {
        e.preventDefault();
        await addToCart();
    }

    async function addToCart() {
        const items = [];
        foodpackForm.querySelectorAll('input').forEach(item => {
            if (item.checked) {
                let numberOfItems = item.closest(".modal-foodpack__item").querySelector('[input_number_spinner_food]').value;
                for(let i=0; i<numberOfItems; i++) {
                    items.push({id: item.value, price: item.dataset.price});
                }
            }
        })
        if (!items.length) {
            toastr.error("Please, choose one or more of these countries", "Error");
            return;
        }

        submitBtn.innerHTML = btnSpinner;

        total = items.reduce((acc, cur) => {
            return acc += +cur.price;
        }, 0);
        $("#add_to_cart_popup .amount").text(number_format(total, 2, ".", ","));
        $("#add_to_cart_popup .period").text("");


        try {
            for (const item of items) {
                try {
                    const response = await sendRequest(item);
                    refreshCardAddHtml(response);
                } catch (error) {
                    toastr.error("Unknown error, please try again later", "Error");
                    throw error
                }
            }

            foodpackForm.reset();
            foodpackForm.querySelectorAll('[input_number_spinner_food]').forEach(item => {
                item.setValue(1);
            });
            foodpackModal.classList.remove('open');
            window.location = '/cart/payment';
            $("#add_to_cart_popup").toggleClass('show-up');
            setTimeout(() => {
                $("#add_to_cart_popup").toggleClass('show-up');
                $("#add_to_cart_popup").toggleClass('show-out');
            }, 5000)
        }
        finally {
            submitBtn.innerHTML = 'Add to cart';
        }
    }

    async function sendRequest(item) {
        let formData = new FormData();
        formData.append('food_pack_id', item.id);
        formData.append('amount', item.price);

        return await $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
        });
    }

    function onBackgroundClick(e) {
        if (!e.target.closest('.modal--foodpack__content')) {
            foodpackModal.classList.remove('open');
        }
    }
})
