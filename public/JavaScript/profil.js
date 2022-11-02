let btnModifMail = document.querySelector("#btnModifMail");
let btnValidModifMail = document.querySelector("#btnValidModifMail");
let divMail = document.querySelector("#mail");
let divModificationMail = document.querySelector("#modificationMail");

btnModifMail.addEventListener("click", function(){
    divMail.classList.add("d-none");
    divModificationMail.classList.remove("d-none");
})

document.querySelector("#btnSupCompte").addEventListener("click", function(){
    console.log("test");
    document.querySelector("#suppressionCompte").classList.remove("d-none");
})
