document.querySelector('#img_perfil').onclick = function() {
            
    let elementoMain = document.getElementById('display_menu')
    
    elementoMain.style.display == "block" ? elementoMain.style.display = "none" : elementoMain.style.display = "block", elementoMain.classList.add("visible")
}