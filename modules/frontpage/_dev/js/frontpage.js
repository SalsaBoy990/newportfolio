window.ready = function (handler) {
    if (/complete|loaded|interactive/.test(document.readyState) && document.body) {
        handler();
    } else {
        document.addEventListener("DOMContentLoaded", handler, false);
    }
};

window.ready(function () {

    console.log('script works...')

    /* Scroll to top button */
    var scrollToTopBtn = document.getElementById("scroll-to-top");
    scrollToTopBtn.addEventListener("click", function () {
        console.log(this);
        document.body.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    });

    // Other functionality...
});
