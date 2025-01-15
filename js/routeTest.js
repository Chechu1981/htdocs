$$('input')[1].focus()

const findClient = (e,route) => {
  $('route-items').innerHTML = '<h1><span class="spinner"></h1>'
  let data = new FormData();
  data.append('search', e.target.value);
  fetch(`../api/${route}Test.php`,{
    method: 'POST',
    body: data
    })
  .then(response => response.text())
  .then(datos =>{
    $('route-items').innerHTML = `${datos}`
    loadEventClick()
  })
  .catch(err => console.log("error: "+err))
}

//Show Routes
$$('input')[1].addEventListener('keyup', (e) => {
  findClient(e,'getRoutes')
})

//Show client
let timeOut
$$('input')[2].addEventListener('keyup',e =>{
  window.clearTimeout(timeOut)
  timeOut = window.setTimeout(() => {
    findClient(e,'getClient')
  },600)
})

//Focus on the input
for(let input = 0;input < $$('input').length; input++) {
  $$('input')[input].addEventListener('focus', (e) => {
    e.target.select();
  })
}

$$('input')[1].addEventListener('focus', (e) =>{
  $('search-line-nclient').classList.add('search-focused');
});

$$('input')[1].addEventListener('blur', (e) =>{
  $('search-line-nclient').classList.remove('search-focused');
});
$$('input')[2].addEventListener('focus', (e) =>{
  $('search-line-client').classList.add('search-focused');
});

$$('input')[2].addEventListener('blur', (e) =>{
  $('search-line-client').classList.remove('search-focused');
});

const moveScreen = window.addEventListener('scroll', (e)=>{
  if(window.scrollY >= 100){
    $('contacts').classList.add('search-small')
    $('search-line-client').classList.add('search-line-small')
    $('search-line-nclient').classList.add('search-line-small')
  }else{
    $('contacts').classList.remove('search-small')
    $('search-line-client').classList.remove('search-line-small')
    $('search-line-nclient').classList.remove('search-line-small')
  }
})

const openDialog = id =>{
  const data = new FormData()
  data.append('id', id)
  fetch('../api/searchClientsById.php',{
    method: 'POST',
    body: data
  })
  .then(response => response.json())
  .then(res =>{
    res.map(client => {
      modal(`
      <ul class="infoClient">
        <li>Cuenta ICAR: <b class="copy">${client.code}</b></li>
        <li>CIF: <b class="copy">${client.cif}</b></li>
        <li>Dirección: <b>${client.direccion}</b></li>
        <li>Población: <b>${client.poblacion}</b></li>
        <li>Placa: <b>${client.placa}</b></li>
        <li>Provincia: <b>${client.provincia}</b></li>
        <li>CP: <b>${client.cp}</b></li>
        <li>Teléfono: <b class="copy">${client.telefono}</b></li>
        <li>E-mail: <b class="copy">${client.email.toLowerCase()}</b><b id="mail${client.id}" title="Enviar correo diréctamente" class="hover-action">📩</b></li>
        <li>Tipo: <b>${client.tipo}</b></li>
        <li>
          Comercial: <b>${client.comercial}</b>
          <b id="comercial${client.id}" title="Enviar presupuesto al comercial" class="hover-action">📩</b>
        </li>
      </ul>
      <iframe 
        src="https://www.google.com/maps?q=${encodeURIComponent(client.direccion)}+${encodeURIComponent(client.poblacion)}&output=embed&t=k"
        width="400" 
        height="300" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
      `,
      client.cliente)
      $(`comercial${client.id}`).addEventListener('click', ()=>{
        const contacto = new FormData()
        contacto.append('nombre',client.comercial)
        fetch('../api/getContact.php',{
          method: 'POST',
          body: contacto
        })
        .then(res => res.text())
        .then(response => {
          const conCopia = `ignacio.paris@stellantis.com`
          const saludo = Date().split(' ')[4].split(':')[0] < 14 ? `Buenos días: ` : `Buenas tardes:`
          const cuerpo = `Adjunto presupuesto no confirmado del cliente ${client.code} (${client.cliente}): `
          window.location.href = `mailto:${response}?subject=Presupuesto no confirmado&cc=${conCopia}&body=${saludo} %0A${cuerpo}%0A%0AUn saludo.`
        })
      })
      $(`mail${client.id}`).addEventListener('click', ()=>{
        const asunto = prompt('Asunto del correo: ')
        const saludo = Date().split(' ')[4].split(':')[0] < 14 ? `Buenos días: ` : `Buenas tardes:`
        window.location.href = `mailto:${client.email.toLowerCase()}?subject=${asunto}&body=${saludo} %0A%0A%0AUn saludo.`
      })
      const bes = document.getElementsByTagName('b')
      for(let i = 0; i < bes.length; i++) {
        bes[i].addEventListener('click',e =>{
          if(bes[i].className == 'copy'){
            var aux = document.createElement("input");
            aux.setAttribute("value", bes[i].innerText);
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);
            notify(`Copiado: ${bes[i].innerText}`)
          }
        })
      }
    })
  })
}

const loadEventClick = () =>{
  for(let i = 0; i < document.getElementsByTagName('li').length; i++){
    let element = document.getElementsByTagName('li')[i]
    element.addEventListener('click',e =>{
      if(element.title == 'Nombre: ')
        openDialog(element.id)
    })
  }
}