// Toggle du menu utilisateur
const userBtn = document.querySelector('.user-btn');
const userDropdown = document.querySelector('.user-dropdown');

if (userBtn && userDropdown) {
    userBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        userDropdown.classList.toggle('open');
    });

    // Fermer si on clique ailleurs
    document.addEventListener('click', function () {
        userDropdown.classList.remove('open');
    });
}

document.getElementById('filterPrix').addEventListener('input', function() {
  document.getElementById('prixVal').textContent = '≤ ' + this.value + ' MAD';
});