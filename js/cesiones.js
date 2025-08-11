'use strict';
import { createMail, enviarMailDisgon, createMailMat, createMailExt, createMailProv} from "./createMail.js?124"
import { cesiones, createInputMat, createInputExt, eliminarLinea, esDisgon, buscarCliente, buscarDenominacionReferencia, updateCounterAssignment, buscar_ultimo_correo} from "./alertsAssigns.js?112"
import contadores from "./updateCounter.js?102"

const setCounters = setInterval(() =>{contadores()},1000)
const pclient = $('pclient')
const newTitle = $('newTitle')
const inputOrigen = $('origen')
const inputDestino = $('destino')

$('nfm').addEventListener('change', (e) => {
  const origen = inputOrigen.value
  const disgon = $('disgonBox') ?? ''
  if(origen == 'MAT'){
    const refMat = $('refMat') == null ? 'ZZMAT' : $('refMat').value
    pclient.innerHTML = createInputMat(refMat,inputDestino.value)
    return null
  }else if(origen == 'EXT'){
    pclient.innerHTML = createInputExt($('destino').value)
    return null
  }
  cesiones(origen,inputDestino.value,e.target.checked,disgon.checked)
})

inputOrigen.addEventListener('change',()=>{
  newTitle.style.fontWeight = ''
  newTitle.classList.remove('copy')
  const origen = inputOrigen.value
  if(origen == 'MAT'){
    const refMat = $('refMat') == null ? 'ZZMAT' : $('refMat').value
    pclient.innerHTML = createInputMat(refMat,inputDestino.value)
    return null
  }
  if(origen == 'EXT'){
    createInputExt($('destino').value)
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
  $('frag').checked ? esDisgon(true) : esDisgon(false)
  buscarCliente(inputDestino.value.substring(0,3),$('client').value)
  const origen = inputOrigen.value
  if(origen == 'MAT'){
    const refMat = $('refMat') == null ? 'ZZMAT' : $('refMat').value
    pclient.innerHTML = createInputMat(refMat,inputDestino.value)
    return null
  }
  if(origen == 'EXT'){
    pclient.innerHTML = createInputExt($('destino').value)
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
  e.target.checked ? esDisgon(true) : esDisgon(false)
})

$('client').addEventListener('blur',(e)=>{
  buscarCliente(inputDestino.value.substring(0,3),$('client').value.split('-')[0])
})

$('ref').addEventListener('blur',() =>{
  buscarDenominacionReferencia($('ref').value)
})

const showAssig = () =>{
  const divSpinner = document.createElement('div')
  $('descRef').innerHTML = ""
  $('clientName').innerHTML = ""
  const id = getIdByCookie(document.cookie)
  const data = new FormData()
  data.append('id','new')
  data.append('session',id)
  data.append('sort', 'date')
  fetch('../api/spinner.php')
  .then(fn => fn.text())
  .then(req => {
    divSpinner.innerHTML = req
    divSpinner.className = 'spinner-center'
    $('contacts-items').append(divSpinner)
    $('cesiones').className = 'filter'
  
    return fetch('../api/getAssigADV.php',{
      method: 'POST',
      body: data
    })
    .then(response => response.text())
    .then(response => {
      $('contacts-items').removeChild(divSpinner)
      $('cesiones').classList.remove('filter')
      const clearRowsMark = (li,text) =>{
        const codeClient = li.childNodes[3].childNodes[4].textContent
        const id = li.childNodes[27].id
        const filas = $('cesiones').getElementsByTagName('ul')
        copyClipboard(text)
        for(let i = 1; i < filas.length; i++){
          const codeClientLi = filas[i].childNodes[3].childNodes[4].textContent
          const idLi = filas[i].childNodes[27].id
          filas[i].classList.remove('marcado')
          filas[i].classList.remove('equal')
          codeClientLi == codeClient && idLi != id ? filas[i].classList.add('equal') : ''
        }
        li.classList.add('marcado')
      }
      $('cesiones').style = ''
      $('cesiones').innerHTML = response
      for(let i = 2; i < $('cesiones').childNodes.length; i = i+2){
        let ul, id, origen, destino, cliente, refCliente, comentario, referencia, cantidad, pedido, fragil, pvp, tratado, nfm, disgon, btnSendMail, btnEliminar, origenLed, rechazo, usuario, btnSendMailDisgon, correo_proveedor, btnPause = ''
        ul = $('cesiones').childNodes[i]
        id = ul.childNodes[27].id
        origenLed = ul.childNodes[1].childNodes[0]
        origen = ul.childNodes[3].childNodes[1]
        destino = ul.childNodes[3].childNodes[2]
        cliente = ul.childNodes[7]
        refCliente = ul.childNodes[3].childNodes[4].childNodes[0].name === undefined ? ul.childNodes[3].childNodes[4] : $(`proveedorExterno${id}`).value
        comentario = ul.childNodes[11]
        referencia = ul.childNodes[13]
        cantidad = ul.childNodes[15].textContent
        pedido = ul.childNodes[17].firstChild
        fragil = ul.childNodes[21].firstChild
        disgon = ul.childNodes[23].firstChild
        pvp = ul.childNodes[13].childNodes[1].textContent
        tratado = $(`agente${id}`)
        nfm = ul.childNodes[19].firstChild
        rechazo = ul.childNodes[31].outerHTML.includes('❌') ? $(`rechazo${id}`) : null
        usuario = ul.childNodes[31].outerHTML.includes('❌') ? ul.childNodes[31].childNodes[0].data : ''
        btnSendMail = ul.childNodes[29] != undefined ? ul.childNodes[29].childNodes[0] : null
        btnSendMailDisgon = ul.childNodes[29] != undefined ? ul.childNodes[29].childNodes[1] : null
        btnEliminar = ul.childNodes[27].firstChild
        correo_proveedor = ul.childNodes[3].childNodes[4].childNodes.length > 1 ? ul.childNodes[3].childNodes[4].childNodes[1].innerText : ''
        btnPause = ul.childNodes[27].childNodes[1]
        if(disgon != null){
          disgon.addEventListener('change',(e) => {
            updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value, destino.textContent),
            refreshInputs(id,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent)
          })
        }
        if($('cesiones').childNodes[i].localName == 'ul' && $('cesiones').childNodes[i].localName != undefined)
          pedido.addEventListener('blur', () => refreshInputs(id,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent))

        nfm.addEventListener('change', () => refreshInputs(id,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent))
        fragil.addEventListener('change', () => refreshInputs(id,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent))
        tratado.addEventListener('change', () => {refreshInputs(id,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent)})
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
        if(origen.value == 'EXT'){
          ul.childNodes[3].childNodes[4].addEventListener('change', () => {
            refreshInputs(id,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent)
          })
        }else{
          refCliente.addEventListener('click', () => {
              let texto = `Cliente: ${cliente.childNodes[0].textContent}`
              if(origen.value == 'MAT'){
                texto = $(`origen${id}`).parentNode.childNodes[6].innerText
                clearRowsMark(ul, texto)
              }else{
                clearRowsMark(ul, texto)
              }
          })
        }
        
        if(user.puesto == 'ADV' || tratado.value == ''){
          origen.addEventListener('change', (e) => {
            refreshInputs(id,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent)
            })
          origenLed.addEventListener('click', (e) => {
            const classLed = ['','ledOn','ledRed']
            let numClassLed = classLed.indexOf(e.target.classList[1] == undefined ? '' : e.target.classList[1])
            numClassLed = numClassLed == 2 ? 0 : numClassLed + 1
            if(user.puesto == 'ADV'){
              if(numClassLed != 0)
                e.target.classList.add(classLed[numClassLed])
                if(numClassLed == 2)
                  e.target.classList.remove(classLed[numClassLed - 1])
              if(numClassLed == 0)
                e.target.classList.remove(classLed[2])
              updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value,destino.textContent)
            }
          })
          destino.addEventListener('click', () => {
            if(user.puesto == 'ADV'){
              destino.classList.toggle('active-city-press')
              updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value,destino.textContent)
            }
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
                cliente: ${cliente.childNodes[0].textContent} (${cliente.childNodes[1].textContent})
                referencia: ${referencia.childNodes[0].textContent.replaceAll(' ','')}
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
          btnSendMail.addEventListener('click',() => enviarMail(pedido.value, origen.value, destino.textContent, referencia.firstChild.textContent.replaceAll(' ',''), `${cliente.firstChild.textContent} (${cliente.childNodes[1].textContent})`, fragil.checked, pvp, id, cantidad, nfm.checked, tratado.value, refCliente,comentario.firstChild.value, correo_proveedor))
          if(btnSendMailDisgon != null)
            btnSendMailDisgon.addEventListener('click',(e) => {
              if(e.target.innerHTML == '🚚')
                enviarMailDisgon(cantidad, origen.value, destino.textContent, referencia.firstChild.textContent.replaceAll(' ',''), id,comentario.firstChild.innerHTML)
              else if(e.target.innerHTML == '🏬' || e.target.innerHTML == '✅'){
                refCliente = refCliente.innerText
                const dataName = new FormData()
                dataName.append('origen', origen.value)
                dataName.append('destino', destino.textContent)
                dataName.append('destinoC', `${destino.textContent}C`)
                dataName.append('origenF', `${origen.value}F`)
                if(origen.value === 'EXT')
                  refCliente = $(`proveedorExterno${id}`).value
                fetch('../api/getBccMails.php',{
                  method: 'POST',
                  body: dataName
                })
                .then(response => response.json())
                .then(res => {
                  if(destino.textContent == 'MADRID'){
                    let enviar = confirm('¿Enviar correo al proveedor y a la placa de Madird?')
                    if(!enviar)
                      return
                    createMailProv(id,cantidad,refCliente,destino.textContent,referencia.firstChild.textContent.replaceAll(' ',''),cliente.firstChild.textContent,correo_proveedor,res['destino'],comentario.textContent,comentario.firstChild.textContent)
                    dataName.append('id', id)
                    dataName.append('nfm',nfm.checked)
                    dataName.append('fragil',fragil.checked)
                    dataName.append('pedido',pedido.value)
                    dataName.append('tratado',tratado.value)
                    dataName.append('envio', true)
                    dataName.append('disgon', false)
                    dataName.append('origenBtn', '1')
                    dataName.append('destinoBtn', '1')
                    dataName.append('origen', origen.value)
                    dataName.append('destino', destino.textContent)
                    dataName.append('destinoC', `${destino.textContent}C`)
                    dataName.append('origenF', `${origen.value}F`)
                    dataName.append('comentario', comentario.firstChild.value)
                    dataName.append('misterauto', '')
                    dataName.append('correo', correo_proveedor)
                    dataName.append('puesto', user.puesto)
                    dataName.append('proveedorExterno', refCliente)
                    fetch('../api/updateAssignADV2023.php', {
                      method: 'POST',
                      body:dataName
                    })
                    .then(itemupdate => {
                      $(`send${id}`).parentNode.parentNode.remove()
                      updateBubble('-')
                    })
                  }else{
                    createMailProv(id,cantidad,refCliente,destino.textContent,referencia.firstChild.textContent.replaceAll(' ',''),cliente.firstChild.textContent,correo_proveedor,res['destino'],comentario.textContent,comentario.firstChild.textContent)
                  }
                })
              }
              else if(e.target.innerHTML == '📦')
                window.open("https://recambios.logistica.com/page/index.aspx"),$(`disgon${id}`).innerHTML = "✅"
            })
          }

          btnPause.addEventListener('click', e => {
            let datosPaused = new FormData()
            datosPaused.append('id',id)
            fetch('../api/getPauseAssign.php',{
              method: 'POST',
              body: datosPaused
            }).then(assign => assign.json())
            .then(assingLine =>{
              if(assingLine.tratado != ''){
                customAlert("Esta cesión ya se está tratando y no se puede pausar")
                return
              }
              e.target.classList.toggle('pause')
              fetch('../api/pauseAssign.php',{
                method: 'POST',
                body: datosPaused
              })
            })
          })
          btnEliminar.addEventListener('click', () => eliminarLinea(id,referencia.firstChild.textContent.replaceAll(' ',''),tratado.value))
        }
    })
  })
}

const enviarMail = (pedido, origen, destino, referencia, cliente, fragil, pvp, id, cantidad, nfm, tratado, refCliente,comentario, correo_proveedor) =>{
  if($(`disgon${id}`).innerHTML == "🚚" || $(`disgon${id}`).innerHTML == "📦"){
    customAlert("Debes enviar primero el correo a Disgón o Logistica")
    return false
  }
  if($(`disgon${id}`).innerHTML == "🏬"){
    customAlert(`Debes enviar primero el correo a ${refCliente}`)
    return false
  }
  const dataName = new FormData()
  let disgon = 0
  if($(id).parentNode.childNodes[23].firstChild != null){
    if($(id).parentNode.childNodes[23].firstChild.checked){
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
  dataName.append('mailsOrigen', `${origen}ORIGEN`)
  dataName.append('comentario', comentario)
  dataName.append('misterauto', refCliente)
  dataName.append('correo', correo_proveedor)
  dataName.append('puesto', user.puesto)
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
            createMailMat(cantidad,refCliente.textContent,destino,referencia,cliente,pedido,nfm,fragil,res['fragil'])
          }else if(origen == 'EXT'){
            let mail_proveedor = $('mailExt') == null ? '' : $('mailExt').value
            createMailExt(cantidad,refCliente,destino,referencia,cliente,pedido,nfm,fragil,res['fragil'],res['conCopia'], correo_proveedor, comentario)
          }else{
            let destinoFragil = ''
            if(fragil){
              destinoFragil = res['fragil']
            }
            createMail(cantidad,origen,destino,referencia,cliente,pedido,nfm,fragil,destinoFragil,res['origen'],res['destino'],res['conCopia'],res['mailsOrigen'],disgon,comentario)
          }
          $(`send${id}`).parentNode.parentNode.remove()
          updateBubble('-')
        })
      })
    }
  })
}

const refreshInputs = (id,fragil,pedido,tratado,origen,destino) => {
  let cesion = null
  let chkSeguro = document.getElementById(id).parentNode.childNodes[23].childNodes[0]
  let seguro =  chkSeguro == undefined ? false : chkSeguro.checked
  let nfm = document.getElementById(id).parentNode.childNodes[19].childNodes[0].checked
  let code = $(id).parentNode.childNodes[3].childNodes[4]
  origen != destino ? cesion = origen + '' + destino : ''
  seguro = fragil ? seguro = seguro : false 
  seguro ? cesion += 'SEG' : ''
  nfm ? cesion += 'NM' : ''
  if(origen != 'MAT' && origen != 'EXT'){
    fetch('../json/cesionesCliente.json?108',
      {cache: "reload"}
    )
    .then(response => response.json())
    .then(response => {
      response[cesion] != undefined ? code.innerHTML = response[cesion] : code.innerHTML = ""
    })
  }else if(origen == 'MAT'){
    const session = getIdByCookie(document.cookie)
    const data = new FormData()
    data.append('id', id)
    data.append('session', session)
    fetch('../api/getAssignZzmat.php',{
      method: 'POST',
      body: data
    })
    .then(response => response.json())
    .then(response => {
      const refZZMAT = $(`destinoBtn${id}`).parentNode.childNodes[5]
      const ext = $(`destinoBtn${id}`).parentNode.childNodes[1].value
      if(ext != 'EXT' || ext != 'MAT')
        refZZMAT.innerHTML = `<span class="copy " style="grid-column: 1 / 4;font-size: medium;">${response.refClient}</span>`
    })
  }else{

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
  const disgon = $(id).parentNode.childNodes[23].firstChild == null ? false : $(id).parentNode.childNodes[23].firstChild.checked
  const ledStatus = [undefined,'ledOn','ledRed']
  const ledStatusDestino = $(id).parentNode.childNodes[1].firstChild.className.split(' ')[1]
  const origenBtn = ledStatus.indexOf(ledStatusDestino)
  const destinoBtn = $(`destinoBtn${id}`).className.includes('press') ? '1':'0'
  const origen = $(`origen${id}`).nodeName == 'SELECT' ? $(`origen${id}`).value : $(`origen${id}`).innerHTML
  const comentario = $(`coment${id}`).value
  const proveedorExterno = $(`proveedorExterno${id}`) == null ? '' : $(`proveedorExterno${id}`).value
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
  data.append('puesto', user.puesto)
  data.append('proveedorExterno', proveedorExterno)
  const disgonLi = $(`${id}`).parentNode.childNodes[23]
  const disgonSend = $(`disgon${id}`)
  if(fragil && disgonLi.firstChild == undefined) {
    const chkDisgon = document.createElement('input')
    chkDisgon.setAttribute('type', 'checkbox')
    chkDisgon.addEventListener('change', e => {
      updateChkbx(id,nfm,fragil,pedido,tratado, destino)
      refreshInputs(id,fragil,pedido,tratado,origen,destino,e.target)
    })
    disgonLi.appendChild(chkDisgon)
  }
  if(disgonSend != null && user.puesto == 'ADV' && fragil && origen != 'EXT'){
    if(disgonLi.childNodes[0].checked){
      disgonSend.innerText = '📦'
      if(origen == 'SANTIAGO')
        disgonSend.innerText = '🚚'
      if(origen == 'VALENCIA' || origen == 'MAT')
        disgonSend.innerText = ''
    }
    else if(!disgonLi.childNodes[0].checked)
      disgonSend.innerText = ''
  }
  if(!fragil && disgonLi.firstChild != null && origen != 'EXT'){
    disgonLi.firstChild.remove()
    disgonSend.innerHTML = ''
  }
  fetch('../api/updateAssignADV2023.php',{
    method: 'POST',
    body: data
  })
  .then(response => response.text())
  .then(item => showAssig())
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
  const correo_proveedor = $('mailExt') == null ? '' : $('mailExt').innerText
  let refMat = ''
  if(origen == 'MAT'){
    refMat = $('refMat').value
    if(refMat == 'ZZMAT' || refMat == ''){
      customAlert('Falta indicar la referencia de Mister-auto')
      $('refMat').style.backgroundColor = 'red';
      document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
      return false
    }
  }
  if(origen == 'EXT'){
    refMat = $('refMat').value.split('~')[0]
    if(refMat == 'Nombre de la placa'){
      customAlert('Falta indicar el nombre del proveedor')
      $('refMat').style.backgroundColor = 'red';
      document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
      return false
    }
    if(correo_proveedor == '' && destino == 'MADRID'){
      customAlert('Debes rellenar el correo del proveedor')
      document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
      $('mailExt').style.backgroundColor = 'red';
      $('mailExt').focus()
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
  /* ALerta de que no se pueden hacer cesiones a Sevilla  
  if(destino == 'SEVILLA'){
    customAlert("🚫No se pueden hacer cesiones a Sevilla esta semana.")
  }*/
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
  data.append('session',getIdByCookie(document.cookie))
  data.append('correo',correo_proveedor)
  $('disgonBox') == null ? null : disgonStatus = $('disgonBox').checked
  data.append('disgon', disgonStatus)
  fetch('../api/addAsignADV2023.php',{
    method: 'POST',
    body:data
  })
  .then(response => response.text())
  .then(res =>{
    /* NO SE PUEDEN HACER CESIONES EN GRANADA HASTA EL LUNES
    if(res == 'ErrorOrigen')
      customAlert("🚫No se pueden hacer cesiones en Granada hasta el lunes.")
      res = 'ok'*/
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

const btnAll = document.getElementById('all') ?? 0

if(btnAll){
  btnAll.addEventListener('click',()=>{
    document.location = `./cesionesAll.php`
  })
}

document.getElementById('new').addEventListener('click',()=>{
  document.location.reload()
})

document.getElementById('find').addEventListener('click',()=>{
  document.location = `./assigns/buscar.php`
})

document.getElementById('ready').addEventListener('click',()=>{
  document.location = `./assigns/ready.php`
})

document.getElementById('finish').addEventListener('click',()=>{
  document.location = `./assigns/finish.php`
})

document.getElementById('status').addEventListener('click',()=>{
  document.location = `./assigns/status.php`
})

document.getElementById('extBrand').addEventListener('click',()=>{
  document.location = `./assigns/extbrand.php`
})

/* Se colorea los fondos de los input cuando hay algo escrito */
$$('form')[0].addEventListener('keyup',(e)=>{
  if(!$$('form')[0].childNodes[1] == false && !$$('form')[0].childNodes[1].className != 'form-group'){
    for (var element = 0;element < $$('form')[0].length;element++){
      $$('form')[0][element].value != '' ? $$('form')[0][element].classList.add('fondo') : $$('form')[0][element].classList.remove('fondo')
    }
  }
})

$('openAssignPicture').addEventListener('click',()=>{
  modal(`<div style="text-align:center"><img src="./../img/placasExternas.png?1009" /></div>`,"Cesiones dsiponibles entre placas externas")
})