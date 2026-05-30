document.getElementById('filterPrix').addEventListener('input', function() {
  document.getElementById('prixVal').textContent = '≤ ' + this.value + ' MAD';
});