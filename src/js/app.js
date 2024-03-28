const mobileMenuBtn = document.querySelector('#mobile-menu');
const cerrarMenuBtn = document.querySelector('#cerrar-menu');
const sidebar = document.querySelector('.sidebar');

if(mobileMenuBtn){
    mobileMenuBtn.addEventListener('click', function(){
        sidebar.classList.toggle('mostrar');
    })
}

if(cerrarMenuBtn){
    cerrarMenuBtn.addEventListener('click', function(){
        sidebar.classList.add('ocultar');
        setTimeout(() => {
            sidebar.classList.remove('mostrar');
            sidebar.classList.remove('ocultar');         
        }, 400);
    });
}


//Elimina la clase de mostrar en un tamaño de tablet y mayores  //Opcion 1
let anchoPantalla = window.matchMedia('(min-width: 768px)');
anchoPantalla.addEventListener('change', redimensionarPantalla);
function redimensionarPantalla(evento){
    if(evento.matches){
        if(sidebar.classList.contains('mostrar')){
            sidebar.classList.remove('mostrar');
        }
    }
}

// Elimina la clase de mostrar, en un tamaño de tablet y mayores  //Opcion 2

// window.addEventListener('resize', function() {
//     const anchoPantalla2 = document.body.clientWidth;
//     if(anchoPantalla2 >= 768) {
//         sidebar.classList.remove('mostrar');
//     }
// })