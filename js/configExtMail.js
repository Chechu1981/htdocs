document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('extMailForm');
    const placaSelect = document.getElementById('placa');
    const resultMessage = document.getElementById('result-message');
    
    // Referencias a las cajas de texto de email
    const emailTextareas = {
        gestion: document.getElementById('gestion'),
        almacen: document.getElementById('almacen'),
        transporte: document.getElementById('transporte')
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
            body: JSON.stringify({
                'placa': placa,
                'proveedor': '',
                'usuario': user.hash
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                const extMail = data[0];
                // Cargar datos en las cajas de texto, combinando los campos individuales
                
                emailTextareas.gestion.value = extMail.gestion1;
                emailTextareas.almacen.value = extMail.almacen1;
                emailTextareas.transporte.value = extMail.transporte1;
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
        
        // Procesar las cajas de texto para extraer emails individuales
        const gestionEmails = emailTextareas.gestion.value
        const almacenEmails = emailTextareas.almacen.value
        const transporteEmails = emailTextareas.transporte.value
        
        // Crear FormData con los campos individuales para mantener compatibilidad con el backend
        const formData = new FormData();
        formData.append('placa', placaSelect.value);
        
        // Agregar emails de gestión
        formData.append('gestion', gestionEmails || '');
        
        // Agregar emails de almacén
        formData.append('almacen', almacenEmails || '');
        
        // Agregar emails de transporte
        formData.append('transporte', transporteEmails || '');
        
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
        // Limpiar todas las cajas de texto de email
        Object.values(emailTextareas).forEach(textarea => {
            textarea.value = '';
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
  