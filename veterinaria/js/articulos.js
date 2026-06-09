let amountProduct = document.querySelector('.count-product');
const clickButton = document.querySelectorAll('.button');
const tbody = document.querySelector('.tbody');
let carrito = [];
let countProduct = 0;

clickButton.forEach(btn => {
    btn.addEventListener('click', addToCarritoItem);
});

function addToCarritoItem(e) {
    const button = e.target;
    const item = button.closest('.card');
    const itemTitle = item.querySelector('.card-title').textContent;
    const itemPrice = item.querySelector('.precio').textContent;
    const itemTitlee = item.querySelector('.card-titlee').textContent;
    const itemImg = item.querySelector('.card-img-top').src;

    const existingItem = carrito.find(item => item.title.trim() === itemTitle.trim());

    if (existingItem) {
        const alert = document.querySelector('.alert');
        alert.classList.remove('hide');
        setTimeout(function () {
            alert.classList.add('fade');
            setTimeout(function () {
                alert.classList.add('hide');
                alert.classList.remove('fade');
            }, 500);
        }, 500);

        const InputElemnto = tbody.getElementsByClassName('input__elemento');
        for (let i = 0; i < carrito.length; i++) {
            if (carrito[i].title.trim() === existingItem.title.trim()) {
                if (carrito[i].cantidad >= parseInt(itemTitlee)) {
                    // Verificar si se ha alcanzado el límite máximo
                    // Si es así, mostrar un mensaje de advertencia al usuario
                    alertUserMaxLimit();
                    return;
                }
                carrito[i].cantidad++;
                const inputValue = InputElemnto[i];
                inputValue.value++;
                renderCarrito();
                CarritoTotal();
                return null;
            }
        }
    } else {
        // Si no existe el artículo en el carrito, se verifica el límite máximo antes de agregarlo
        if (parseInt(itemTitlee) <= 0) {
            // Mostrar un mensaje de advertencia al usuario
            alertUserMaxLimit();
            return;
        }
        
        const newItem = {
            title: itemTitle,
            precio: itemPrice,
            img: itemImg,
            titlee: itemTitlee,
            cantidad: 1
        };
        
        addItemCarrito(newItem);
        updateAmountProduct(); // Solo incrementa el contador si es un producto nuevo
    }
}

function alertUserMaxLimit() {
    // Aquí puedes mostrar un mensaje de advertencia al usuario
    // Puedes usar una alerta, un modal, un mensaje en la interfaz, etc.
    "<script type='text/javascript'>"
    swal({
        title: 'Mensaje',
        text: 'Se ha alcanzado el límite máximo de stock para este artículo.',
        showCancelButton: false, 
        confirmButtonText: 'OK' 
    });
"</script>";
}



function addItemCarrito(newItem) {
    const alert = document.querySelector('.alert');
    alert.classList.remove('hide');
    setTimeout(function () {
        alert.classList.add('fade');
        setTimeout(function () {
            alert.classList.add('hide');
            alert.classList.remove('fade');
        }, 500);
    }, 500);

    const InputElemnto = tbody.getElementsByClassName('input__elemento');
    for (let i = 0; i < carrito.length; i++) {
        if (carrito[i].title.trim() === newItem.title.trim()) {
            carrito[i].cantidad++;
            const inputValue = InputElemnto[i];
            inputValue.value++;
            renderCarrito();
            CarritoTotal();
            updateAmountProduct(); // Actualizar el contador
            return null;
        }
    }

    carrito.push(newItem);
    renderCarrito();
    updateAmountProduct(); // Actualizar el contador
}

function renderCarrito() {
    tbody.innerHTML = '';
    carrito.map((item, index) => {
        const tr = document.createElement('tr');
        tr.classList.add('ItemCarrito');
        const content = `
            <th scope="row" data-label="N°">${index + 1}</th>
            <td class="table__productos" data-label="PRODUCTO">
                <img src="${item.img}" alt="">
                <h6 class="title">${item.title}</h6>
            </td>
            <td class="table__price" data-label="PRECIO">${item.precio}</td>
            <td class="table__cantidad" data-label="CANTIDAD">
                <input type="number" min="0" max="${item.titlee}" value="${item.cantidad}" class="input__elemento" style="width: 48px;">
            </td>
            <td class="table__totalidad" data-label="TOTAL">
                ${getTotalForItem(item)}
            </td>
            <td data-label="ELIMINAR">
                <button class="delete btn btn-danger">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        `;
        tr.innerHTML = content;
        tbody.append(tr);

        tr.querySelector(".delete").addEventListener('click', removeItemCarrito);
        tr.querySelector(".input__elemento").addEventListener('change', sumaCantidad);
    });
    CarritoTotal();
}



const borrarCarritoButton = document.getElementById('borrarCarrito');

// Agregar event listener al botón "Borrar carrito"
borrarCarritoButton.addEventListener('click', borrarCarrito);

function borrarCarrito() {
    carrito = [];
    renderCarrito();
    updateAmountProduct();
}

function CarritoTotal() {
    let Total = 0;
    const itemCartTotal = document.querySelector('.itemCartTotal');
    carrito.forEach((item) => {
        const precio = Number(item.precio.replace("$", ''));
        Total = Total + precio * item.cantidad;
    });

    itemCartTotal.innerHTML = `VALOR TOTAL: $${Total}`;
    addLocalStorage();
}

function removeItemCarrito(e) {
    const buttonDelete = e.target;
    const tr = buttonDelete.closest(".ItemCarrito");
    const title = tr.querySelector('.title').textContent;
    
    // Eliminar del array
    for (let i = 0; i < carrito.length; i++) {
        if (carrito[i].title.trim() === title.trim()) {
            carrito.splice(i, 1);
            break; // Salir del bucle después de encontrar y eliminar
        }
    }

    // Mostrar alerta de eliminación (manteniendo tu código original)
    const alert = document.querySelector('.remove');
    alert.classList.remove('remove'); // Esto oculta la alerta? O la muestra?
    setTimeout(function () {
        alert.classList.add('fade');
        setTimeout(function () {
            alert.classList.add('remove');
            alert.classList.remove('fade');
        }, 700);
    }, 700);

    // En lugar de tr.remove(), VOLVEMOS A RENDERIZAR TODO EL CARRITO
    renderCarrito(); // Esto repinta todas las filas con los números actualizados
    
    // Actualizar totales y contador
    CarritoTotal();
    updateAmountProduct();
}


function addLocalStorage() {
    localStorage.setItem('carrito', JSON.stringify(carrito));
}


function updateAmountProduct() {
    const uniqueProductsCount = carrito.length; // Cuenta los productos únicos en el carrito
    amountProduct.textContent = uniqueProductsCount || ''; // Mostrar un valor vacío si no hay productos
}

window.onload = function () {
    const storage = JSON.parse(localStorage.getItem('carrito'));
    if (storage) {
        carrito = storage;
        renderCarrito();
        updateAmountProduct();
    }
    updateAmountProduct(); // Agrega esto para actualizar el contador en la carga inicial
}


function getTotalForItem(item) {
    const precio = Number(item.precio.replace("$", ""));
    const cantidad = item.cantidad;
    const total = precio * cantidad;
    return `<p style="color: white !important; margin: 0;"> $${total}</p>`;
}


function sumaCantidad(e) {
    const sumaInput = e.target;
    const tr = sumaInput.closest(".ItemCarrito");
    const title = tr.querySelector(".title").textContent;

    const item = carrito.find(item => item.title.trim() === title.trim());
    if (item) {
        const newCantidad = parseInt(sumaInput.value, 10);

        // Verificar si la nueva cantidad es mayor o igual a 0
        if (newCantidad >= 0 && newCantidad <= item.titlee) {
            item.cantidad = newCantidad;
        } else {
            // Si la nueva cantidad es menor que 0 o mayor que item.titlee, ajustarla
            if (newCantidad < 0) {
                item.cantidad = 0;
            } else {
                item.cantidad = item.titlee;
            }

            // Actualizar el valor en el campo de entrada
            sumaInput.value = item.cantidad;
        }

        // Actualizar la cantidad en la interfaz y el valor total del producto
        tr.querySelector(".table__totalidad").innerHTML = getTotalForItem(item);
        CarritoTotal();
        updateAmountProduct();
    }

    // Solución para el error de aria-hidden en modales
    document.addEventListener('DOMContentLoaded', function() {
        // Cuando se abre un modal
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('show.bs.modal', function() {
                // Remover aria-hidden cuando el modal está abierto
                this.removeAttribute('aria-hidden');
            });
            
            modal.addEventListener('hide.bs.modal', function() {
                // Agregar aria-hidden cuando el modal se cierra
                this.setAttribute('aria-hidden', 'true');
            });
        });
    });
}


