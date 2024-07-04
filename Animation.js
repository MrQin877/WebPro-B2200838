const observer1 = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        console.log(entry);
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
        } else {
            entry.target.classList.remove('show');
        }
    });
});

const hiddenElements1 = document.querySelectorAll('.hidden');
hiddenElements1.forEach((el) => observer1.observe(el));

const observer2 = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        console.log(entry);
        if (entry.isIntersecting) {
            entry.target.classList.add('show-lr');
        } else {
            entry.target.classList.remove('show-lr');
        }
    });
});

const hiddenElements2 = document.querySelectorAll('.hidden-l, .hidden-r'); 
hiddenElements2.forEach((el) => observer2.observe(el));

const observer3 = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        console.log(entry);
        if (entry.isIntersecting) {
            entry.target.classList.add('show-down');
        } else {
            entry.target.classList.remove('show-down');
        }
    });
});

const hiddenElements3 = document.querySelectorAll('.hidden-down'); 
hiddenElements3.forEach((el) => observer3.observe(el));

const observer4 = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        console.log(entry);
        if (entry.isIntersecting) {
            entry.target.classList.add('show-pop');
        } else {
            entry.target.classList.remove('show-pop');
        }
    });
});

const hiddenElements4 = document.querySelectorAll('.hidden-pop'); 
hiddenElements4.forEach((el) => observer4.observe(el));

