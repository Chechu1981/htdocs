'use strict';
import { createMail, enviarMailDisgon, createMailMat, createMailExt } from "./createMail.js?105"
import { cesiones, createInputMat, createInputExt, eliminarLinea, disgon, buscarCliente, buscarDenominacionReferencia, updateCounterAssignment} from "./alertsAssigns.js"
import contadores from "./updateCounter.js"

const setCounters = setInterval(() =>{contadores()},1000)
const pclient = $('pclient')
const newTitle = $('newTitle')
const mat = $('refMat')
const inputOrigen = $('origen')
const inputDestino = $('destino')

$('nfm').addEventListener('change', (e) => {
  const origen = inputOrigen.value
  if(origen == 'MAT' || origen == 'EXT'){
    const refMat = mat == null ? 'ZZMAT' : mat.value
    pclient.innerHTML = createInputMat(refMat)
    return null
  }
  cesiones(origen,inputDestino.value,e.target.checked)
})

inputOrigen.addEventListener('change',()=>{
  newTitle.style.fontWeight = ''
  newTitle.classList.remove('copy')
  const origen = inputOrigen.value
  if(origen == 'MAT'){
    const refMat = mat == null ? 'ZZMAT' : mat.value
    pclient.innerHTML = createInputMat(refMat)
    return null
  }
  if(origen == 'EXT'){
    pclient.innerHTML = createInputExt()
    return null
  }
  if(origen != inputDestino.value){
    cesiones(origen,inputDestino.value,$('nfm').checked)
  }else{
    $('provider').innerText = ""
    pclient.innerText = ""
    newTitle.innerText = "Nueva cesión"
  }
})

inputDestino.addEventListener('change',()=>{
  newTitle.style.fontWeight = ''
  newTitle.classList.remove('copy')
  $('frag').checked ? disgon(true) : disgon(false)
  buscarCliente(inputDestino.value.substring(0,3),$('client').value)
  const origen = inputOrigen.value
  if(origen == 'MAT'){
    const refMat = mat == null ? 'ZZMAT' : mat.value
    pclient.innerHTML = createInputMat(refMat)
    return null
  }
  if(origen == 'EXT'){
    pclient.innerHTML = createInputExt()
    return null
  }
  if(origen != inputDestino.value){
    cesiones(origen,inputDestino.value,$('nfm').checked)
  }else{
    $('provider').innerText = ""
    pclient.innerText = ""
    newTitle.innerText = "Nueva cesión"
  }
})

$('frag').addEventListener('change', e =>{
  e.target.checked ? disgon(true) : disgon(false)
})

$('client').addEventListener('blur',(e)=>{
  buscarCliente(inputDestino.value.substring(0,3),$('client').value.split('-')[0])
})

$('ref').addEventListener('blur',() =>{
  buscarDenominacionReferencia($('ref').value)
})

const showAssig = () =>{
  const divSpinner = document.createElement('div')
  fetch('../api/spinner.php')
  .then(fn => fn.text())
  .then(req => {
    divSpinner.innerHTML = req
    divSpinner.className = 'spinner-center'
    $('contacts-items').append(divSpinner)
    $('cesiones').className = 'filter'
  })
  $('descRef').innerHTML = ""
  $('clientName').innerHTML = ""
  const data = new FormData()
  data.append('id','new')
  data.append('session',window.location.href.split('=')[1])
  data.append('sort', 'date')
  fetch('../api/getAssigADV_test.php',{
    method: 'POST',
    body: data
  })
  .then(response => response.text())
  .then(response => {
    $('contacts-items').removeChild(divSpinner)
    $('cesiones').classList.remove('filter')
    const clearRowsMark = (li,text) =>{
      const codeClient = li.childNodes[1].childNodes[6].textContent
      const id = li.childNodes[25].id
      const filas = $('cesiones').getElementsByTagName('ul')
      copyClipboard(text)
      for(let i = 1; i < filas.length; i++){
        const codeClientLi = filas[i].childNodes[1].childNodes[6].textContent
        const idLi = filas[i].childNodes[25].id
        filas[i].classList.remove('marcado')
        filas[i].classList.remove('equal')
        codeClientLi == codeClient && idLi != id ? filas[i].classList.add('equal') : ''
      }
      li.classList.add('marcado')
    }
    $('cesiones').style = ''
    $('cesiones').innerHTML = response
    for(let i = 2; i < $('cesiones').childNodes.length; i = i+2){
      let ul, id, origen, destino, cliente, refCliente, comentario, referencia, cantidad, pedido, fragil, pvp, tratado, nfm, disgon, btnSendMail, btnEliminar, origenLed, rechazo, usuario, btnSendMailDisgon = ''
      ul = $('cesiones').childNodes[i]
      id = ul.childNodes[25].id
      origenLed = ul.childNodes[1].childNodes[1]
      origen = ul.childNodes[1].childNodes[2]
      destino = ul.childNodes[1].childNodes[4]
      cliente = ul.childNodes[5]
      refCliente = ul.childNodes[1].childNodes[6]
      comentario = ul.childNodes[9]
      referencia = ul.childNodes[11]
      cantidad = ul.childNodes[13].textContent
      pedido = ul.childNodes[15].firstChild
      fragil = ul.childNodes[19].firstChild
      disgon = ul.childNodes[21].firstChild
      pvp = ul.childNodes[11].childNodes[1].textContent
      tratado = $(`agente${id}`)
      nfm = ul.childNodes[17].firstChild
      rechazo = ul.childNodes[29].outerHTML.includes('❌') ? $(`rechazo${id}`) : null
      usuario = ul.childNodes[29].outerHTML.includes('❌') ? ul.childNodes[29].childNodes[0].data : ''
      btnSendMail = ul.childNodes[27] != undefined ? ul.childNodes[27].childNodes[0] : null
      btnSendMailDisgon = ul.childNodes[27] != undefined ? ul.childNodes[27].childNodes[1] : null
      btnEliminar = ul.childNodes[25].firstChild

      if(disgon != null)
        disgon.addEventListener('change',() => updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value, destino.textContent))
      if($('cesiones').childNodes[i].localName == 'ul' && $('cesiones').childNodes[i].localName != undefined)
        pedido.addEventListener('keyup', e => refreshInputs(id,nfm.checked,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent))

      nfm.addEventListener('change', () => refreshInputs(id,nfm.checked,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent))
      fragil.addEventListener('change', () => refreshInputs(id,nfm.checked,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent))
      tratado.addEventListener('change', () => {refreshInputs(id,nfm.checked,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent)})
      referencia.addEventListener('click', () => {clearRowsMark(ul,referencia.childNodes[0].textContent.replaceAll(' ',''))})
      comentario.addEventListener('click', () => {clearRowsMark(ul,comentario.textContent)})
      comentario.childNodes[0].addEventListener('keyup', () => {updateCounterAssignment(id,comentario.firstElementChild.value)})
      cliente.addEventListener('click', () => {
        let fragilTxt = ''
        if(disgon != null){
          disgon.checked && $(`disgon${id}`).innerHTML == '📦' ? fragilTxt += 'Recoge LOGISTICA. ' : ''
          disgon.checked && $(`disgon${id}`).innerHTML == '🚚' ? fragilTxt += 'Recoge DISGON. ' : ''
        }
        fragil.checked ? fragilTxt += '..~** ¡¡MATERIAL FRÁGIL!! **~..REFORZAR EMBALAJE;' : ''
        clearRowsMark(ul,`Cesión ${origen.value}>${destino.textContent} - Cliente: ${cliente.childNodes[0].textContent} (${cliente.childNodes[1].textContent}) ${fragilTxt}`)
      })
      refCliente.addEventListener('click', () => {
        let texto = `Cliente: ${cliente.childNodes[0].textContent}`
        if(origen.value == 'MAT')
          texto = $(`origen${id}`).parentNode.childNodes[6].innerText
        if(origen.value == 'EXT')
          texto = 'Cesión externa'
        clearRowsMark(ul, texto)
      })
      
      if(user.puesto == 'ADV'){
        origen.addEventListener('change', (e) => {
          refreshInputs(id,nfm.checked,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent)
          })
        origenLed.addEventListener('click', (e) => {
          e.target.classList.toggle('ledOn')
          updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value,destino.textContent)
        })
        destino.addEventListener('click', () => {
          destino.classList.toggle('active-city-press')
          updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value,destino.textContent)
        })
      }

      if(rechazo != null){
        rechazo.addEventListener('click', ()=>{
          const data = new FormData()
          data.append('id',id)
          data.append('switch',true)
          data.append('usuario',usuario)
          data.append('tratado',user.nombre.toUpperCase())
          fetch('../helper/formRechazo.php',{
            method: 'POST',
            body: data
          })
          .then((inp) => inp.text())
          .then(items => {
            modal(items,`Rechazar la cesión de ${origen.value} -> ${destino.textContent}`)
            const texto = document.getElementById("texto")
            const enviar = document.getElementById("enviar")
            const cancelar = document.getElementById("cancelar")
            cancelar.addEventListener("click", () => {
              $('close').click()
            })
            enviar.addEventListener("click", () => {
              data.append('texto',`(${user.nombre}) ${texto.value}`)
              const fecha = new Date()
              const mailSaludo = fecha.getHours() > 14 ? `Buenas tardes: ` : `Buenos días: `
              const mailTarget = encodeURIComponent(`
              ${texto.value}
              
              
              Un saludo ${user.nombre}`)
              fetch('../api/getEmailByUsername.php',{
                method: 'POST',
                body: data
              })
              .then(usrAll => usrAll.json())
              .then(usrSend => {
                window.open(`mailto:${usrSend.mail}?subject=Cesión de la ${referencia.childNodes[0].textContent.replaceAll(' ','')} rechazada&body=${mailSaludo + mailTarget}`)
              })
              fetch('../api/updateRechazo.php',{
                method: 'POST',
                body: data
              })
              ul.remove()
              $('close').click()
            })
          })
        })
      }

      if(btnSendMail != null){
        btnSendMail.addEventListener('click',() => enviarMail(pedido.value, origen.value, destino.textContent, referencia.firstChild.textContent.replaceAll(' ',''), `${cliente.firstChild.textContent} (${cliente.childNodes[1].textContent})`, fragil.checked, pvp, id, cantidad, nfm.checked, tratado.value, refCliente.innerText,comentario.firstChild.innerHTML))
        if(btnSendMailDisgon != null)
          btnSendMailDisgon.addEventListener('click',(e) => {
            if(e.target.innerHTML == '🚚')
              enviarMailDisgon(cantidad, origen.value, destino.textContent, referencia.firstChild.textContent.replaceAll(' ',''), id,comentario.firstChild.innerHTML)
            else if(e.target.innerHTML == '📦')
              window.open("https://recambios.logistica.com/page/index.aspx"),$(`disgon${id}`).innerHTML = "✅"
          })
        }
        btnEliminar.addEventListener('click', () => eliminarLinea(id,referencia.firstChild.textContent.replaceAll(' ',''),tratado.value))
      }
  })
}

const enviarMail = (pedido, origen, destino, referencia, cliente, fragil, pvp, id, cantidad, nfm, tratado, refCliente,comentario) =>{
  if($(`disgon${id}`).innerHTML == "🚚" || $(`disgon${id}`).innerHTML == "📦"){
    customAlert("Debes enviar primero el correo a Disgón o Logistica")
    return false
  }
  const dataName = new FormData()
  let disgon = 0
  if($(id).parentNode.childNodes[21].firstChild != null){
    if($(id).parentNode.childNodes[21].firstChild.checked){
      disgon = origen == 'SANTIAGO' ? 1 : 2
    }
  }
  dataName.append('id', id)
  dataName.append('nfm',nfm)
  dataName.append('fragil',fragil)
  dataName.append('pedido',pedido)
  dataName.append('tratado',tratado)
  dataName.append('envio', true)
  dataName.append('disgon', disgon)
  dataName.append('origenBtn', '1')
  dataName.append('destinoBtn', '1')
  dataName.append('origen', origen)
  dataName.append('destino', destino)
  dataName.append('destinoC', `${destino}C`)
  dataName.append('origenF', `${origen}F`)
  dataName.append('comentario', comentario)
  dataName.append('misterauto', refCliente)
  fetch('../api/isSend.php',{
    method: 'POST',
    body: dataName
  })
  .then((isSend)=>isSend.text())
  .then(enviado => {
    if(enviado){
      customAlert("Esta cesión ya está enviada")
      $(`send${id}`).parentNode.remove()
      return true
    }
    if(confirm(`¿Enviar Correo?`)){
      fetch('../api/updateAssignADV2023.php', {
        method: 'POST',
        body:dataName
      })
      .then((item) => item.text())
      .then(() => {
        fetch('../api/getBccMails.php',{
          method: 'POST',
          body: dataName
        })
        .then(response => response.json())
        .then(res => {
          if(origen == 'MAT'){
            createMailMat(cantidad,refCliente,destino,referencia,cliente,pedido,nfm,fragil,res['fragil'])
          }else if(origen == 'EXT')
            createMailExt(cantidad,refCliente,destino,referencia,cliente,pedido,nfm,fragil,res['fragil'],res['conCopia'])
          else{
            let destinoFragil = ''
            if(fragil){
              destinoFragil = res['fragil']
            }
            createMail(cantidad,origen,destino,referencia,cliente,pedido,nfm,fragil,destinoFragil,res['origen'],res['destino'],res['conCopia'],disgon)
          }
          $(`send${id}`).parentNode.parentNode.remove()
          updateBubble('-')
        })
      })
    }
  })
}

const refreshInputs = (id,nfm,fragil,pedido,tratado,origen,destino) => {
  let cesion = null
  let code = $(id).parentNode.childNodes[1].childNodes[6]
  origen != destino ? cesion = origen + '' + destino : ''
  nfm ? cesion += 'NM' : ''
  if(origen != 'MAT' && origen != 'EXT'){
    fetch('../json/cesionesCliente.json?104')
    .then(response => response.json())
    .then(response => {
      response[cesion] != undefined ? code.innerHTML = response[cesion] : code.innerHTML = ""
    })
  }else{
    const session = window.location.search.split('?id=')[1]
    const data = new FormData()
    data.append('id', id)
    data.append('session', session)
    fetch('../api/getAssignZzmat.php',{
      method: 'POST',
      body: data
    })
    .then(response => response.json())
    .then(response => {
      const refZZMAT = document.getElementById(`destinoBtn${id}`).parentNode.childNodes[6]
      refZZMAT.innerHTML = `<span class="copy " style="grid-column: 1 / 4;font-size: medium;">${response.refClient}</span>`
    })
  }
  updateChkbx(id,nfm,fragil,pedido,tratado,destino)
}

const copyClipboard = (copiar) =>{
  navigator.clipboard.writeText(copiar)
  notify(`${copiar} copiado!`)
}

const updateBubble = (operador) =>{
  const bubble = $('contacts').childNodes[3].childNodes[1].childNodes[0]
  const bubbleAll = $('contacts').childNodes[3].childNodes[3].childNodes[0]
  const bubbleReady = $('contacts').childNodes[3].childNodes[7].childNodes[0]
  if(operador == '-'){
    bubble != undefined ? bubble.innerText = parseInt(bubble.innerText) - 1 : ''
    bubbleAll != undefined ? bubbleAll.innerText = parseInt(bubbleAll.innerText) - 1 : ''
    bubbleReady != undefined ? bubbleReady.innerText = parseInt(bubbleReady.innerText) - 1 : ''
  }else{
    bubble != undefined ? bubble.innerText = parseInt(bubble.innerText) + 1 : ''
    bubbleAll != undefined ? bubbleAll.innerText = parseInt(bubbleAll.innerText) + 1 : ''
    bubbleReady != undefined ? bubbleReady.innerText = parseInt(bubbleReady.innerText) + 1 : ''
  }
}

const updateChkbx = (id,nfm,fragil,pedido,tratado,destino) => {
  const disgon = $(id).parentNode.childNodes[21].firstChild == null ? false : $(id).parentNode.childNodes[21].firstChild.checked
  const origenBtn = $(id).parentNode.childNodes[1].childNodes[1].className.includes('ledOn') ? '1':'0'
  const destinoBtn = $(`destinoBtn${id}`).className.includes('press') ? '1':'0'
  const origen = $(`origen${id}`).nodeName == 'SELECT' ? $(`origen${id}`).value : $(`origen${id}`).innerHTML
  const comentario = $(`coment${id}`).value
  const data = new FormData()
  data.append('id', id)
  data.append('nfm',nfm)
  data.append('fragil',fragil)
  data.append('pedido',pedido)
  data.append('tratado',tratado)
  data.append('envio', false)
  data.append('disgon', disgon)
  data.append('comentario', comentario)
  data.append('origenBtn', origenBtn)
  data.append('destinoBtn', destinoBtn)
  data.append('origen', origen)
  fetch('../api/updateAssignADV2023.php',{
    method: 'POST',
    body: data
  })
  const disgonLi = $(`${id}`).parentNode.childNodes[21]
  const disgonSend = $(`${id}`).parentNode.childNodes[27] != undefined ? $(`${id}`).parentNode.childNodes[27].childNodes[1]: null
  if(fragil && disgonLi.firstChild == undefined) {
    const chkDisgon = document.createElement('input')
    chkDisgon.setAttribute('type', 'checkbox')
    chkDisgon.addEventListener('change', () => {
      updateChkbx(id,nfm,fragil,pedido,tratado, destino)
    })
    disgonLi.appendChild(chkDisgon)
  }
  if(disgonSend != null && user.puesto == 'ADV' && fragil){
    if(disgonLi.childNodes[0].checked){
      disgonSend.innerText = '📦'
      if(origen == 'SANTIAGO')
        disgonSend.innerText = '🚚'
      if(origen == 'VALENCIA')
        disgonSend.innerText = ''
    }
    else if(!disgonLi.childNodes[0].checked)
      disgonSend.innerText = ''
  }
  if(!fragil && disgonLi.firstChild != null){
    disgonLi.firstChild.remove()
    disgonSend.innerHTML = ''
  }
}

const updateAssig = (id,values) => {
  console.log(id + ': ' + values)
}

const disabledForm = () =>{
  const formInputs = $('contacts-items').getElementsByTagName('form')[0].getElementsByTagName('input')
  const formSelects = $('contacts-items').getElementsByTagName('form')[0].getElementsByTagName('select')
  for(let i = 0; i < formInputs.length; i++)
    formInputs[i].disabled = true
  for(let i = 0; i < formSelects.length; i++)
    formSelects[i].disabled = true
}

const enabledForm = () =>{
  const formInputs = $('contacts-items').getElementsByTagName('form')[0].getElementsByTagName('input')
  const formSelects = $('contacts-items').getElementsByTagName('form')[0].getElementsByTagName('select')
  for(let i = 0; i < formInputs.length; i++)
    formInputs[i].disabled = false
  for(let i = 0; i < formSelects.length; i++)
    formSelects[i].disabled = false
}

$$('form')[0].addEventListener('submit',(e)=>{
  document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = true
  pclient.classList.remove('important')
  pclient.classList.remove('route')
  e.preventDefault()
  const origen = inputOrigen.value
  const destino = $('destino').value
  const envio = $('envio').value
  const cliente = $('client').value
  const pedido = $('pedido').value
  const ref = $('ref').value.replaceAll(/\t/g, '')
  const cantidad = $('units').value
  const nfm = $('nfm').checked
  let refMat = ''
  if(origen == 'MAT'){
    refMat = mat.value
    if(refMat == 'ZZMAT' || refMat == ''){
      customAlert('Falta indicar la referencia de Mister-auto')
      mat.style.backgroundColor = 'red';
      document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
      return false
    }
  }
  if(origen == 'EXT'){
    refMat = mat.value
    if(refMat == ''){
      customAlert('Falta indicar el nombre del proveedor')
      mat.style.backgroundColor = 'red';
      document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
      return false
    }
  }
  if(origen === destino){
    customAlert('El destino y el origen debe ser diferente')
    document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
    return false
  }
  if(cliente === ''){
    customAlert('Debes rellenar el cliente')
    document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
    $('client').focus()
    return false
  }
  if(envio === ''){
    customAlert('La dirección de envio no puede estar vacía')
    document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
    $('envio').focus()
    return false
  }
  else if(ref === ''){
    customAlert('Debes rellenar la referencia')
    document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
    $('ref').focus()
    return false
  }
  else if(cantidad === ''){
    customAlert('Debes rellenar la cantidad')
    document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
    $('units').focus()
    return false
  }
  disabledForm()
  const divSpinner = document.createElement('div')
  fetch('../api/spinner.php')
  .then(fn => fn.text())
  .then(req => {
    divSpinner.innerHTML = req
    divSpinner.className = 'spinner-center'
    $('contacts-items').append(divSpinner)
    $('cesiones').className = 'filter'
  })
  let disgonStatus = false
  const data = new FormData() 
  data.append('origen',origen)
  data.append('destino',destino)
  data.append('cliente',`${cliente}-${envio}`)
  data.append('refClient', refMat)
  data.append('comentario',$('coment').value)
  data.append('ref',ref)
  data.append('cantidad',cantidad)
  data.append('pvp','')
  data.append('pedido',pedido)
  data.append('nfm',nfm)
  data.append('frag',$('frag').checked)
  data.append('session',window.location.href.split('=')[1])
  $('disgonBox') == null ? null : disgonStatus = $('disgonBox').checked
  data.append('disgon', disgonStatus)
  fetch('../api/addAsignADV2023.php',{
    method: 'POST',
    body:data
  })
  .then(response => response.text())
  .then(res =>{
    if(res == 'Error')
      customAlert("🚫No se pueden hacer cesiones desde Granada de baterías ni de aceite Eurorepar hasta Enero 2025. Consultar en ADV.")
      res = 'ok'
    if(res == 'ok'){
      showAssig()
      enabledForm()
      newTitle.innerHTML = "Nueva cesión"
      pclient.innerHTML = ""
      $('contacts-items').removeChild(divSpinner)
      $('cesiones').classList.remove('filter')
      document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
      updateBubble('+')
      e.target.reset()
      let puesto = user.puesto
      if(user.puesto == 'GALICIA')
        puesto = 'SANTIAGO'
      $('destino').value = puesto
      if($('disgonBox'))
        $('disgonDiv').remove()
    }
  })
})

showAssig()

const id = window.location.search.split('?id=')[1]
const btnAll = document.getElementById('all') ?? 0

if(btnAll){
  btnAll.addEventListener('click',()=>{
    document.location = `./cesionesAll.php?id=${id}`
  })
}

document.getElementById('new').addEventListener('click',()=>{
  document.location.reload()
})

document.getElementById('find').addEventListener('click',()=>{
  document.location = `./assigns/buscar.php?id=${id}`
})

document.getElementById('ready').addEventListener('click',()=>{
  document.location = `./assigns/ready.php?id=${id}`
})

document.getElementById('finish').addEventListener('click',()=>{
  document.location = `./assigns/finish.php?id=${id}`
})

document.getElementById('status').addEventListener('click',()=>{
  document.location = `./assigns/status.php?id=${id}`
})

/* Se colorea los fondos de los input cuando hay algo escrito */
$$('form')[0].addEventListener('keyup',(e)=>{
  if(!$$('form')[0].childNodes[1] == false && !$$('form')[0].childNodes[1].className != 'form-group'){
    for (var element = 0;element < $$('form')[0].length;element++){
      $$('form')[0][element].value != '' ? $$('form')[0][element].classList.add('fondo') : $$('form')[0][element].classList.remove('fondo')
    }
  }
})