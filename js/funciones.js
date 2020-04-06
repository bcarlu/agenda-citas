function mostrarContrasena(){
    var tipoInput = document.getElementById("passwd-reg");
    if(tipoInput.type == "password"){
        tipoInput.type = "text";
    }else{
        tipoInput.type = "password";
    }
}