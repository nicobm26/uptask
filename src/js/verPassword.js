/*=============== SHOW HIDDEN - PASSWORD ===============*/
const showHiddenPass = (loginPass, loginEye) => {
  const input = document.getElementById(loginPass),
    iconMostrar = document.getElementById(loginEye);

  if (!input && !iconMostrar) return;

  iconMostrar.addEventListener("click", () => {
    // Change password to text
    if (input.type === "password") {
    //   console.log("mostrar contraseña en texto");
      // Switch to text
      input.type = "text";
      simbolo = "&#128586;";

      //Cambio en el span
      //  iconMostrar.innerHTML = "&#128064;"; // Icono de ojo cerrado
      iconMostrar.innerHTML = simbolo; // Icono de ojo cerrado  ff-line')
    } else {
    //   console.log("mostrar contraseña en astericos");
      // Change to password
      input.type = "password";
      //Cambio en el span
      simbolo = "&#128584;";
      iconMostrar.innerHTML = simbolo; // Icono de ojo cerrado
    }
  });
};

showHiddenPass("clave-actual", "ojoAbierto");
showHiddenPass("clave-nueva", "ojoAbierto2");
