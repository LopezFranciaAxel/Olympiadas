var swiper = new Swiper(".mySwiper-1",{
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    pagination:{
        el: ".swiper-pagination",
        clickable:true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    }
});

var swiper = new Swiper(".mySwiper-2",{
    slidesPerView: 3,
    spaceBetween: 30,
    loop: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints : {
        0: {
            slidesPerView: 1
        },
        520: {
            slidesPerView: 2
        },
        950: {
            slidesPerView: 1
        }
    }
});



//carrito

const carrito = document.getElementById('carrito');
const elemetos1 = document.getElementById('lista-1');
const elemetos2 = document.getElementById('lista-2');
const elemetos3 = document.getElementById('lista-3');
const lista = document.querySelector('#lista-carrito tbody');
const vaciarCarritoBtn = document.getElementById('vaciar-carrito');

cargarEventListeners();

function cargarEventListeners(){
    elemetos1.addEventListener('click', comprarElemento);
    elemetos2.addEventListener('click', comprarElemento);
    elemetos3.addEventListener('click', comprarElemento);
    carrito.addEventListener('click', eliminarElemento);

    vaciarCarritoBtn.addEventListener('click', vaciarCarrito);
}

function comprarElemento(e){
    e.preventDefault();
    if(e.target.classList.contains('agregar-carrito')){
        const elemento = e.target.parentElement.parentElement;
        leerDatosElemetno(elemento);
    }
}

function leerDatosElemetno(elemento){
    const infoElemento = {
        imagen: elemento.querySelector('img').src,
        titulo: elemento.querySelector('h3').textContent,
        precio: elemento.querySelector('.precio').textContent,
        id: elemento.querySelector('a').getAttribute('data-id')
    }

    insertarCarrito(infoElemento);
}

function insertarCarrito(elemento){
    const row = document.createElement('tr');
    row.innerHTML = `
    <td>
    <img src="${elemento.imagen}" width=100 >
    </td>
    <td>
    ${elemento.titulo}
    </td>
    <td>
    ${elemento.precio}
    </td>
    <td>
    <a href="#" class="borrar" data-id="${elemento.id}">X</a>
    </td>
    `;

    lista.appendChild(row);
}

function eliminarElemento(e){
    e.preventDefault();
    let elemento,
    elementoId;

    if(e.target.classList.contains('borrar')){
        e.target.parentElement.parentElement.remove();
        elemento = e.target.parentElement.parentElement;
        elementoId = elemento.querySelector('a').getAttribute('data-id');
    }
}

function vaciarCarrito(){
    while(lista.firstChild){
        lista.removeChild(lista.firstChild);
    }
    return false;
}
// Confirmar compra
document.getElementById('confirmar-compra').addEventListener('click', function() {
    // Enviar petición al servidor para confirmar la compra
    fetch('confirmar_compra.php', {
        method: 'POST',
        body: JSON.stringify({ accion: 'confirmar' }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Compra confirmada con éxito');
        } else {
            alert('Error al confirmar la compra');
        }
    });
});

// Anular compra pendiente
document.getElementById('anular-compra').addEventListener('click', function() {
    // Enviar petición al servidor para anular la compra pendiente
    fetch('anular_compra.php', {
        method: 'POST',
        body: JSON.stringify({ accion: 'anular' }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Compra pendiente anulada con éxito');
        } else {
            alert('Error al anular la compra pendiente');
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    // Elementos del DOM
    const confirmarCompraBtn = document.getElementById('confirmar-compra');
    const anularCompraBtn = document.getElementById('anular-compra');
    const nombreUsuario = document.getElementById('nombre-usuario');

    // Obtener el nombre de usuario y mostrarlo en la página
    fetch('obtener_usuario.php')
        .then(response => response.json())
        .then(data => {
            if (data.usuario) {
                nombreUsuario.textContent = data.usuario;
            } else {
                nombreUsuario.textContent = 'Invitado';
            }
        });

    // Eventos para confirmar y anular compra
    confirmarCompraBtn.addEventListener('click', () => {
        realizarCompra('confirmar');
    });

    anularCompraBtn.addEventListener('click', () => {
        realizarCompra('anular');
    });

    // Cargar productos y carrito con Swiper
    cargarProductos();
    cargarCarrito();
});

function realizarCompra(accion) {
    const xhr = new XMLHttpRequest();
    const url = accion === 'confirmar' ? 'confirmar_compra.php' : 'anular_compra.php';
    
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status === 200) {
            alert(`Compra ${accion === 'confirmar' ? 'confirmada' : 'anulada'} correctamente.`);
            window.location.reload();
        } else {
            alert('Hubo un error, por favor intente nuevamente.');
        }
    };

    xhr.send();  // Aquí puedes enviar datos adicionales si es necesario
}

function cargarProductos() {
    const swiperWrapper = document.querySelector('.mySwiper-1 .swiper-wrapper');
    
    // Aquí puedes hacer una petición para cargar los productos desde el servidor
    // Ejemplo básico (debes adaptarlo a tu backend):
    fetch('obtener_productos.php')
        .then(response => response.json())
        .then(productos => {
            productos.forEach(producto => {
                const swiperSlide = document.createElement('div');
                swiperSlide.classList.add('swiper-slide');
                swiperSlide.innerHTML = `
                    <img src="${producto.imagen}" alt="${producto.nombre}">
                    <h3>${producto.nombre}</h3>
                    <p>Precio: $${producto.precio}</p>
                    <button onclick="agregarAlCarrito(${producto.id})">Agregar al Carrito</button>
                `;
                swiperWrapper.appendChild(swiperSlide);
            });

            // Inicializar Swiper después de cargar los productos
            new Swiper('.mySwiper-1', {
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
        });
}

function cargarCarrito() {
    const swiperWrapper = document.querySelector('.mySwiper-2 .swiper-wrapper');

    // Aquí puedes hacer una petición para cargar los productos del carrito desde el servidor
    fetch('obtener_carrito.php')
        .then(response => response.json())
        .then(carrito => {
            carrito.forEach(item => {
                const swiperSlide = document.createElement('div');
                swiperSlide.classList.add('swiper-slide');
                swiperSlide.innerHTML = `
                    <img src="${item.imagen}" alt="${item.nombre}">
                    <h3>${item.nombre}</h3>
                    <p>Cantidad: ${item.cantidad}</p>
                    <p>Precio: $${item.precio}</p>
                `;
                swiperWrapper.appendChild(swiperSlide);
            });

            // Inicializar Swiper después de cargar el carrito
            new Swiper('.mySwiper-2', {
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
}

function agregarAlCarrito(productoId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'agregar_al_carrito.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Producto agregado al carrito.');
            cargarCarrito();
        } else {
            alert('Hubo un error, por favor intente nuevamente.');
        }
    };

    xhr.send('id=' + productoId);
}
