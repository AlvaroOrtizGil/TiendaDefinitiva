document.getElementById("loginForm").addEventListener("submit", async (event) => {
    event.preventDefault();

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    // Enviar credenciales al servidor
    const response = await fetch("../backend/login.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password }),
    });

    const result = await response.json();

    if (result.success) {
        // Guardar token y datos en localStorage
        localStorage.setItem("token", result.token);
        localStorage.setItem("store", JSON.stringify(result.store));
        alert("Login exitoso");
        window.location.href = "dashboard.html"; // Redirigir al dashboard
    } else {
        alert("Credenciales inválidas");
    }
});
