
var EntrarPainel = document.getElementById("EntrarPainel");
var CadastroSite = document.getElementById("CadastroSite");
var Indicador = document.getElementById("Indicador");

let x = document.getElementsByClassName('animals');

function Entrar() {
    CadastroSite.style.left = "-300px"
    EntrarPainel.style.left = "0px"
    Indicador.style.transform = "translateX(0px)"
}

function Cadastro() {
    CadastroSite.style.left = "0"
    EntrarPainel.style.left = "-300px"
    Indicador.style.transform = "translateX(110px)"
}


