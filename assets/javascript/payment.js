document.addEventListener('DOMContentLoaded', function() {
    const applyPromoBtn = document.getElementById('apply-promo');
    const promoCodeInput = document.getElementById('promo_code');

    applyPromoBtn.addEventListener('click', function() {
        const promoCode = promoCodeInput.value;
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
                const originalPrice = price;
                const newPrice = data.new_price;

                const oldPriceSpan = document.createElement('span');
                oldPriceSpan.textContent = `${originalPrice} €`;
                oldPriceSpan.style.textDecoration = 'line-through';
                oldPriceSpan.style.color = 'gray';

                const newPriceSpan = document.createElement('span');
                newPriceSpan.textContent = ` ${newPrice} €`;
                newPriceSpan.style.color = 'red';
                newPriceSpan.style.fontWeight = 'bold';

                const totalPriceElement = document.getElementById('payment-total_price');
                totalPriceElement.textContent = ''; 
                totalPriceElement.appendChild(oldPriceSpan);
                totalPriceElement.appendChild(newPriceSpan);

                document.getElementById('final_price').value = newPrice;
                document.getElementById('final_price_input').value = newPrice;

                document.getElementById('promo_error').innerText = ''; 
            } else {
                document.getElementById('promo_error').innerText = 'Code promo invalide ou expiré';
            }
        })
        .catch(error => {
            console.error('Erreur lors de la requête:', error);
        });
    });
});