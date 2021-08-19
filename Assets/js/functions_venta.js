function openModal() {
    document.querySelector('#idMesa').value="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Enviar Pedido";
    document.querySelector('#titleModal').innerHTML = "Nuevo Pedido";
    document.querySelector('#formMesa').reset();
    $('#modalFormMesa').modal('show');
}var objData = JSON.parse(request.responseText);