document.getElementById('apply-promo').addEventListener('click', function() {
    const promoCode = document.getElementById('promo_code').value;
    const price = document.getElementById('final_price').value;

    fetch('payment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `promo_code=${promoCode}&price=${price}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('total_price').innerText = data.new_price + ' €';
            document.getElementById('final_price').value = data.new_price;
            document.getElementById('final_price_input').value = data.new_price;
            document.getElementById('promo_error').innerText = ''; 
        } else {
            document.getElementById('promo_error').innerText = 'Code promo invalide ou expiré';
        }
    })
    .catch(error => {
        console.error('Erreur lors de la requête:', error);
    });
})