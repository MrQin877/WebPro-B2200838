document.addEventListener("DOMContentLoaded", function() {
    fetch("../headers.html")
        .then(response => response.text())
        .then(data => {
            document.querySelector("headers").innerHTML = data;
        });
});

document.addEventListener("DOMContentLoaded", function() {
    fetch("../footers.html")
        .then(response => response.text())
        .then(data => {
            document.querySelector("footers").innerHTML = data;
        });
});

