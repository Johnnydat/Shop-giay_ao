<div class="slider-container">
    {{-- Check if there are any slides --}}
    @if ($slides->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            Không có slide nào để hiển thị.
        </div>
        @return;
    @endif

    {{-- Carousel --}}
    <div id="simpleCarousel" class="carousel slide simple-carousel" data-bs-ride="carousel">

        {{-- Indicators --}}
        <div class="carousel-indicators simple-indicators">
            @foreach ($slides as $index => $slide)
                <button type="button" data-bs-target="#simpleCarousel" data-bs-slide-to="{{ $index }}"
                    class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                    aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>

        {{-- Slides --}}
        <div class="carousel-inner">
            @foreach ($slides as $index => $slide)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $slide->image) }}" class="d-block w-100 slide-img"
                        alt="{{ $slide->title }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">

                </div>
            @endforeach
        </div>

        {{-- Controls --}}
        <button class="carousel-control-prev simple-control" type="button" data-bs-target="#simpleCarousel"
            data-bs-slide="prev">
            <i class="fas fa-chevron-left" aria-hidden="true"></i>
            <span class="visually-hidden">Trước</span>
        </button>
        <button class="carousel-control-next simple-control" type="button" data-bs-target="#simpleCarousel"
            data-bs-slide="next">
            <i class="fas fa-chevron-right" aria-hidden="true"></i>
            <span class="visually-hidden">Sau</span>
        </button>
    </div>
</div>

{{-- Include styles --}}
<style>
    /* Import clean font */
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap");

    /* Root variables for easy customization */
    :root {
        --primary-color: #0d6efd;
        --success-color: #198754;
        --warning-color: #ffc107;
        --info-color: #0dcaf0;
        --dark-color: #212529;
        --light-color: #f8f9fa;
        --white: #ffffff;
        --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        --border-radius: 8px;
        --transition: all 0.3s ease;
    }

    /* Base styles */
    * {
        box-sizing: border-box;
    }

    body {
        font-family: "Inter", sans-serif;
        line-height: 1.6;
    }

    /* Slider container - Full width */
    .slider-container {
        width: 100vw;
        max-width: 100vw;
        margin: 0;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    /* Simple carousel - Full viewport width */
    .simple-carousel {
        border-radius: 0;
        overflow: hidden;
        box-shadow: none;
        background: var(--white);
        height: 500px;
        width: 100vw;
    }

    /* Slide image - Full width coverage */
    .slide-img {
        height: 500px;
        width: 100vw;
        object-fit: cover;
        object-position: center;
        filter: brightness(0.85);
    }

    /* Simple indicators */
    .simple-indicators {
        bottom: 20px;
        margin-bottom: 0;
    }

    .simple-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid var(--white);
        background-color: rgba(255, 255, 255, 0.5);
        margin: 0 4px;
        transition: var(--transition);
    }

    .simple-indicators button.active {
        background-color: var(--white);
        transform: scale(1.2);
    }

    .simple-indicators button:hover {
        background-color: rgba(255, 255, 255, 0.8);
    }

    /* Simple caption */
    .simple-caption {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        width: 90%;
        max-width: 600px;
    }

    .caption-wrapper {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow);
        color: var(--dark-color);
    }

    .caption-title {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--dark-color);
    }

    .caption-text {
        font-size: 1.1rem;
        font-weight: 400;
        margin-bottom: 1.5rem;
        color: #6c757d;
        line-height: 1.5;
    }

    .caption-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .caption-buttons .btn {
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        transition: var(--transition);
        text-decoration: none;
    }

    .caption-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    /* Simple controls */
    .simple-control {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        color: var(--dark-color);
        font-size: 1.2rem;
        transition: var(--transition);
        box-shadow: var(--shadow);
    }

    .simple-control:hover {
        background: var(--white);
        color: var(--primary-color);
        transform: scale(1.1);
    }

    .simple-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    /* Badge styles */
    .badge {
        font-size: 0.8rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 15px;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .simple-carousel {
            height: 400px;
            width: 100vw;
        }

        .slide-img {
            height: 400px;
            width: 100vw;
        }

        .caption-wrapper {
            padding: 1.5rem;
            margin: 0 1rem;
        }

        .caption-title {
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .caption-text {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .caption-buttons {
            flex-direction: column;
            align-items: center;
        }

        .caption-buttons .btn {
            width: 100%;
            max-width: 200px;
        }

        .simple-control {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .simple-carousel {
            height: 350px;
            width: 100vw;
        }

        .slide-img {
            height: 350px;
            width: 100vw;
        }

        .caption-wrapper {
            padding: 1rem;
        }

        .caption-title {
            font-size: 1.25rem;
        }

        .caption-text {
            font-size: 0.9rem;
        }

        .simple-indicators {
            bottom: 15px;
        }

        .simple-indicators button {
            width: 10px;
            height: 10px;
            margin: 0 3px;
        }
    }

    /* Loading state */
    .slide-loading {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200px 100%;
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% {
            background-position: -200px 0;
        }

        100% {
            background-position: calc(200px + 100%) 0;
        }
    }

    /* Smooth transitions */
    .carousel-item {
        transition: transform 0.6s ease-in-out;
    }

    /* Focus styles for accessibility */
    .simple-control:focus,
    .simple-indicators button:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }

    /* High contrast mode support */
    @media (prefers-contrast: high) {
        .caption-wrapper {
            background: var(--white);
            border: 2px solid var(--dark-color);
        }

        .simple-control {
            background: var(--white);
            border: 2px solid var(--dark-color);
        }
    }

    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {

        .carousel-item,
        .simple-control,
        .simple-indicators button,
        .caption-buttons .btn {
            transition: none;
        }
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Initialize carousel
        const carouselElement = document.querySelector("#simpleCarousel")

        if (carouselElement) {
            const carousel = new bootstrap.Carousel(carouselElement, {
                interval: 5000, // 5 seconds
                wrap: true,
                pause: "hover",
                keyboard: true,
                touch: true,
            })

            // Pause carousel when tab is not visible
            document.addEventListener("visibilitychange", () => {
                if (document.hidden) {
                    carousel.pause()
                } else {
                    carousel.cycle()
                }
            })

            // Add keyboard navigation
            document.addEventListener("keydown", (e) => {
                if (e.target.closest(".simple-carousel")) {
                    if (e.key === "ArrowLeft") {
                        e.preventDefault()
                        carousel.prev()
                    } else if (e.key === "ArrowRight") {
                        e.preventDefault()
                        carousel.next()
                    }
                }
            })

            // Add touch/swipe support for better mobile experience
            let startX = 0
            let endX = 0
            const minSwipeDistance = 50

            carouselElement.addEventListener(
                "touchstart",
                (e) => {
                    startX = e.touches[0].clientX
                }, {
                    passive: true
                },
            )

            carouselElement.addEventListener(
                "touchend",
                (e) => {
                    endX = e.changedTouches[0].clientX
                    handleSwipe()
                }, {
                    passive: true
                },
            )

            function handleSwipe() {
                const swipeDistance = startX - endX

                if (Math.abs(swipeDistance) > minSwipeDistance) {
                    if (swipeDistance > 0) {
                        // Swipe left - next slide
                        carousel.next()
                    } else {
                        // Swipe right - previous slide
                        carousel.prev()
                    }
                }
            }

            // Add loading state for images
            const images = carouselElement.querySelectorAll(".slide-img")
            images.forEach((img) => {
                img.addEventListener("load", function() {
                    this.classList.remove("slide-loading")
                })

                img.addEventListener("error", function() {
                    this.classList.remove("slide-loading")
                    this.alt = "Không thể tải hình ảnh"
                })

                // Add loading class initially
                if (!img.complete) {
                    img.classList.add("slide-loading")
                }
            })

            // Add smooth scroll to anchor links in captions
            const captionLinks = carouselElement.querySelectorAll('.caption-buttons a[href^="#"]')
            captionLinks.forEach((link) => {
                link.addEventListener("click", function(e) {
                    const href = this.getAttribute("href")
                    const target = document.querySelector(href)

                    if (target) {
                        e.preventDefault()
                        target.scrollIntoView({
                            behavior: "smooth",
                            block: "start",
                        })
                    }
                })
            })

            // Add analytics tracking (optional)
            carouselElement.addEventListener("slide.bs.carousel", (e) => {
                // Track slide changes
                console.log(`Slide changed to: ${e.to + 1}`)

                // You can add Google Analytics or other tracking here
                // gtag('event', 'slide_change', {
                //     'slide_number': e.to + 1
                // });
            })

            // Auto-adjust height based on content (optional)
            function adjustCarouselHeight() {
                const activeSlide = carouselElement.querySelector(".carousel-item.active")
                const activeCaption = activeSlide.querySelector(".caption-wrapper")

                if (activeCaption && window.innerWidth <= 768) {
                    const captionHeight = activeCaption.offsetHeight
                    const minHeight = Math.max(350, captionHeight + 100)
                    carouselElement.style.height = minHeight + "px"
                }
            }

            // Adjust height on slide change and window resize
            carouselElement.addEventListener("slid.bs.carousel", adjustCarouselHeight)
            window.addEventListener("resize", adjustCarouselHeight)

            // Initial height adjustment
            adjustCarouselHeight()
        }

        // Handle no slides case
        const slides = document.querySelectorAll(".carousel-item")
        const noSlidesAlert = document.getElementById("noSlidesAlert")

        if (slides.length === 0 && noSlidesAlert) {
            noSlidesAlert.classList.remove("d-none")
            if (carouselElement) {
                carouselElement.style.display = "none"
            }
        }
    })
</script>
