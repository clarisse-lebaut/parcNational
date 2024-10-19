document.addEventListener('DOMContentLoaded', function() {
    const cancelButtons = document.querySelectorAll('.cancel-btn');
    const modal = document.getElementById('cancel-modal');
    const confirmCancelBtn = document.getElementById('confirm-cancel-btn');
    const closeModalBtn = document.getElementById('close-modal-btn');
    let reservationIdToCancel = null;

    cancelButtons.forEach(button => {
        button.addEventListener('click', function() {
            reservationIdToCancel = this.getAttribute('data-reservation-id');
            modal.style.display = 'flex'; // Affiche la modale
        });
    });

    // Fermer la modale si on clique sur 'Non'
    closeModalBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        reservationIdToCancel = null;
    });

    // Si 'Oui', soumettre le formulaire d'annulation
    confirmCancelBtn.addEventListener('click', function() {
        if (reservationIdToCancel) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'reservationHistory.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'reservation_id';
            input.value = reservationIdToCancel;

            const submit = document.createElement('input');
            submit.type = 'hidden';
            submit.name = 'cancel_reservation';

            form.appendChild(input);
            form.appendChild(submit);

            document.body.appendChild(form);
            form.submit(); 
        }
    });
});