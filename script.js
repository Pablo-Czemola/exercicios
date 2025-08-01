// script.js

// capturando elementos
const container   = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn    = document.getElementById('login');

// debug rápido
console.log('container:', container);
console.log('registerBtn:', registerBtn);
console.log('loginBtn:', loginBtn);

if (!container || !registerBtn || !loginBtn) {
  console.error('❌ Algum dos elementos não foi encontrado! Confira se os IDs batem com o HTML.');
} else {
  registerBtn.addEventListener('click', () => {
    container.classList.add('active');
  });

  loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
  });
}
