document.addEventListener('DOMContentLoaded', () => {
    const programs = [
        { title: 'Malay Language', description: 'Learn Malay language basics.', icon: 'icon3.jpg', page: 'Malpage.html' },
        { title: 'English Language', description: 'Master English language skills.', icon: 'icon4.jpg', page: 'Engpage.html' },
        { title: 'Mathematics', description: 'Explore various math concepts.', icon: 'icon2.jpg', page: 'Mathpage.html' },
        { title: 'History', description: 'Study historical events and figures.', icon: 'icon5.jpg', page: 'Hispage.html' },
        { title: 'Science', description: 'Learn about scientific principles.', icon: 'icon1.jpg', page: 'Scipage.html' },
        { title: 'All Subjects', description: 'Learn about our every programs.', icon: 'icon6.jpg', page: 'Allpage.html' }
    ];

    const programList = document.getElementById('programList');
    const suggestions = document.getElementById('suggestions');
    const searchInput = document.getElementById('searchInput');

    // Populate the program list
    programs.forEach(program => {
        const programElement = document.createElement('div');
        programElement.classList.add('program');
        programElement.onclick = () => {
            showProgramDetails(program.page);
        };
        programElement.innerHTML = `
            <div class="program-content">
                <img src="${program.icon}" alt="${program.title} Icon">
                <div class="program-info">
                    <div class="program-title">${program.title}</div>
                    <div class="program-description">${program.description}</div>
                </div>
            </div>
        `;
        programList.appendChild(programElement);
    });

    // Render suggestions
    function renderSuggestions(filteredPrograms) {
        suggestions.innerHTML = '';
        filteredPrograms.forEach(program => {
            const suggestion = document.createElement('div');
            suggestion.classList.add('suggestion');
            suggestion.innerHTML = `
                <div class="program-content">
                    <div class="program-info">
                        <div class="program-title">${program.title}</div>
                    </div>
                </div>
            `;
            suggestion.onclick = () => {
                showProgramDetails(program.page);
            };
            suggestions.appendChild(suggestion);
        });
        suggestions.style.display = filteredPrograms.length > 0 ? 'block' : 'none';
    }

    // Show all suggestions
    window.showAllSuggestions = function() {
        renderSuggestions(programs);
    }

    // Filter suggestions as user types
    window.filterSuggestions = function() {
        const searchValue = searchInput.value.toLowerCase();
        const filteredPrograms = programs.filter(program =>
            program.title.toLowerCase().includes(searchValue)
        );
        renderSuggestions(filteredPrograms);
    }

    // Search programs based on input
    window.searchProgram = function() {
        const searchValue = searchInput.value.toLowerCase();
        const programElements = document.querySelectorAll('.program');

        programElements.forEach(program => {
            const title = program.querySelector('.program-title').innerText.toLowerCase();
            const description = program.querySelector('.program-description').innerText.toLowerCase();

            if (title.includes(searchValue) || description.includes(searchValue)) {
                program.style.display = 'block';
            } else {
                program.style.display = 'none';
            }
        });
    }

    // Show all programs when "All Subjects" is clicked
    window.showAllPrograms = function() {
        programList.querySelectorAll('.program').forEach(program => {
            program.style.display = 'block';
        });
    }

    // Hide suggestions when focus is lost or mouse leaves
    searchInput.addEventListener('blur', () => {
        setTimeout(() => {
            suggestions.style.display = 'none';
        }, 100); // Delay to allow click event on suggestion to fire
    });

    suggestions.addEventListener('mouseleave', () => {
        suggestions.style.display = 'none';
    });

    // JavaScript code to navigate to the detail page when a program is clicked
    function showProgramDetails(page) {
        window.location.href = page;
    }
});
