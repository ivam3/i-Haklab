var isInViewport = function (elem) {
    var distance = elem.getBoundingClientRect();
    return (
        distance.top >= 0 &&
        distance.bottom <= ((window.innerHeight) || (document.documentElement.clientHeight))
    );
};

let targets = document.querySelectorAll('.target');
let navlinks = document.querySelectorAll('.tocHeader a');

document.addEventListener('scroll', function () {

    if (targets.length < 1) {
        targets = document.querySelectorAll('.target');
    }

    if (navlinks.length < 1) {
        navlinks = document.querySelectorAll('.tocHeader a');
    }

    targets.forEach(function(target, index, arr){

        var anchor = target.getAttribute('name');
        var navlink = document.querySelector('[href="#'+anchor+'"]');

        if (isInViewport(target)) {

            if (navlink) {
                navlink.classList.add('active');
            }
        } else {
            if (navlink) {
                navlink.classList.remove('active');
            }
        }
    });
}, {
    passive: true
});