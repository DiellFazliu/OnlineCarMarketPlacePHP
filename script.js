let currentIndex = 0;
const images = document.querySelectorAll('.slideshow img');
const totalImages = images.length;

function slideShow() {
  // Move to the next image (negative value to slide images up)
  currentIndex = (currentIndex + 1) % totalImages;

  // Set the transform to create an upward sliding effect
  const slideshow = document.querySelector('.slideshow');
  slideshow.style.transform = `translateY(-${currentIndex * 100}%)`;
}

// Change image every 3 seconds
setInterval(slideShow, 3000);
