const initSlider = () => {
    const imageList = document.querySelector(".slider-wrapper .image-list");
    const slideButtons = document.querySelectorAll(".slider-wrapper .slide-button");
    const sliderScrollbar = document.querySelector(".container .slider-scrollbar");
    const scrollbarThumb = sliderScrollbar.querySelector(".scrollbar-thumb");
    const maxScrollLeft = imageList.scrollWidth - imageList.clientWidth;
    let successMessageVisible = false;

    // Function to check if success message is visible
    const isSuccessMessageVisible = () => {
        const successMessage = document.getElementById("successMessage");
        return successMessage && successMessage.offsetWidth > 0 && successMessage.offsetHeight > 0;
    };

    // Handle scrollbar thumb drag
    scrollbarThumb.addEventListener("mousedown", (e) => {
        // Check if success message is visible, and if so, return
        if (isSuccessMessageVisible()) return;

        // Rest of your existing code for thumb drag...
    });

    // Slide images according to the slide button clicks
    slideButtons.forEach(button => {
        button.addEventListener("click", () => {
            // Check if success message is visible, and if so, return
            if (isSuccessMessageVisible()) return;

            // Rest of your existing code for sliding images...
        });
    });

    // Rest of your existing code...

    // Call these two functions when image list scrolls
    imageList.addEventListener("scroll", () => {
        // Check if success message is visible
        successMessageVisible = isSuccessMessageVisible();

        // If success message is not visible, update scrollbar thumb position and slide buttons
        if (!successMessageVisible) {
            updateScrollThumbPosition();
            handleSlideButtons();
        }
    });
};

window.addEventListener("resize", initSlider);
window.addEventListener("load", initSlider);
