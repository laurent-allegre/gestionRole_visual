const nouveauPassword = document.querySelector("#nouveauPassword");
const confirmNouveauPassword = document.querySelector("#confirmNouveauPassword");

nouveauPassword.addEventListener("keyup",function(){
    verificationPassword();
})

confirmNouveauPassword.addEventListener("keyup",function(){
    verificationPassword();
})

function verificationPassword(){
    if(nouveauPassword.value === confirmNouveauPassword.value){
        document.querySelector("#btnValidation").disabled = false;
        document.querySelector("#erreur").classList.add("d-none");
    } else {
        document.querySelector("#btnValidation").disabled = true;
        document.querySelector("#erreur").classList.remove("d-none");
    }
}