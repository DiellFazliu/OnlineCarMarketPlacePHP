document.getElementById('review-form').addEventListener('submit', function (e) {
    e.preventDefault();
  
    const name = document.getElementById('review-name').value;
    const rating = document.getElementById('review-rating').value;
    const comment = document.getElementById('review-text').value;
  
    const reviewList = document.getElementById('reviews-list');
    const newReview = document.createElement('div');
    newReview.className = 'review-item';
    newReview.innerHTML = `
      <p><strong>Emri:</strong> ${name}</p>
      <p><strong>Vlerësimi:</strong> ${'⭐️'.repeat(rating)} (${rating}/5)</p>
      <p><strong>Komenti:</strong> "${comment}"</p>
      <p class="review-date">Publikuar më: ${new Date().toLocaleDateString()}</p>
    `;
  
    reviewList.appendChild(newReview);
  
    const totalReviews = document.getElementById('total-reviews');
    const averageStars = document.getElementById('average-stars');
  
    const currentReviews = parseInt(totalReviews.textContent);
    const currentAverage = parseFloat(averageStars.textContent);
  
    const newAverage = ((currentAverage * currentReviews) + parseInt(rating)) / (currentReviews + 1);
  
    totalReviews.textContent = currentReviews + 1;
    averageStars.textContent = newAverage.toFixed(1);
  
    document.getElementById('review-form').reset();
  });
  