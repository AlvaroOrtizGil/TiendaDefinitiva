document.addEventListener("DOMContentLoaded", () => {
    // Verificar token
    const token = localStorage.getItem("token");
    if (!token) {
        alert("No estás autenticado");
        window.location.href = "login.html";
    }

    // Cargar datos desde localStorage
    const store = JSON.parse(localStorage.getItem("store"));
    const productsContainer = document.getElementById("products");

    store.productos.forEach((product) => {
        const productDiv = document.createElement("div");
        productDiv.className = "product";
        productDiv.innerHTML = `
            <h3>${product.nombre}</h3>
            <p>Precio: ${product.precio}</p>
            <button onclick="addToCart(${product.id})">Añadir al carrito</button>
        `;
        productsContainer.appendChild(productDiv);
    });
});

function addToCart(productId) {
    const store = JSON.parse(localStorage.getItem("store"));
    const product = store.productos.find((p) => p.id === productId);
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart.push(product);
    localStorage.setItem("cart", JSON.stringify(cart));
    alert("Producto añadido al carrito");
}
