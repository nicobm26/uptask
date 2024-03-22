( function(){
    
    //boton para mostrar el formulario
    let nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    function mostrarFormulario(){
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
        <form class='formulario nueva-tarea'>
            <legend>Añade una nueva tarea</legend>
            <div class='campo'>
                <label>Tarea</label>
                <input
                    type='text'
                    name='tarea'
                    id='tarea'
                    placeholder='Añadir Tarea al Proyecto Actual'
                /> 
            </div>
            <div class='opciones'>
                <input 
                    type='submit'
                    class='submit-nueva-tarea'
                    value='Añadir Tarea'
                />
                <button type='button' class='cerrar-modal'>Cancelar</button>
            </div>
        </form>        
        `;

        setTimeout( ()=>{
            let formulario = document.querySelector('.formulario');
            formulario.classList.add('animar');
        }, 0);

        modal.addEventListener('click', function(e) {
            e.preventDefault();

            if(e.target.classList.contains('cerrar-modal')){
                let formulario = document.querySelector('.formulario');
                formulario.classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                }, 500);
                
            }

            if(e.target.classList.contains('submit-nueva-tarea')){
                submitFormularioNuevaTarea();
            }            
             
            // console.log(e.target);
        })
        
        document.querySelector('.dashboard').appendChild(modal);
        // document.querySelector('body').appendChild(modal);  //queda div , script , div(modal) y queremos es que los script sean los ultimos
    }

    function submitFormularioNuevaTarea(){
        const tarea = document.querySelector('#tarea').value.trim();

        if(tarea === ""){
            //mostrar una alerta de             
            mostrarAlerta('El nombre de la tarea es obligatorio', 'error', document.querySelector('.formulario legend'));
            return;
        }

        agregarTarea();
    }

    //Muestra mensaje en la interfaz
    function mostrarAlerta(mensaje, tipo, referencia){

        //Previene la creacion de multiples alertas
        const alertaPrevia = document.querySelector('.alerta');
        if(alertaPrevia){
            alertaPrevia.remove();
        }

        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta', tipo);
        alerta.textContent = mensaje;
        referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);

        //Eliminar la alerta despues de 5 segundos
        setTimeout(() => {
            alerta.remove();
        }, 4000);
    }

    //Consultar el servidor para añadir una tarea
    function agregarTarea(){
        
    }
    
})();


