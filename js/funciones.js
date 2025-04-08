function mostrarContrasena(){
    var tipoInput = document.getElementById("clave-reg");
    if(tipoInput.type == "password"){
        tipoInput.type = "text";
    }else{
        tipoInput.type = "password";
    }
}
