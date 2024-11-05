document.addEventListener("DOMContentLoaded", function() {
    const applyPromoButton = document.getElementById("apply-promo-button");
    const promoMessage = document.getElementById("promo-message");
    const totalPriceElement = document.getElementById("payment-total_price");
    const priceInput = document.getElementById("price");

    applyPromoButton.addEventListener("click", function() {
        const promoCode = document.getElementById("promo_code").value;
        const originalPrice = priceInput.value;

        fetch("apply-promo-code", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `promo_code=${encodeURIComponent(promoCode)}&price=${encodeURIComponent(originalPrice)}`,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                totalPriceElement.textContent = `${data.new_price} €`;
                priceInput.value = data.new_price;
                promoMessage.textContent = "Code promo appliqué avec succès !";
                promoMessage.style.color = "green";
            } else {
                promoMessage.textContent = "Code promo invalide.";
                promoMessage.style.color = "red";
            }
        })
        .catch(error => {
            promoMessage.textContent = "Erreur lors de la vérification du code promo.";
            promoMessage.style.color = "red";
            console.error("Erreur:", error);
        });
    });
});
