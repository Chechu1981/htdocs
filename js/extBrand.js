'use strict'
import { buscarCliente } from "./alertsAssigns.js?106"
const btnAll = document.getElementById('all') ?? 0

if(btnAll){
  btnAll.addEventListener('click',()=>{
    document.location = `../cesionesAll.php`
  })
}

document.getElementById('new').addEventListener('click',()=>{
  document.location = `../cesionesADV.php`
})

document.getElementById('extBrand').addEventListener('click',()=>{
  document.location.reload()
})

document.getElementById('find').addEventListener('click',()=>{
  document.location = `./buscar.php`
})

document.getElementById('ready').addEventListener('click',()=>{
  document.location = `./ready.php`
})

document.getElementById('finish').addEventListener('click',()=>{
  document.location = `./finish.php`
})

document.getElementById('status').addEventListener('click',()=>{
  document.location = `./status.php`
})

$('dtoVenta0').addEventListener('keydown',(e)=>{
  if(e.key === 'Tab'){
    e.preventDefault()
    crearLineas(0)
  }
})

let contadorLineas = 1

const crearLineas = (id) =>{
  let inputRef = document.createElement('input')
  let inputUni = document.createElement('input')
  let inputDesc = document.createElement('input')
  let inputPvp = document.createElement('input')
  let inputDtoCompra = document.createElement('input')
  let inputDtoVenta = document.createElement('input')
  let familySelect = document.createElement('select')
  let familyOpt1 = document.createElement('option')
  let familyOpt2 = document.createElement('option')
  let familyOpt3 = document.createElement('option')
  let familyOpt4 = document.createElement('option')
  let img = document.createElement('img')
  let span = document.createElement('span')
  let section = document.createElement('section')
  inputRef.id = `ref${contadorLineas}`
  inputUni.id = `units${contadorLineas}`
  inputDesc.id = `comentLine${contadorLineas}`
  familySelect.id = `familyParts${contadorLineas}`
  inputPvp.id = `pvp${contadorLineas}`
  inputDtoCompra.id = `dtoCompra${contadorLineas}`
  inputDtoVenta.id = `dtoVenta${contadorLineas}`
  inputDtoVenta.addEventListener('keydown',(e)=>{
    if(e.key === 'Tab'){
      e.preventDefault()
      crearLineas(id)
    }
  })
  familyOpt1.value = ''
  familyOpt1.innerText = ''
  familyOpt2.innerText = 'Carrocería'
  familyOpt3.innerText = 'Mecánica'
  familyOpt4.innerText = 'Reman'
  familyOpt2.value = 'CARROCERIA'
  familyOpt3.value = 'MECANICA'
  familyOpt4.value = 'REMAN'
  familySelect.appendChild(familyOpt1)
  familySelect.appendChild(familyOpt2)
  familySelect.appendChild(familyOpt3)
  familySelect.appendChild(familyOpt4)
  img.src = '../../img/delete_FILL0_wght400_GRAD0_opsz24.png'
  img.alt = 'Eliminar'
  img.title = 'Eliminar'
  img.className = 'deleteLine'
  span.innerText = ++contadorLineas
  img.id = `delete${contadorLineas}`
  section.appendChild(span)
  section.appendChild(inputRef)
  section.appendChild(inputUni)
  section.appendChild(inputDesc)
  section.appendChild(familySelect)
  section.appendChild(inputPvp)
  section.appendChild(inputDtoCompra)
  section.appendChild(inputDtoVenta)
  section.appendChild(img)
  
  $(`formLine${id}`).appendChild(section)
  inputRef.focus()
}

$('addLine').addEventListener('click',(e)=>{
  e.preventDefault()
  crearLineas(e.target.parentNode.parentNode.childNodes[3].id.split('formLine')[1])
})

$('client').addEventListener('blur',(e)=>{
  buscarCliente($('destino').value.substring(0,3),$('client').value.split('-')[0])
})

const clearImportant = () => {
  for (const select of $$('select')) {
    select.classList.remove('important')
  }
  for (const input of $$('input')) {
    input.classList.remove('important')
  }
}

/*$('sendProv').addEventListener('click',(e)=>{
  clearImportant()
  const tipo = $('tipo')
  const marca = $('marca')
  const destino = $('destino')
  const cliente = $('client')
  const envio = $('envio')
  const coment = $('coment')
  if(destino.value === ''){
    customAlert('Debe seleccionar un destino')
    destino.classList.add('important')
    return
  }
  if(cliente.value === ''){
    customAlert('Debe seleccionar un cliente')
    cliente.classList.add('important')
    return
  }
  if(envio.value === ''){
    customAlert('Debe seleccionar un envío')
    envio.classList.add('important')
    return
  }
  if(marca.value === ''){
    customAlert('Debe seleccionar una marca')
    marca.classList.add('important')
    return
  }
  if(tipo.value === ''){
    customAlert('Debe seleccionar un tipo de recambio')
    tipo.classList.add('important')
    return
  }
  const orderExt = new FormData()
  orderExt.append('id',user.hash)
  orderExt.append('tipo',tipo.value)
  orderExt.append('marca',marca.value)
  orderExt.append('destino',destino.value)
  orderExt.append('cliente',cliente.value)
  orderExt.append('envio',envio.value)
  orderExt.append('comentarios',coment.value)
  let lineas = []
  for (let i = 0; i <= contadorLineas - 1; i++) {
    lineas.push({
      referencia: $(`ref${i}`).value,
      cantidad: $(`units${i}`).value,
      designacion: $(`comentLine${i}`).value,
      familia: $(`familyParts${i}`).value
    })
  }

  orderExt.append('lineas', JSON.stringify(lineas))

  //e.target.disabled = true
  e.preventDefault()
  $('senMail').disabled = false
  fetch(src + 'api/addListExt.php',{
    method: 'POST',
    body: orderExt
  })
  .then(e => e.json())
  .then((csvlineas)=>{
    //CREA UN FICHERO CSV CON LOS CAMPOS REFERENCIA Y DESIGNACION
    let csvLineas = ''
    csvlineas.forEach(element => {
      csvLineas += `${element}\n`
    });
    let csvContent = "data:text/csv;charset=utf-8," + encodeURIComponent(csvLineas)
    const link = document.createElement("a")
    link.setAttribute("href", csvContent)
    link.setAttribute("download", "contacts.csv")
    document.body.appendChild(link)
    link.click()
  })
})*/

$('addOrder').addEventListener('click',(e)=>{
  e.preventDefault()
  customAlert('Funcionalidad en desarrollo')
})

$('selectProv').addEventListener('click',(e)=>{
  let date = new Date()
  e.preventDefault()
  let lineas = []
  let lineasPedidoEnCurso = $('prov0').childNodes[3].childNodes
  for (let i = 3; i < lineasPedidoEnCurso.length; i = i + 2) {
    lineas.push({
      referencia: lineasPedidoEnCurso[i].getElementsByTagName('input')[0].value,
      cantidad: lineasPedidoEnCurso[i].getElementsByTagName('input')[1].value,
      designacion: lineasPedidoEnCurso[i].getElementsByTagName('input')[2].value,
      pvp: lineasPedidoEnCurso[i].getElementsByTagName('input')[3].value,
      dtoCompra: lineasPedidoEnCurso[i].getElementsByTagName('input')[4].value
    })
  }
  if(lineas.length === 0){
    customAlert('Debe añadir al menos una línea de recambio')
    return
  }
  let saludo = date.getHours() < 13 ? 'Buenos días' : 'Buenas tardes'
  let mail = {
    to: $('client').value,
    subject: 'Nueva pedido PPCR Otras Marcas',
    body: `${saludo}: 
      %0ASolicito el siguiente listado de piezas de recambio:

      ${lineas.map(linea => `%0A
        ${linea.cantidad} ${linea.cantidad > 1 ? 'unidades de la referencia' : 'unidad de la referencia'} ${linea.referencia}(${linea.designacion})
        PVP: ${linea.pvp}€ - ${linea.dtoCompra}%
      `).join('')}
      %0A%0APor favor, adjuntar el albarán en este mismo hilo de correos.
      %0AMuchas gracias.`
  }
  window.location.href = `mailto:destinatarioProveedor?subject=${mail.subject}&body=${mail.body}` //
})

$('addProvider').addEventListener('click',(e)=>{
  let countProv = document.getElementsByClassName('form-extLine').length
  e.preventDefault()
  let divContainer = document.createElement('div')
  let divHeader = document.createElement('div')
  let divLine = document.createElement('div')
  let divAddLine = document.createElement('div')
  let divSubmit = document.createElement('div')
  let divSumnitOrder = document.createElement('div')
  let sectionHeader = document.createElement('section')
  let spanNumerLine = document.createElement('span')
  let selectTipo = document.createElement('select')
  let selectMarca = document.createElement('select')
  let selectProveedor = document.createElement('select')
  let lblReferencia = document.createElement('label')
  let lblCantidad = document.createElement('label')
  let lblDesignacion = document.createElement('label')
  let lblFamilia = document.createElement('label')
  let lblPVP = document.createElement('label')
  let lblDtoCompra = document.createElement('label')
  let lblDtoVenta = document.createElement('label')
  let btnNewLine = document.createElement('button')
  let btnPpo = document.createElement('button')
  let btnOrder = document.createElement('button')
  // Aquí puedes añadir las opciones a los select
  let options = ['DirIberica', 'Proveedor 2 Hyundai', 'Proveedor 3 BMW']
  let optTipo = ['Recambio Original', 'Recambio Paralelo']
  let optMarcas = ['Ford', 'Toyota', 'Honda','Chevrolet','Nissan','Volkswagen','Hyundai','Kia','Renault','Peugeot','Citroën','Fiat','Jeep','Mazda','Subaru','Dacia','Seat','Skoda','Opel','Mini','BMW','Mercedes-Benz','Audi']
  lblReferencia.textContent = '*Referencia PR'
  lblCantidad.textContent = '*Cantidad'
  lblDesignacion.textContent = '*Descripción'
  lblFamilia.textContent = '*Familia'
  lblPVP.textContent = '*PVP'
  lblDtoCompra.textContent = '*Dto Compra'
  lblDtoVenta.textContent = '*Dto Venta'
  divContainer.id = `prov${countProv}`
  divLine.id = `formLine${countProv}`
  divContainer.classList.add('form-extLine')
  divHeader.classList.add('provHeader')
  divLine.classList.add('formLine')
  divAddLine.classList.add('addLine')
  divSubmit.classList.add('submitOrder')
  divSumnitOrder.classList.add('submitOrder')
  btnNewLine.textContent = 'Añadir línea'
  btnNewLine.id = 'addLine'
  btnNewLine.addEventListener('click',(e)=>{
    e.preventDefault()
    crearLineas(countProv)
  })
  btnPpo.textContent = 'Solicitar presupuesto al proveedor'
  btnPpo.addEventListener('click',(e)=>{
    e.preventDefault()
    customAlert('Funcionalidad en desarrollo')
  })
  btnPpo.id = 'selectProv'
  btnOrder.textContent = 'Confirmar pedido'
  btnOrder.addEventListener('click',(e)=>{
    e.preventDefault()
    customAlert('Funcionalidad en desarrollo')
  })
  btnOrder.id = 'addOrder'
  options.forEach(option => {
    let opt = document.createElement('option')
    opt.value = option
    opt.textContent = option
    selectMarca.appendChild(opt)
    selectProveedor.appendChild(opt)
  })
  optTipo.forEach(option => {
    let opt = document.createElement('option')
    opt.value = option
    opt.textContent = option
    selectTipo.appendChild(opt)
  })
  optMarcas.forEach(option => {
    let opt = document.createElement('option')
    opt.value = option
    opt.textContent = option
    selectMarca.appendChild(opt)
  })
  selectTipo.id = `tipo${contadorLineas}`
  selectMarca.id = `marca${contadorLineas}`
  selectProveedor.id = `proveedor${contadorLineas}`
  
  $('contacts-items').appendChild(selectTipo)
  $('contacts-items').appendChild(selectMarca)
  $('contacts-items').appendChild(selectProveedor)
  sectionHeader.appendChild(spanNumerLine)
  sectionHeader.appendChild(lblReferencia)
  sectionHeader.appendChild(lblCantidad)
  sectionHeader.appendChild(lblDesignacion)
  sectionHeader.appendChild(lblFamilia)
  sectionHeader.appendChild(lblPVP)
  sectionHeader.appendChild(lblDtoCompra)
  sectionHeader.appendChild(lblDtoVenta)
  divHeader.appendChild(selectTipo)
  divHeader.appendChild(selectMarca)
  divHeader.appendChild(selectProveedor)
  divSumnitOrder.appendChild(btnPpo)
  divSumnitOrder.appendChild(btnOrder)

  divContainer.appendChild(divHeader)
  divLine.appendChild(sectionHeader)
  divContainer.appendChild(divLine)
  divContainer.appendChild(btnNewLine)
  divContainer.appendChild(divSumnitOrder)
  $$('form')[0].appendChild(divContainer)
  crearLineas(countProv)
})

// Elimina la fila creada al hacer click sobre la imagen de eliminar
$('contacts-items').addEventListener('click',(e)=>{
  if(e.target.tagName === 'IMG'){
    let id = e.target.id.substring(6)
    let div = document.getElementById(`delete${id}`)
    div.parentNode.remove()
    contadorLineas--
  }
})