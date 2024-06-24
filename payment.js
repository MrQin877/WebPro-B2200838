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
    const amount = document.getElementById('amount').value * 100; // Razorpay amount is in the smallest currency unit, cents for MYR

    const options = {
        "key": "rzp_test_30hYlhpNoKCLY8", // Replace with the Razorpay key ID
        "amount": amount,
        "currency": "MYR",
        "name": name,
        "description": "Test Transaction",
        "image": "Logo-L.png",
        "handler": function (response){
            alert("Payment Successful! Payment ID: " + response.razorpay_payment_id);
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
