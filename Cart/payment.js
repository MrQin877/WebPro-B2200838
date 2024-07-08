document.addEventListener('DOMContentLoaded', function() {
    const totalAmount = localStorage.getItem('totalAmount');
    if (totalAmount) {
        document.getElementById('amountDisplay').innerText = `RM${totalAmount}`;
        document.getElementById('amount').value = totalAmount;
    }
});

document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const amount = document.getElementById('amount').value * 100; // Razorpay amount is in cents for MYR

    const options = {
        "key": "rzp_test_30hYlhpNoKCLY8", // Replace with the Razorpay key ID
        "amount": amount,
        "currency": "MYR",
        "name": name,
        "description": "Transaction",
        "image": "Logo-L.png",
        "handler": function (response) {
            console.log("Payment Successful! Payment ID:", response.razorpay_payment_id);

            fetch('../LogRes_sys/check_session.php')
                .then(response => response.json())
                .then(data => {
                    if (data.loggedIn) {
                        const user_id = data.user_id;
                        const cart = JSON.parse(localStorage.getItem('cart')) || [];
                        
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'save_payment.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/json');
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                const response = JSON.parse(xhr.responseText);
                                if (response.status === 'success') {
                                    alert("Payment details successfully saved!");
                                    localStorage.removeItem('cart'); // Clear cart after successful payment
                                    window.location.href = '../A-HomePage/HomePage.html'; // Redirect to homepage or success page
                                } else {
                                    alert('Failed to save transaction details: ' + response.message);
                                }
                            } else {
                                alert('Failed to save transaction details. Status: ' + xhr.status);
                            }
                        };
                        xhr.onerror = function() {
                            alert('Network error occurred.');
                        };

                        const payload = JSON.stringify({ user_id, cart, payment_id: response.razorpay_payment_id, amount: document.getElementById('amount').value });
                        xhr.send(payload);
                    } else {
                        alert('Please login first.');
                        window.location.href = '../LogRes_sys/Nlogin.html'; // Redirect to login page if not logged in
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while verifying session.');
                });
        },
        "prefill": {
            "name": name,
            "email": email
        },
        "theme": {
            "color": "#3399cc"
        }
    };

    const rzp1 = new Razorpay(options);
    rzp1.open();
});
