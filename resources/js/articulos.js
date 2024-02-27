Swal.fire({
    title: "Do you want to save the changes?",
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: "Save",
    denyButtonText: `Don't save`
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      Swal.fire("Saved!", "", "success");
    } else if (result.isDenied) {
      Swal.fire("Changes are not saved", "", "info");
    }
  });

  const btnAceptar =
  document.querySelector("#btn_aceptar");
  const btnCerrar =
  document.querySelector("#btn_cerrar");
  const accion =
  document.querySelector("#accion");

  btnAceptar.addEventListener("click",()=>{
    accion.showAccion();
  })

  btnCerrar.addEventListener("click",()=>{
    accion.close();
    console.log("mensaje modificacion grande gran motnond e asdfasdfasdfasdfdafsda cosisadfasdasfdasdfasdfasdfasdfasdasdfasdff adaijdwidd")
    console.log("dhaudhuwhdiuahduiwahd")
  })