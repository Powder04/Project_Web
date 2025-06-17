async function addToCart(id, name) {
    const res = await fetch('add_to_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, name })
    });
    loadCart();
}

async function loadCart() {
    const res = await fetch('add_to_cart.php');
    const data = await res.json();
    const dropdown = document.getElementById('cart-dropdown');
    dropdown.innerHTML = data.map(item =>
        `<div class="cart-item">${item.name}</div>`).join('');
}

document.addEventListener("DOMContentLoaded", loadCart);