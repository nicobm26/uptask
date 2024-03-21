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
        }, 3000);
        
        document.querySelector('body').appendChild(modal);
    }
})();


