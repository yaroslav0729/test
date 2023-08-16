$(function() {
    if (document.body.classList.contains("mobile-template")) {
        const globalBanner = document.querySelector(".global-banner");
        const wrapper = document.querySelector(".wrapper");
        const header = document.querySelector("header");
        if (globalBanner) {
            window.addEventListener("scroll", function() {
                const scrollTop = window.pageYOffset;
                if (scrollTop > globalBanner.scrollHeight) {
                    header.classList.add("position-fixed");
                    globalBanner.classList.add("d-none");
                    wrapper.classList.remove("pt-0");
                    wrapper.classList.add("header-fixed");
                } else {
                    header.classList.remove("position-fixed");
                    globalBanner.classList.remove("d-none");
                    wrapper.classList.add("pt-0");
                    wrapper.classList.remove("header-fixed");
                }
            });
        } else {
            window.addEventListener("scroll", function() {
                if (window.pageYOffset > 115) {
                    wrapper.classList.add("header-fixed");
                } else {
                    wrapper.classList.remove("header-fixed");
                }
            });
        }
    }
});
