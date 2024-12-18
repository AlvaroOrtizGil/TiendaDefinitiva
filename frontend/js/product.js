document.addEventListener("DOMContentLoaded", () => {
    // Obtener el parámetro "id" de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const productId = parseInt(urlParams.get("id"));

    if (!productId) {
        alert("Producto no encontrado.");
        window.location.href = "dashboard.html";
        return;
    }

    // Cargar la información del producto desde localStorage
    const store = JSON.parse(localStorage.getItem("store"));
    if (!store || !store.productos) {
        alert("No se pudo cargar la tienda.");
        return;
    }

    const product = store.productos.find(p => p.id === productId);
    if (!product) {
        alert("Producto no encontrado.");
        window.location.href = "dashboard.html";
        return;
    }

    // Mostrar los detalles del producto
    document.getElementById("product-name").textContent = `Nombre: ${product.nombre}`;
    document.getElementById("product-price").textContent = `Precio: ${product.precio}€`;
    document.getElementById("product-description").textContent = `Descripción: ${product.descripcion || 'No disponible'}`;
});