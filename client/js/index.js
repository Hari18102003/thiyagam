let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    if (n > slides.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = slides.length }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
}

document.addEventListener("DOMContentLoaded", () => {
    const text = document.querySelector(".hidden-text");

    const onScroll = () => {
        const rect = text.getBoundingClientRect();
        const windowHeight = window.innerHeight;

        if (rect.top < windowHeight && rect.bottom >= 0) {
            text.classList.add("visible"); // Add the visible class when text is in view
        }
    };

    window.addEventListener("scroll", onScroll);
});

let currentIndex = 0;
const totalSlides = document.querySelectorAll('.slide').length;
const slidesPerView = 3;
const slider = document.querySelector('.slider');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

function updateButtons() {
    prevButton.disabled = false;
    nextButton.disabled = false;
}

function moveSlide(direction) {
    currentIndex = (currentIndex + direction * slidesPerView + totalSlides) % totalSlides;

    slider.style.transform = `translateX(-${(currentIndex * (100 / slidesPerView))}%)`;
    updateButtons();
}

updateButtons();




