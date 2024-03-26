( function(){
    
    let tareas = [];
    obtenerTareas();


    
    //boton para mostrar el formulario
    let nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    async function obtenerTareas(){
        try {
            const urlProyecto = obtenerProyecto();            
            const urlApi = `${location.origin}/api/tareas?id=${urlProyecto}`;
            const respuesta = await fetch(urlApi);
            const resultado = await respuesta.json();
            // const {tareas} = resultado;

            tareas = resultado.tareas;

            // console.log(tareas);
            mostrarTareas();
        } catch (error) {
            console.log(error);
        }
       
    }

    function limpiarTareas(){
        const listadoTareas = document.querySelector('#listado-tareas');
        while(listadoTareas.firstChild){
            listadoTareas.removeChild(listadoTareas.firstChild)
        }
    }

    function mostrarTareas(){
        limpiarTareas();
        if(tareas.length === 0){
            const contenedorTareas = document.querySelector('#listado-tareas');

            const textNoTareas = document.createElement('LI');
            textNoTareas.textContent = "No hay tareas";
            textNoTareas.classList.add('no-tareas');

            contenedorTareas.appendChild(textNoTareas);
            return;
        }

        const estados = {
            0: "Pendiente",
            1: "Completa"
        };

        tareas.forEach(tarea =>{
            const contenedorTarea = document.createElement('LI');
            contenedorTarea.dataset.tareaId = tarea.id;
            contenedorTarea.classList.add('tarea');
        
            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre;

            //opciones 
            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            const btnEstadoTarea = document.createElement('BUTTON');
            btnEstadoTarea.classList.add('estado-tarea');
            btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`);
            btnEstadoTarea.textContent = estados[tarea.estado];
            btnEstadoTarea.dataset.estadoTarea = tarea.estado;
            btnEstadoTarea.ondblclick = function(){
                cambiarEstadoTarea({...tarea});
            }

            const btnEliminarTarea = document.createElement('BUTTON');
            btnEliminarTarea.classList.add('eliminar-tarea');
            btnEliminarTarea.dataset.estadoTarea = tarea.estado;
            btnEliminarTarea.textContent = "Eliminar";

            opcionesDiv.appendChild(btnEstadoTarea);
            opcionesDiv.appendChild(btnEliminarTarea);

            contenedorTarea.appendChild(nombreTarea);
            contenedorTarea.appendChild(opcionesDiv);

            const contenedorTareas = document.querySelector('#listado-tareas');
            contenedorTareas.appendChild(contenedorTarea);

        })

    }

    function cambiarEstadoTarea(tarea){
        // console.log(tarea)
        const nuevoEstado = tarea.estado === "1" ? "0" : "1";
        tarea.estado = nuevoEstado;
       actualizarTarea(tarea);
    }
    async function actualizarTarea(tarea){
        let {id, nombre, estado } = tarea;
        const datos = new FormData();
        datos.append ( 'id', id);
        datos.append ( 'nombre', nombre);
        datos.append ( 'estado', estado);
        datos.append ( 'proyectoId', obtenerProyecto());

        //La unica forma de ver los valores que tienen datos.append
        // for(let valor of datos.values()){
        //     console.log(valor);
        // }

        try {
            const url = `${location.origin}/api/actualizar`;
            const respuesta = await fetch( url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();
            console.log(resultado);
            if(resultado.respuesta.tipo === "exito"){
                mostrarAlerta(
                    resultado.respuesta.mensaje,
                    resultado.respuesta.tipo,
                    document.querySelector('.contenedor-nueva-tarea')
                );
            }
        } catch (error) {
            console.log(error);
        }


    }

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

                //Agregar el objeto de tarea al global de tareas
                const tareaObj = {
                    id: String(resultado.id),
                    nombre: tarea,
                    estado: 0,
                    proyectoId: resultado.proyectoId
                }
                // console.log(tareaObj);
                tareas = [... tareas, tareaObj];
                mostrarTareas();
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


