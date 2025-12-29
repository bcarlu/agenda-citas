function mostrarContrasena(){
    var tipoInput = document.querySelector("[data-tipoInput='password']");
    if(tipoInput.type == "password"){
        tipoInput.type = "text";
    }else{
        tipoInput.type = "password";
    }
}

/** 
 * Modifica la clase para el item seleccionado del menu en la barra lateral 
 * del panel admin.
 * @return void -> Modifica la clase del item a.
 */
function resaltarItemActivo () {
    //Obtener pagina activa 
    var paginaActual = location.href;

    // Obtener elementos del panel lateral
    var panel = document.getElementById("navbar-lateral-admin");

    // Obtener los hijos (los enlaces <a>)
    const enlaces = panel.querySelectorAll('a.nav-link'); 

    // Recorrer los enlaces
    for (let i = 0; i < enlaces.length; i++) {
        const enlace = enlaces[i];
        if (paginaActual.match(enlace.href)) {
            enlace.classList.add('active');
        } else {
            if (enlace.classList.contains('active')) {
                enlace.classList.remove('active');
            }
        }
    }
}

// Se escucha evento para resaltar el item correspondiente en la barra lateral del panel admin
document.addEventListener("DOMContentLoaded", resaltarItemActivo);

// Listener para llamar la funcion showToast cuando sea necesario mostrar alertas. showToast se define en el archivo mostrar_alerta.js
document.addEventListener("DOMContentLoaded", function() {
    const parametrosURL = new URLSearchParams(window.location.search);
    if (parametrosURL.has('tipo') && parametrosURL.has('mensaje')) {
        showToast(parametrosURL.get("mensaje"), parametrosURL.get("tipo"))
    }
});