document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('extMailForm');
    const placaSelect = document.getElementById('placa');
    const resultMessage = document.getElementById('result-message');
    
    // Referencias a todos los inputs de email
    const emailInputs = {
        gestion1: document.getElementById('gestion1'),
        gestion2: document.getElementById('gestion2'),
        gestion3: document.getElementById('gestion3'),
        almacen1: document.getElementById('almacen1'),
        almacen2: document.getElementById('almacen2'),
        almacen3: document.getElementById('almacen3'),
        transporte1: document.getElementById('transporte1'),
        transporte2: document.getElementById('transporte2'),
        transporte3: document.getElementById('transporte3')
    };
    
    // Auto-cargar datos al cambiar la placa
    placaSelect.addEventListener('change', function() {
        if (this.value) {
            loadDataForPlaca(this.value);
        } else {
            clearForm();
        }
    });
    
    // Enviar formulario
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        saveExtMail();
    });
    
    function loadDataForPlaca(placa) {
        // Mostrar indicador de carga
        showMessage('Cargando datos...', 'info');
        
        fetch('../api/getExtMail.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'placa=' + encodeURIComponent(placa)
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                const extMail = data[0];
                // Cargar datos en todos los campos
                emailInputs.gestion1.value = extMail.gestion1 || '';
                emailInputs.gestion2.value = extMail.gestion2 || '';
                emailInputs.gestion3.value = extMail.gestion3 || '';
                emailInputs.almacen1.value = extMail.almacen1 || '';
                emailInputs.almacen2.value = extMail.almacen2 || '';
                emailInputs.almacen3.value = extMail.almacen3 || '';
                emailInputs.transporte1.value = extMail.transporte1 || '';
                emailInputs.transporte2.value = extMail.transporte2 || '';
                emailInputs.transporte3.value = extMail.transporte3 || '';
                showMessage('Datos cargados para ' + placa, 'success');
            } else {
                // Limpiar todos los campos si no hay datos
                clearFormFields();
                showMessage('Sin datos previos para ' + placa + '. Puedes crear un nuevo registro.', 'info');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Error al cargar los datos', 'error');
            clearFormFields();
        });
    }
    
    function saveExtMail() {
        // Validar que se haya seleccionado una placa
        if (!placaSelect.value) {
            showMessage('Selecciona una placa', 'error');
            return;
        }
        
        // Mostrar indicador de guardado
        showMessage('Guardando...', 'info');
        
        const formData = new FormData(form);
        
        fetch('saveExtMail.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message, 'success');
            } else {
                showMessage(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Error al guardar los datos', 'error');
        });
    }
    
    function clearForm() {
        placaSelect.value = '';
        clearFormFields();
        hideMessage();
    }
    
    function clearFormFields() {
        // Limpiar todos los campos de email
        Object.values(emailInputs).forEach(input => {
            input.value = '';
        });
    }
    
    function showMessage(message, type) {
        resultMessage.textContent = message;
        resultMessage.className = 'message ' + type;
        resultMessage.style.display = 'block';
        
        // Auto-ocultar mensajes de éxito e info después de 3 segundos
        if (type === 'success' || type === 'info') {
            setTimeout(() => {
                hideMessage();
            }, 3000);
        }
    }
    
    function hideMessage() {
        resultMessage.style.display = 'none';
    }
});

//botones del menu EXT

$('new').addEventListener('click',()=>{
  document.location.href = '../src/extbrand.php'
})

$('all').addEventListener('click',()=>{
  document.location.href = '../src/ext/orderList.php'
})
  