// ===== DONNÉES PRODUITS =====
const allProducts = [
  { id: 1, nom: "N°5", marque: "Chanel", genre: "Femme", prix: 850, famille: "Floral", taille: "100ml", nouveau: false },
  { id: 2, nom: "Sauvage", marque: "Dior", genre: "Homme", prix: 920, famille: "Frais", taille: "100ml", nouveau: false },
  { id: 3, nom: "Black Opium", marque: "YSL", genre: "Femme", prix: 780, famille: "Oriental", taille: "50ml", nouveau: false },
  { id: 4, nom: "Libre", marque: "YSL", genre: "Mixte", prix: 860, famille: "Floral", taille: "50ml", nouveau: true },
  { id: 5, nom: "Mon Guerlain", marque: "Guerlain", genre: "Femme", prix: 750, famille: "Floral", taille: "100ml", nouveau: false },
  { id: 6, nom: "Bleu de Chanel", marque: "Chanel", genre: "Homme", prix: 990, famille: "Boisé", taille: "100ml", nouveau: false },
  { id: 7, nom: "J'adore", marque: "Dior", genre: "Femme", prix: 880, famille: "Floral", taille: "100ml", nouveau: false },
  { id: 8, nom: "La Vie Est Belle", marque: "Lancôme", genre: "Femme", prix: 720, famille: "Oriental", taille: "50ml", nouveau: false },
  { id: 9, nom: "Chance Eau Tendre", marque: "Chanel", genre: "Femme", prix: 830, famille: "Floral", taille: "100ml", nouveau: true },
  { id: 10, nom: "Terre d'Hermès", marque: "Hermès", genre: "Homme", prix: 1100, famille: "Boisé", taille: "100ml", nouveau: false },
  { id: 11, nom: "L'Interdit", marque: "Givenchy", genre: "Femme", prix: 760, famille: "Floral", taille: "50ml", nouveau: false },
  { id: 12, nom: "Opium", marque: "YSL", genre: "Femme", prix: 690, famille: "Oriental", taille: "30ml", nouveau: false },
];

let filteredProducts = [...allProducts];

// ===== RENDU CARDS =====
function renderProducts(products) {
  const grid = document.getElementById('productsGrid');
  const count = document.getElementById('productCount');
  count.textContent = products.length + ' parfum' + (products.length > 1 ? 's' : '') + ' trouvé' + (products.length > 1 ? 's' : '');

  if (products.length === 0) {
    grid.innerHTML = '<div class="no-results">Aucun parfum ne correspond à vos critères.</div>';
    return;
  }

  grid.innerHTML = products.map(p => `
    <div class="card" onclick="voirProduit(${p.id})">
      <div class="card-img">&#10023;</div>
      <div class="card-body">
        <div class="card-name">${p.nom}</div>
        <div class="card-sub">${p.marque} · ${p.genre}</div>
        <div class="card-price">${p.prix} MAD</div>
        <button class="add-btn" onclick="ajouterPanier(event, ${p.id})">+ Panier</button>
      </div>
    </div>
  `).join('');
}

// ===== FILTRES =====
function applyFilters() {
  const marque = document.getElementById('filterMarque').value;
  const prix = parseInt(document.getElementById('filterPrix').value);
  const famille = document.getElementById('filterFamille').value;
  const taille = document.getElementById('filterTaille').value;
  const genre = document.getElementById('filterGenre').value;
  const search = document.getElementById('searchInput').value.toLowerCase();
  const cat = document.getElementById('searchCategory').value;

  filteredProducts = allProducts.filter(p => {
    if (marque && p.marque !== marque) return false;
    if (p.prix > prix) return false;
    if (famille && p.famille !== famille) return false;
    if (taille && p.taille !== taille) return false;
    if (genre && p.genre !== genre) return false;
    if (cat && p.genre.toLowerCase() !== cat) return false;
    if (search && !p.nom.toLowerCase().includes(search) && !p.marque.toLowerCase().includes(search)) return false;
    return true;
  });

  sortProducts();
}

function resetFilters() {
  document.getElementById('filterMarque').value = '';
  document.getElementById('filterPrix').value = 3000;
  document.getElementById('prixVal').textContent = '≤ 3000 MAD';
  document.getElementById('filterFamille').value = '';
  document.getElementById('filterTaille').value = '';
  document.getElementById('filterGenre').value = '';
  document.getElementById('searchInput').value = '';
  document.getElementById('searchCategory').value = '';
  filteredProducts = [...allProducts];
  renderProducts(filteredProducts);
}

function searchProducts() {
  applyFilters();
}

// ===== TRI =====
function sortProducts() {
  const sort = document.getElementById('sortSelect').value;
  let sorted = [...filteredProducts];
  if (sort === 'prix-asc') sorted.sort((a, b) => a.prix - b.prix);
  else if (sort === 'prix-desc') sorted.sort((a, b) => b.prix - a.prix);
  else if (sort === 'nouveau') sorted.sort((a, b) => b.nouveau - a.nouveau);
  renderProducts(sorted);
}

// ===== PANIER =====
function ajouterPanier(event, id) {
  event.stopPropagation();
  const produit = allProducts.find(p => p.id === id);
  let cart = JSON.parse(localStorage.getItem('auriva_cart') || '[]');
  const existing = cart.find(c => c.id === id);
  if (existing) {
    existing.qte += 1;
  } else {
    cart.push({ ...produit, qte: 1 });
  }
  localStorage.setItem('auriva_cart', JSON.stringify(cart));
  updateCartBadge();

  const btn = event.target;
  btn.textContent = '✓ Ajouté';
  btn.style.background = '#2d7a2d';
  btn.style.color = '#fff';
  btn.style.borderColor = '#2d7a2d';
  setTimeout(() => {
    btn.textContent = '+ Panier';
    btn.style.background = '';
    btn.style.color = '';
    btn.style.borderColor = '';
  }, 1200);
}

// ===== DETAIL PRODUIT =====
function voirProduit(id) {
  window.location.href = 'detail_produit.html?id=' + id;
}

// ===== INIT =====
renderProducts(allProducts);