
let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-slide');
const indicators = document.querySelectorAll('.indicator');
const totalSlides = slides.length;


function showSlide(index) {
    // Remove active class from all slides and indicators
    slides.forEach(slide => slide.classList.remove('active'));
    indicators.forEach(indicator => indicator.classList.remove('active'));

    // Add active class to current slide and indicator
    slides[index].classList.add('active');
    indicators[index].classList.add('active');

    currentSlide = index;
}


function nextSlide() {
    let next = (currentSlide + 1) % totalSlides;
    showSlide(next);
}


let autoPlay = setInterval(nextSlide, 3000);

// Manual navigation with indicators
indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => {
        showSlide(index);
        // Reset autoplay timer when manually changing slides
        clearInterval(autoPlay);
        autoPlay = setInterval(nextSlide, 4000);
    });
});

// Pause autoplay when user hovers over carousel (optional enhancement)
const carouselContainer = document.querySelector('.hero-carousel');
carouselContainer.addEventListener('mouseenter', () => {
    clearInterval(autoPlay);
});

carouselContainer.addEventListener('mouseleave', () => {
    autoPlay = setInterval(nextSlide, 4000);
});


document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#' && href !== '') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});
