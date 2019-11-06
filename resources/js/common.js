/* File that contains common functions that are used throughout the site */

import SmoothScroll from 'smooth-scroll';

/* Hides notification when the close button is clicked */
export function hideNotification() {

    const closeBtn = $('.notification__close');

    const notification = $('.notification');

    closeBtn.click(() =>{
        notification.transition('fade down');
    });
}

/* Toggle searchbar visibility on mobile */
export function toggleSearchBar() {

    const openBtn = $('#searchOpenBtn');

    const closeBtn = $('#searchCloseBtn');

    const searchMobile = $('.site-search__mobile');

    const logoAndSeach = $('.site-logo, .site-search');

    openBtn.click(() => {
        searchMobile.addClass('active');
        logoAndSeach.removeClass('active');
    });

    closeBtn.click(() => {
        searchMobile.removeClass('active');
        logoAndSeach.addClass('active');
    });
}

/* Toggle BTC converter */
export function toggleConverter(showText,hideText) {

    const converterBtn = $('#converterBtn');

    const converter = $('#converter');

    converterBtn.click(() => {

        if (converter.is(':hidden')) {

            converterBtn.find('span').text(hideText);

            converterBtn.removeClass('primary');

        } else {
            converterBtn.find('span').text(showText);

            converterBtn.addClass('primary');
        }

        converter.transition('fade down');
    });
}

/* Scroll to input with error */
export function scrollToError(errors) {
    
    const errorKeys = Object.keys(errors);

    const scroll = new SmoothScroll();

    const scrollAnchor = document.querySelector(`[data-scroll-anchor='${errorKeys[0]}']`);

    scroll.animateScroll(scrollAnchor,{},{updateURL:false});
}   