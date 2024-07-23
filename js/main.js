function cambiarVentana(e) {
    var secciones = document.querySelectorAll('.seccion')

    secciones.forEach(ele => {
        ele.style.color = '#333'
        ele.style.backgroundColor = '#eee'
    })

    e.target.style.backgroundColor = 'black'
    e.target.style.color = 'white'
}

function mostrarAnuncio() {
    var anuncio = document.getElementById('anuncio')
    anuncio.style.display = 'block'
}

function quitarAnuncio() {
    var anuncio = document.getElementById('anuncio')
    anuncio.style.display = 'none'
}

function quitarError() {
    var anuncio = document.getElementById('error')
    anuncio.style.display = 'none'
}

function mostrarEliminar() {
    var eliminar = document.getElementById('eliminar-usuario')
    eliminar.style.display = 'block'
}

function quitarEliminar() {
    var eliminar = document.getElementById('eliminar-usuario')
    eliminar.style.display = 'none'
}
