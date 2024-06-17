document.addEventListener('DOMContentLoaded', () => {
    const programs = [
        { title: 'Malay Language', description: 'Learn Malay language basics.', icon: 'icons/malay.png' },
        { title: 'English Language', description: 'Master English language skills.', icon: 'icons/english.png' },
        { title: 'Mathematics', description: 'Explore various math concepts.', icon: 'icons/math.png' },
        { title: 'History', description: 'Study historical events and figures.', icon: 'icons/history.png' },
        { title: 'Science', description: 'Learn about scientific principles.', icon: 'icons/science.png' },
        { title: 'All Subjects', description: 'Learn about our every programs.', icon: 'icons/all_subjects.png' }
    ];

    const programList = document.getElementById('programList');
    const suggestions = document.getElementById('suggestions');
    const searchInput = document.getElementById('searchInput');

    // Populate the program list
    programs.forEach(program => {
        const programElement = document.createElement('div');
        programElement.classList.add('program');
        programElement.onclick = () => {
            if (program.title === 'English Language') {
                showProgramDetails();
            } 
            if (program.title === 'Malay Language') {
                showProgramDetails();
            } 
            if (program.title === 'Mathematics') {
                showProgramDetails();
            } 
            if (program.title === 'Science') {
                showProgramDetails();
            } 
            if (program.title === 'History') {
                showProgramDetails();
            } 
            if (program.title === 'All Subjects') {
                showProgramDetails();
            } 
            
            else {
                searchInput.value = program.title;
                suggestions.style.display = 'none';
                searchProgram();
            }
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
            suggestion.innerHTML = `
                <div class="program-content">
                    <div class="program-info">
                        <div class="program-title">${program.title}</div>
                    </div>
                </div>
            `;
            suggestion.onclick = () => {
                if (program.title === 'English Language') {
                    showProgramDetails();
                } else {
                    searchInput.value = program.title;
                    suggestions.style.display = 'none';
                    searchProgram();
                }
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
});
