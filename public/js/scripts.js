window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        } else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            offset: 74,
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

    function generatePhotoSwipeGallery(galleryData, galleryContainerId) {
        const pswpGalleryEl = document.querySelector(`#${galleryContainerId}`);

        // Create an array to store the photoswipe items
        const items = [];

        // Iterate over the gallery data and create photoswipe items
        galleryData.forEach((data) => {
            const item = {
                gallery_id: data.gallery_id,
                src: data.src,
                w: data.width,
                h: data.height,
                title: data.title,
                description: data.description,
            };

            items.push(item);

            // Create an anchor element for each image
            const anchorEl = document.createElement('a');
            anchorEl.setAttribute('data-id', data.id);
            anchorEl.setAttribute('href', 'assets/galleries/' + data.gallery_id + '/' + data.src);
            anchorEl.setAttribute('target', '_blank');

            // Create an image element for the thumbnail
            const imgEl = document.createElement('img');
            imgEl.setAttribute('class', 'img-thumbnail img-fluid mb-3 mb-lg-0');
            imgEl.setAttribute('src', data.src);
            imgEl.setAttribute('alt', '...');

            // Append the image element to the anchor element
            anchorEl.appendChild(imgEl);

            // Append the anchor element to the gallery container
            pswpGalleryEl.appendChild(anchorEl);
        });

        // Initialize the PhotoSwipe gallery
        const lightbox = new PhotoSwipe(pswpGalleryEl, PhotoSwipeUI_Default, items, {
            // Add any additional options or callbacks as needed
        });

        // Open the gallery when a thumbnail is clicked
        pswpGalleryEl.addEventListener('click', (e) => {
            e.preventDefault();
            const target = e.target.closest('a');
            if (target) {
                const id = parseInt(target.getAttribute('data-id'), 10);
                lightbox.goTo(id - 1);
                lightbox.init();
            }
        });
    }

    // Get the current year
    // Set the current year in the copyright text
    document.getElementById("copyright-year").textContent = new Date().getFullYear();


});
