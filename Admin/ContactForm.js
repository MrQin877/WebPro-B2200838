document.addEventListener("DOMContentLoaded", function() {
    fetch("ContactForm.php")
        .then(response => response.json())
        .then(data => {
            console.log(data); // Check the response data
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                updatecontactform(data.contactform);
            }
        })
        .catch(error => {
            console.error('Error fetching forms:', error);
        });
});

function updatecontactform(contactform) {
    var formsList = document.getElementById('ContactForm');
    formsList.innerHTML = ''; // Clear existing content if needed

    contactform.forEach(function(form, index) {
        // Create elements
        var FormBox = document.createElement('div');
        FormBox.classList.add('FormBox');

        var rowbox1 = document.createElement('div');
        rowbox1.classList.add('rowbox');
        var label1 = document.createElement('label');
        label1.classList.add('box-label');
        label1.innerHTML = form.id + '.&nbsp;';
        var p1 = document.createElement('p');
        p1.classList.add('font-fam');
        p1.textContent = form.fullname;
        rowbox1.appendChild(label1);
        rowbox1.appendChild(p1);

        var rowbox2 = document.createElement('div');
        rowbox2.classList.add('rowbox');
        var label2 = document.createElement('label');
        label2.classList.add('box-label');
        label2.innerHTML = 'Email:&nbsp;';
        var p2 = document.createElement('p');
        p2.classList.add('font-fam');
        p2.textContent = form.email;
        rowbox2.appendChild(label2);
        rowbox2.appendChild(p2);

        var rowbox3 = document.createElement('div');
        rowbox3.classList.add('rowbox');
        var label3 = document.createElement('label');
        label3.classList.add('box-label');
        label3.innerHTML = 'Phone No:&nbsp;';
        var p3 = document.createElement('p');
        p3.classList.add('font-fam');
        p3.textContent = form.phoneno;
        rowbox3.appendChild(label3);
        rowbox3.appendChild(p3);

        var rowbox4 = document.createElement('div');
        rowbox4.classList.add('rowbox');
        var label4 = document.createElement('label');
        label4.classList.add('box-label');
        label4.innerHTML = 'Question:&nbsp;';
        var p4 = document.createElement('p');
        p4.classList.add('font-fam');
        p4.textContent = form.question;
        rowbox4.appendChild(label4);
        rowbox4.appendChild(p4);

        var rowbox5 = document.createElement('div');
        rowbox5.classList.add('rowbox');
        var label5 = document.createElement('label');
        label5.classList.add('box-label');
        label5.innerHTML = 'Interest Program:&nbsp;';
        var p5 = document.createElement('p');
        p5.classList.add('font-fam');
        p5.style.marginBottom = '5px';
        p5.textContent = form.program;
        rowbox5.appendChild(label5);
        rowbox5.appendChild(p5);

        // Append rowboxes to FormBox
        FormBox.appendChild(rowbox1);
        FormBox.appendChild(rowbox2);
        FormBox.appendChild(rowbox3);
        FormBox.appendChild(rowbox4);
        FormBox.appendChild(rowbox5);

        // Append FormBox to formsList
        formsList.appendChild(FormBox);

        // Add spacing between forms
        formsList.appendChild(document.createElement('br'));
    });
}
