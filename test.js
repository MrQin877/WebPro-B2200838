document.addEventListener('DOMContentLoaded', function() {
    const circles = document.querySelectorAll('.circle');
    let currentActiveIndex = 0;

    function changeCircle() {
        // Fade out the current active circle
        circles[currentActiveIndex].style.opacity = '0';
        
        // Move to the next circle
        currentActiveIndex = (currentActiveIndex + 1) % circles.length;

        // Fade in the new active circle after a short delay
        setTimeout(() => {
            circles[currentActiveIndex].style.opacity = '1';
        }, 300); // 300ms delay matches the transition duration
    }

    // Show the first circle initially
    circles[currentActiveIndex].style.opacity = '1';

    // Change circle on button click
    document.getElementById('changeButton').addEventListener('click', changeCircle);
});

