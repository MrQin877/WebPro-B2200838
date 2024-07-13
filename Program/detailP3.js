document.addEventListener('DOMContentLoaded', () => {
    // Function to check if user is logged in (example)
    const isLoggedIn = true; // Replace with actual login check

    // Function to toggle visibility of review section based on login status
    function toggleReviewSectionVisibility() {
        const writeReviewBtn = document.getElementById('writeReviewBtn');
        const commentInput = document.getElementById('commentInput');
        const subjectSelector = document.getElementById('subjectSelector');

        if (isLoggedIn) {
            writeReviewBtn.style.display = 'block';
            commentInput.style.display = 'none';
            subjectSelector.style.display = 'none';
        } else {
            writeReviewBtn.style.display = 'none';
            commentInput.style.display = 'none';
            subjectSelector.style.display = 'none';
        }
    }

    // Initial call to toggle visibility based on login status
    toggleReviewSectionVisibility();

    // Event listener for writeReviewBtn click
    writeReviewBtn.addEventListener('click', () => {
        if (isLoggedIn) {
            toggleCommentInput('review');
        } else {
            alert('Please log in to write a review.'); // Replace with your login prompt logic
        }
    });

    // Function to toggle comment input visibility
    function toggleCommentInput(type) {
        var commentInput = document.getElementById("commentInput");
        var commentText = document.getElementById("commentText");
        var subjectSelector = document.getElementById("subjectSelector");

        // Toggle visibility of comment input and subject selector
        if (commentInput.style.display === "none" || commentInput.style.display === "") {
            commentInput.style.display = "block";
            subjectSelector.style.display = "block";
            commentText.placeholder = "Write your " + type + "...(255 Characters limit)";
        } else {
            commentInput.style.display = "none";
            subjectSelector.style.display = "none";
            document.getElementById("writeReviewBtn").textContent = "Write a Review or feedback";
        }
    }

    // Function to submit a review (already included in your code)
    function submitComment() {
        var commentText = document.getElementById("commentText").value;
        var rating = getSelectedRating(); // Implement function to get selected rating
        var subject = document.getElementById("subject").value; // Get selected subject
        var userEmail = document.getElementById("userEmail").value;

        // Validate inputs (already included in your code)
        if (commentText.length < 20) {
            displayErrorMessage("Please enter at least 20 characters for your review.");
            return;
        }

        if (userEmail === "") {
            displayErrorMessage("Please enter your email.");
            return;
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(userEmail)) {
            displayErrorMessage("Please enter a valid email address.");
            return;
        }

        // Example of AJAX request to submit review (already included in your code)
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "review.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        var formData = "review=" + encodeURIComponent(commentText) + "&star=" + rating + "&program=" + subject + "&email=" + userEmail;
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Successful submission
                    displaySubmittedReview(commentText, rating, subject, userEmail);
                    clearFormInputs();
                } else {
                    // Error handling
                    displayErrorMessage("Failed to submit review. Please try again later.");
                }
            }
        };
        xhr.send(formData);
    }

    // Function to get selected rating (already included in your code)
    function getSelectedRating() {
        var stars = document.getElementsByName("rating");

        for (var i = 0; i < stars.length; i++) {
            if (stars[i].checked) {
                return stars[i].value;
            }
        }
        return null; // No rating selected
    }

    // Function to display submitted review (already included in your code)
    function displaySubmittedReview(comment, rating, subject, userEmail) {
        var userEmailDisplay = userEmail.substr(0, 4) + '*'.repeat(userEmail.length - 4); // Display first 4 characters and hide the rest

        // Create new review element
        var reviewElement = document.createElement("div");
        reviewElement.classList.add("review-item");
        reviewElement.innerHTML = `
            <div class="review-header">
                <span class="review-rating">${rating} ★</span>
                <span class="review-info">${subject} | ${userEmailDisplay}</span>
            </div>
            <p class="review-comment">${comment}</p>
        `;

        // Insert new review at the beginning of the reviews section
        var reviewsSection = document.getElementById("reviews");
        reviewsSection.insertBefore(reviewElement, reviewsSection.firstChild);

        // Limit the number of displayed reviews to 15 (already included in your code)
        var reviewItems = reviewsSection.getElementsByClassName("review-item");
        if (reviewItems.length > 15) {
            reviewsSection.removeChild(reviewsSection.lastChild);
        }
    }

    // Function to clear form inputs (already included in your code)
    function clearFormInputs() {
        document.getElementById("commentText").value = "";
        document.getElementById("userEmail").value = "";
        document.getElementById("commentInput").style.display = "none";
        document.getElementById("subjectSelector").style.display = "none";
        document.getElementById("writeReviewBtn").textContent = "Write a Review or feedback";
    }

    // Function to display error message (already included in your code)
    function displayErrorMessage(message) {
        var errorMessageElement = document.getElementById("error-message");
        errorMessageElement.textContent = message;
    }
});
