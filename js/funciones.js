function mostrarContrasena(){
    var tipoInput = document.querySelector("[data-tipoInput='password']");
    if(tipoInput.type == "password"){
        tipoInput.type = "text";
    }else{
        tipoInput.type = "password";
    }
}
