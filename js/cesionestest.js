const cesiones = (origen, destino,nfm) =>{
  $('newTitle').classList.add('copy')
  $('newTitle').innerText = `${origen}>${destino}`
  let cesion = null
  origen != destino ? cesion = origen + '' + destino:''
  nfm ? cesion += 'NM' :''
  /*fetch('../json/cesiones.json')
  .then(response => response.json())
  .then(response => {
    const numDest = response[cesion]
    numDest != undefined ? $('provider').innerText = response[cesion] : $('provider').innerText = ""
  })*/
  fetch('../json/cesionesCliente.json')
  .then(response => response.json())
  .then(response => {
    const numDest = response[cesion]
    numDest != undefined ? $('pclient').innerText = response[cesion] : $('pclient').innerText = ""
  })
}

$('nfm').addEventListener('change', (e) => {
  cesiones($('origen').value,$('destino').value,e.target.checked)
})

$('origen').addEventListener('change',()=>{
  $('newTitle').style.fontWeight = ''
  $('newTitle').classList.remove('copy')
  if($('origen').value != $('destino').value){
    cesiones($('origen').value,$('destino').value,$('nfm').checked)
  }else{
    $('provider').innerText = ""
    $('pclient').innerText = ""
    $('newTitle').innerText = "Nueva cesión"
  }
})

$('destino').addEventListener('change',()=>{
  $('newTitle').style.fontWeight = ''
  $('newTitle').classList.remove('copy')
  if($('origen').value != $('destino').value){
    cesiones($('origen').value,$('destino').value,$('nfm').checked)
  }else{
    $('provider').innerText = ""
    $('pclient').innerText = ""
    $('newTitle').innerText = "Nueva cesión"
  }
})

const showAssig = () =>{
  const data = new FormData()
  data.append('id','new')
  data.append('session',window.location.href.split('=')[1])
  fetch('../api/getAssigADV2023.php',{
    method: 'POST',
    body: data
  })
  .then(response => response.text())
  .then(response => {
    $('cesiones').innerHTML = response
    $('sendMail').addEventListener('click', (send) =>{
      let arrayMails = []
      for(let i = 1; i < $('cesiones').childNodes.length; i++){
        if($('cesiones').childNodes[i].localName == 'ul' && $('cesiones').childNodes[i].classList.value != "heading"){
          const id = $(`cesiones`).childNodes[i].childNodes[21].id
          const origen = $('cesiones').childNodes[i].childNodes[1].childNodes[1].textContent
          const destino = $('cesiones').childNodes[i].childNodes[1].childNodes[3].textContent
          const cliente = $('cesiones').childNodes[i].childNodes[5].textContent
          const refCliente = $('cesiones').childNodes[i].childNodes[7].textContent
          const comentario = $('cesiones').childNodes[i].childNodes[9].textContent
          const referencia = $('cesiones').childNodes[i].childNodes[11].textContent
          const cantidad = $('cesiones').childNodes[i].childNodes[13].textContent
          const pedido = $('cesiones').childNodes[i].childNodes[17].firstChild.value
          const fragil = $('cesiones').childNodes[i].childNodes[19].firstChild.checked
          if(pedido == ''){
            customAlert('Faltan campos de pedido por completar')
            return false
          }
          
          const inout = new FormData()
          inout.append('origen', origen)
          inout.append('destino', destino)
          inout.append('destinoC', destino+'C')
          inout.append('origenF', origen+'F')
          fetch('../api/getBccMails.php',{
            method: 'POST',
            body: inout
          })
          .then(mailJson => mailJson.json())
          .then((mail) => {
            let destinoFragil = ''
            if(fragil){
              destinoFragil = mail['fragil']
            }
            arrayMails.push([cantidad,origen,destino,referencia,cliente,pedido,fragil,destinoFragil,mail["origen"],mail["destino"],mail['conCopia']])
          })
          const dataUpdate = new FormData()
          dataUpdate.append('id', id)
          dataUpdate.append('value', fragil)
          dataUpdate.append('pedido', pedido)
          dataUpdate.append('pvp',$(`cesiones`).childNodes[i].childNodes[15].firstChild.value)
          dataUpdate.append('envio', true)
          /*fetch('../api/updateAssignADV.php',{
            method: 'POST',
            body: dataUpdate
          })
          .then(updres => updres.text())
          .then(update => update)*/
        }
      }
      console.log(arrayMails)
    })
    for(let i = 1; i < $('cesiones').childNodes.length; i++){
      if($('cesiones').childNodes[i].localName == 'ul'){
        const origen = $('cesiones').childNodes[i].childNodes[1].childNodes[1].innerHTML
        const destino = $('cesiones').childNodes[i].childNodes[1].childNodes[3].innerHTML
        let nfm = $(`cesiones`).childNodes[i].childNodes[17].firstChild.checked
        $(`cesiones`).childNodes[i].childNodes[17].firstChild.addEventListener('change', (e) => {
          let cesion = null
          let code = e.target.parentNode.parentNode.childNodes[1].childNodes[5]
          origen != destino ? cesion = origen + '' + destino:''
          nfm ? cesion += "NM" : ''
          e.target.checked ? cesion += 'NM' :''
          /*fetch('../json/cesiones.json')
          .then(response => response.json())
          .then(response => {
            const numDest = response[cesion]
            numDest != undefined ? $('provider').innerText = response[cesion] : $('provider').innerText = ""
          })*/
          fetch('../json/cesionesCliente.json')
          .then(response => response.json())
          .then(response => {
            const numDest = response[cesion]
            numDest != undefined ? code.innerText = response[cesion] : code.innerText = ""
          })
          updateChkbx()
        })
        $(`cesiones`).childNodes[i].childNodes[19].firstChild.addEventListener('change', () => {
          updateChkbx()
        })
        $(`cesiones`).childNodes[i].childNodes[15].firstChild.addEventListener('keyup', () => {
          updateChkbx()
        })

        const updateChkbx = () => {
          const data = new FormData()
          data.append('id', $(`cesiones`).childNodes[i].childNodes[21].id)
          data.append('nfm',$(`cesiones`).childNodes[i].childNodes[17].firstChild.checked)
          data.append('fragil',$(`cesiones`).childNodes[i].childNodes[19].firstChild.checked)
          data.append('pedido',$(`cesiones`).childNodes[i].childNodes[15].firstChild.value)
          data.append('envio', false)
          fetch('../api/updateAssignADV2023.php',{
            method: 'POST',
            body: data
          })
        }
        
        $(`cesiones`).childNodes[i].childNodes[23].addEventListener('click', ()=>{
          const nfm = $(`cesiones`).childNodes[i].childNodes[17].firstChild.checked
          const cantidad =  $(`cesiones`).childNodes[i].childNodes[13].firstChild.data
          const pedido =  $(`cesiones`).childNodes[i].childNodes[15].firstChild.value
          const origen = $(`cesiones`).childNodes[i].childNodes[1].childNodes[1].firstChild.data
          const destino = $(`cesiones`).childNodes[i].childNodes[3].firstChild.data
          const referencia = $(`cesiones`).childNodes[i].childNodes[11].firstChild.data
          const cliente = $(`cesiones`).childNodes[i].childNodes[5].firstChild.data
          const fragil = $(`cesiones`).childNodes[i].childNodes[19].firstChild.checked
          const inout = new FormData()
          inout.append('origen', origen)
          inout.append('destino', destino)
          inout.append('destinoC', destino+'C')
          inout.append('origenF', origen+'F')
          if(confirm(`¿Enviar Correo?`)){
            const data = new FormData
            data.append('id',$(`cesiones`).childNodes[i].childNodes[21].id)
            data.append('fragil',fragil)
            data.append('pedido',pedido)
            data.append('nfm',nfm)
            data.append('envio', true)
            data.append('pvp','')
            fetch('../api/updateAssignADV2023.php', {
              method: 'POST',
              body:data
            })
            .then((item) => item.text())
            .then((item) => {
              fetch('../api/getBccMails.php',{
                method: 'POST',
                body: inout
              })
              .then(response => response.json())
              .then(res => {
                console.log(res)
                let destinoFragil = ''
                if($('frag').checked){
                  destinoFragil = res['fragil']
                }
                createMail(cantidad,origen,destino,referencia,cliente,pedido,nfm,fragil,destinoFragil,res['origen'],res['destino'],res['conCopia'])
                $(`cesiones`).childNodes[i].style.display = 'none'
              })
            })
          }
        })
      }
    }
    for(let i = 1; i < $('cesiones').childNodes.length; i++){
      if($('cesiones').childNodes[i].localName == 'ul'){
        $('cesiones').childNodes[i].childNodes[1].addEventListener('click', (copy) =>{
          const copiar = `${$('cesiones').childNodes[i].childNodes[1].childNodes[1].textContent}>${$('cesiones').childNodes[i].childNodes[1].childNodes[3].textContent}`
          var aux = document.createElement("input");
          aux.setAttribute("value", copiar);
          document.body.appendChild(aux);
          aux.select();
          document.execCommand("copy");
          document.body.removeChild(aux);
          notify(`${copiar} copiado!`)
        })
        $('cesiones').childNodes[i].childNodes[5].addEventListener('click', (copy) =>{
          const copiar = `Cliente: ${$('cesiones').childNodes[i].childNodes[5].textContent}`
          var aux = document.createElement("input");
          aux.setAttribute("value", copiar);
          document.body.appendChild(aux);
          aux.select();
          document.execCommand("copy");
          document.body.removeChild(aux);
          notify(`${copiar} copiado!`)
        })
        $('cesiones').childNodes[i].childNodes[7].addEventListener('click', (copy) =>{
          const copiar = `${copy.target.childNodes[0].data}`
          var aux = document.createElement("input");
          aux.setAttribute("value", copiar);
          document.body.appendChild(aux);
          aux.select();
          document.execCommand("copy");
          document.body.removeChild(aux);
          notify(`${copiar} copiado!`)
        })
        $('cesiones').childNodes[i].childNodes[9].addEventListener('click', (copy) =>{
          const copiar = `${copy.target.childNodes[0].data}`
          var aux = document.createElement("input");
          aux.setAttribute("value", copiar);
          document.body.appendChild(aux);
          aux.select();
          document.execCommand("copy");
          document.body.removeChild(aux);
          notify(`${copiar} copiado!`)
        })
        $('cesiones').childNodes[i].childNodes[11].addEventListener('click', (copy) =>{
          const copiar = `${copy.target.childNodes[0].data}`
          var aux = document.createElement("input");
          aux.setAttribute("value", copiar);
          document.body.appendChild(aux);
          aux.select();
          document.execCommand("copy");
          document.body.removeChild(aux);
          notify(`${copiar} copiado!`)
        })
      }
    }
  })
}

const createMail = (cantidad,origen,destino,referencia,cliente,pedido,nfm,fragil,destinoFragil,mailOrigen,mailDestino,bcc) =>{
  let mailFragil = ''
  let mailTarget = ''
  let strCantidad = 'la referencia'
  
  if(cantidad > 1){
    strCantidad = `${cantidad} referencias de la `
  }
  
  if(fragil){
    mailFragil = encodeURIComponent(`
    ****‼️ ATENCIÓN ‼️****
    ******************************
    **⚠️⚠️ MATERIAL FRÁGIL ⚠️⚠️**
    ******************************
    
    `)
  }

  const fecha = new Date()
  const mailSub = `CESION ${origen} -> ${destino}`
  const mailSaludo = fecha.getHours() > 14 ? "Buenas tardes: %0A" : "Buenos días: %0A"
  const mailBody = encodeURI(`Va a llegar de la placa de ${origen} a ${destino} ${strCantidad} ${referencia} para la cuenta ${cliente}. 
  La entrada en Geode debe ser realizada como entrada esperada 103 y no con el 109. 
    Saludos.`)
  const mailBodyNfm = encodeURI(`Va a llegar de la placa de ${origen} a ${destino} la referencia ${referencia} para la cuenta ${cliente}.
  La entrada en Geode debe ser realizada como entrada 109. PIEZA SIN SOLUCIÓN DE REEMPLAZO.   
  Saludos.`)
  !nfm ? mailTarget = mailBody : mailTarget = mailBodyNfm
  const data = new FormData();
  data.append('mailDestino',mailDestino)
  data.append('mailFragil',mailFragil)
  data.append('mailSaludo',mailSaludo)
  data.append('pedido',pedido)
  data.append('destinoFragil',destinoFragil)
  data.append('mailOrigen',mailOrigen)
  data.append('mailSub',mailSub)
  data.append('cc',bcc)
  data.append('mailTarget',mailTarget)
  /*fetch('../api/createPythonFile.php',{
    method: 'POST',
    body: data
  })
  .then((response) => response.text())
  .then(res => {
    window.open(`../api/${res}.bat`)
  })*/
  window.open(`mailto:${destinoFragil};${mailDestino};${mailOrigen}?subject=${mailSub}&cc=${bcc}&body=${mailFragil}${mailSaludo + mailTarget}`)
  //window.location = `mailto:${destinoFragil};${mailDestino};${mailOrigen}?subject=${mailSub}&cc=${bcc}&body=${mailFragil}${mailSaludo + mailTarget}`
  
}

document.addEventListener('click', (e) => {
  if(e.target.alt === 'eliminar' && confirm(`Eliminar cesión (${e.target.parentNode.parentNode.childNodes[11].innerText}) de ${e.target.parentNode.parentNode.childNodes[1].innerText} -> ${e.target.parentNode.parentNode.childNodes[3].innerText}`)){
    const data = new FormData()
    data.append('id',e.target.parentNode.id)
    fetch('../api/deleteAssignADV.php', {
      method: 'POST',
      body: data
    })
    .then(e=>e.text())
    .then(item => {
      showAssig()
    })
  }
})

const updateAssig = (id,values) => {
  console.log(id + ': ' + values)
}

$$('form')[0].addEventListener('submit',(e)=>{
  e.preventDefault()
  const origen = $('origen').value
  const destino = $('destino').value
  const cliente = $('client').value
  const pedido = $('pedido').value
  const ref = $('ref').value
  const cantidad = $('units').value
  const nfm = $('nfm').checked
  if(origen === destino){
    customAlert('El destino y el origen debe ser diferente')
    return false
  }
  if(cliente === ''){
    customAlert('Debes rellenar el cliente')
    return false
  }
  else if(ref === ''){
    customAlert('Debes rellenar la referencia')
    return false
  }
  else if(cantidad === ''){
    customAlert('Debes rellenar la cantidad')
    return false
  }
  const data = new FormData()
  data.append('origen',origen)
  data.append('destino',destino)
  data.append('cliente',cliente)
  data.append('refClient','')
  data.append('comentario',$('coment').value)
  data.append('ref',ref)
  data.append('cantidad',cantidad)
  data.append('pvp','')
  data.append('pedido',pedido)
  data.append('nfm',nfm)
  data.append('frag',$('frag').checked)
  data.append('session',window.location.href.split('=')[1])
  fetch('../api/addAsignADV2023.php',{
    method: 'POST',
    body:data
  })
  .then(response => response.text())
  .then(res =>{
    if(res == 'ok'){
      showAssig()
      $('newTitle').innerHTML = "Nueva cesión"
      $('pclient').innerHTML = ""
      e.target.reset()
    }
  })
})

showAssig()

const botones = {
  nueva:$('contacts').childNodes[3].childNodes[1].childNodes[1],
  buscar:$('contacts').childNodes[3].childNodes[1].childNodes[3],
  recibidas:$('contacts').childNodes[3].childNodes[1].childNodes[7],
  pendientes:$('contacts').childNodes[3].childNodes[1].childNodes[5],
  estadistica:$('contacts').childNodes[3].childNodes[1].childNodes[9]
}

const clearSelect = () => {
  if($('contacts').childNodes[5] != undefined)
    $('contacts').childNodes[5].remove()
}

botones.nueva.addEventListener('click',()=>{
  window.location.reload()
})

botones.buscar.addEventListener('click',() => {
  clearSelect()
  $('newTitle').innerHTML = "Buscar cesiones"
  const boton = `
  <div id="search-line" class="nPass search-line search-focused">
    <span class="lupa">
      <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
      </svg>
    </span>
    <div class="textbox" id="search-box">
      <input type="text" id="search-assig" placeholder="Buscar cesión...">
    </div>
  </div>`
  $('contacts-items').childNodes[1].classList.add('change')
  setTimeout(function(){
    $('contacts-items').childNodes[1].classList.remove('change')
    $('contacts-items').childNodes[1].innerHTML = boton
    $('search-assig').focus()
    $('search-assig').addEventListener('keyup',(e)=>{
      const data = new FormData()
      data.append('id',e.target.value)
      data.append('session',window.location.href.split('=')[1])
      fetch('../api/getAssig.php',{
        method: 'POST',
        body: data
      })
      .then((e) => e.text())
      .then((res) => {      
        $('cesiones').innerHTML = res
      })
    },500)  
  })
})

$('client').addEventListener('blur',(e)=>{
  const data = new FormData()
  data.append('search',$('client').value != '' ? $('client').value : null)
  fetch('../api/getClientName.php',{method: 'POST', body:data})
  .then(respose => respose.text())
  .then((res) => $('clientName').innerHTML = res)
})

botones.recibidas.addEventListener('click', () =>{
  clearSelect()
  $('newTitle').innerHTML = "Cesiones recibidas"
  $('contacts-items').childNodes[1].innerHTML = ''
  const data = new FormData()
  data.append('id','all')
  data.append('session',window.location.href.split('=')[1])
  fetch('../api/getAssig.php',{
    method: 'POST',
    body: data
  })
  .then((e) => e.text())
  .then((res) => $('cesiones').innerHTML = res)
})

botones.pendientes.addEventListener('click', () =>{
  clearSelect()
  assignOnTrak()
})

const assignOnTrak = () =>{
  $('newTitle').innerHTML = "Cesiones pendientes de recibir"
  $('contacts-items').childNodes[1].innerHTML = ''
  const data = new FormData()
  data.append('id','new')
  data.append('session',window.location.href.split('=')[1])
  fetch('../api/getAssig.php',{
    method: 'POST',
    body:data
  })
  .then((e) => e.text())
  .then((res) => {
    $('cesiones').innerHTML = res
  })
}

botones.estadistica.addEventListener('click', (e) =>{
  if(document.getElementsByTagName('select').length > 0 && $('newTitle').innerHTML == 'Estadísticas')
    return false
  $('newTitle').innerHTML = "Estadísticas"
  $('contacts-items').childNodes[1].innerHTML = ''
  const divContainer = document.createElement('div')
  divContainer.style.margin = "auto"
  divContainer.style.height = `calc(70vh - (${$('menu').offsetHeight}px + ${$('contacts').offsetHeight}px))`
  divContainer.style.maxWidth = "700px"
  $('cesiones').innerHTML = ''
  const chart = document.createElement('script')
  chart.src = "https://cdn.jsdelivr.net/npm/chart.js"
  document.head.appendChild(chart)
  const canvas = document.createElement('canvas')
  canvas.id = "myChart"
  divContainer.appendChild(canvas)
  $('cesiones').appendChild(divContainer)
  fetch('../api/getAssigStatus.php',{
    method: 'POST'
  })
  .then((e) => e.json())
  .then((res) => {

    const input = document.createElement('select')
    input.style = "width: 150px;border: 2px solid var(--main-font-color);border-radius: 8px;font-size: 2em; text-transform: uppercase;"
    input.addEventListener("change",(e)=>{
      if(window.graph){
        window.graph.clear()
        window.graph.destroy()
      }
      const data = {
        datasets: []
      }
      if(res[e.target.value][1].length > 0){
        let sum = res[e.target.value][1].slice(-20).reduce((previous, current) => parseInt(current) + parseInt(previous));
        avg = Math.round((sum / res[e.target.value][1].slice(-20).length) * 100)/100;
      }

      data.labels = res[e.target.value][2]
      data.datasets.push({
        label: "Media: " + avg,
        data: res[e.target.value][1],
        backgroundColor: colorArray,
        stack: 'Stack 0',
      })
      window.graph = new Chart("myChart", {
        type: 'bar',
        data: data,
        options: {
          plugins: {
            title: {
              display: true,
              text: 'Cesiones diarias por usuario'
            },
          },
          responsive: true,
          interaction: {
            intersect: false,
          },
          scales: {
            x: {
              stacked: true,
            },
            y: {
              stacked: true
            }
          }
        }
      })
    })
    var colorArray = ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', 
		  '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
		  '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A', 
		  '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
		  '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC', 
		  '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
		  '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680', 
		  '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
		  '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3', 
		  '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'];

    const data = {
      datasets: []
    }
    
    let usuario = 0
    for(let i = 0; i < res.length; i++) {
      let name = res[i][0]
      let option = document.createElement('option')
      option.innerHTML = name
      option.setAttribute('value',i)
      input.appendChild(option)
      if(name.toUpperCase() == $('menu').childNodes[1].childNodes[1].innerText.toUpperCase()){
        usuario = i
        option.setAttribute('selected',true)
      }
    }
    $('contacts').appendChild(input)

    
    let sum = res[usuario][1].slice(-20).reduce((previous, current) => parseInt(current) + parseInt(previous));
    let avg = Math.round((sum / res[usuario][1].slice(-20).length) * 100)/100;
    data.labels = res[usuario][2]
    data.datasets.push({
      label: "Media: " + avg,
      data: res[usuario][1],
      backgroundColor: colorArray,
      stack: 'Stack 0',
    })

    window.graph = new Chart("myChart", {
      type: 'bar',
      data: data,
      options: {
        plugins: {
          title: {
            display: true,
            text: 'Cesiones diarias por usuario'
          },
        },
        responsive: true,
        interaction: {
          intersect: false,
        },
        scales: {
          x: {
            stacked: true,
          },
          y: {
            stacked: true
          }
        }
      }
    })
  })
})

document.addEventListener('keyup',(e)=>{
  if(!$$('form')[0].childNodes[1] == false && !$$('form')[0].childNodes[1].className != 'form-group'){
    for (var element = 0;element < $$('form')[0].length;element++){
      $$('form')[0][element].value != '' ? $$('form')[0][element].classList.add('fondo') : $$('form')[0][element].classList.remove('fondo')
    }
  }
})

$('newTitle').addEventListener('click', e =>{
  if($('newTitle').innerText == 'Nueva cesión')
    return false
  let seleccion = document.createRange();
  seleccion.selectNodeContents($('newTitle'))
  window.getSelection().removeAllRanges()
  window.getSelection().addRange(seleccion)
  var res = document.execCommand('copy')
  window.getSelection().removeRange(seleccion)
  $('newTitle').style.fontWeight = 600
  notify(`${seleccion} copiado!`)
})

/* SmtpJS.com - v3.0.0 */
var Email = { 
  send: function (a) { 
    return new Promise(function (n, e) { 
      a.nocache = Math.floor(1e6 * Math.random() + 1), 
      a.Action = "Send"; 
      var t = JSON.stringify(a); 
      Email.ajaxPost("https://smtpjs.com/v3/smtpjs.aspx?", t, function (e) { n(e) }) 
    }) 
  }, 
  ajaxPost: function (e, n, t) { 
    var a = Email.createCORSRequest("POST", e); 
    a.setRequestHeader("Content-type", "application/x-www-form-urlencoded"), 
    a.onload = function () { 
      var e = a.responseText; 
      null != t && t(e) 
    }, 
    a.send(n) 
  }, 
  ajax: function (e, n) { 
    var t = Email.createCORSRequest("GET", e); 
    t.onload = function () { 
      var e = t.responseText; 
      null != n && n(e) 
    }, 
    t.send() 
  }, 
  createCORSRequest: function (e, n) { 
    var t = new XMLHttpRequest; 
     return "withCredentials" in t ? t.open(e, n, !0) : "undefined" != typeof XDomainRequest ? (t = new XDomainRequest).open(e, n) : t = null, t 
    } 
  };