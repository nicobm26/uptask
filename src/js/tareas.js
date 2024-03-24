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

        agregarTarea(tarea);
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
    async function agregarTarea(tarea){
        //Contruir la peticion  pdta: Toca que usar formdata
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('url',obtenerProyecto());

        try {
            const url = `${location.origin}/api/tarea`;
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();

            mostrarAlerta(resultado.mensaje , resultado.tipo, document.querySelector('.formulario legend'));

            if(resultado.tipo === "exito"){
                const modal = document.querySelector('.modal');
                const elementosOpciones = document.querySelectorAll('.opciones *');

                elementosOpciones.forEach(elemento => {
                    elemento.disabled = true;
                });
                        
                setTimeout(() => {
                    modal.remove();
                }, 3000);
            }
        } catch (error) {
            console.log(error);
        }
    }
    
    function obtenerProyecto(){
        const proyectoQueryParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoQueryParams.entries());
        return proyecto.id;
    }

    //hace lo mismo que obtenerProyecto solo que todo desde una variable
    function getProject() {
        const project = Object.fromEntries(
            new URLSearchParams(window.location.search)
        );
        return project.id;
    }
    
})();


