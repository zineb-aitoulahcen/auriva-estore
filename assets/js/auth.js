// ===== AURIVA — Auth JS =====

// Validation mot de passe (register uniquement)
const form = document.querySelector('form');
const confirmInput = document.querySelector('input[name="confirm_mdp"]');

if (form && confirmInput) {
    form.addEventListener('submit', function (e) {
        const mdp     = document.querySelector('input[name="mot_de_passe"]').value;
        const confirm = confirmInput.value;

        if (mdp !== confirm) {
            e.preventDefault();
            // Afficher message d'erreur
            let alert = document.querySelector('.alert.error');
            if (!alert) {
                alert = document.createElement('div');
                alert.className = 'alert error';
                form.parentElement.insertBefore(alert, form);
            }
            alert.textContent = 'Les mots de passe ne correspondent pas.';
            confirmInput.focus();
        }
    });
}

// Focus: enlever alert au clic sur input
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('focus', () => {
        const alert = document.querySelector('.alert.error');
        if (alert) alert.style.opacity = '0.4';
    });
});
// Toggle afficher/masquer mot de passe
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
        btn.style.opacity = '1';
    } else {
        input.type = 'password';
        btn.style.opacity = '0.5';
    }
}

// Validation confirm mdp
const form = document.querySelector('form');
const confirmInput = document.getElementById('confirm');

if (form && confirmInput) {
    form.addEventListener('submit', function(e) {
        const mdp     = document.getElementById('mdp')?.value;
        const confirm = confirmInput.value;

        if (mdp && mdp !== confirm) {
            e.preventDefault();
            let alert = document.querySelector('.alert.error');
            if (!alert) {
                alert = document.createElement('div');
                alert.className = 'alert error';
                form.parentElement.insertBefore(alert, form);
            }
            alert.textContent = 'Les mots de passe ne correspondent pas.';
            confirmInput.focus();
        }
    });
}

// Fade alert on focus
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('focus', () => {
        const alert = document.querySelector('.alert.error');
        if (alert) alert.style.opacity = '0.4';
    });
});