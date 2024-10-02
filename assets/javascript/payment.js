document.getElementById('apply-promo').addEventListener('click', function() {
    const promoCode = document.getElementById('promo_code').value;

    fetch('apply_promo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ promo_code: promoCode }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('total_price').innerText = data.new_price + ' €';
            document.getElementById('final_price').value = data.new_price;  
            document.getElementById('final_price_input').value = data.new_price; 
        } else {
            alert('Code promo invalide ou expiré');
        }
    });
});
