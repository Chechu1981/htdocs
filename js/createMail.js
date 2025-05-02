export const createMail = (cantidad, origen, destino, referencia, cliente, pedido, nfm, fragil, destinoFragil, mailOrigen, mailDestino, bcc, disgon) => {
  let mailTarget, asuntoDisgon = '';
  let strDisgon = ``;
  let mailFragil = encodeURIComponent(``);
  let strNfm = 'La entrada en Geode debe ser realizada como entrada esperada 103 y no con el 109. ';
  let strCantidad = 'la referencia';
  if (cantidad > 1) {
    strCantidad = `${cantidad} unidades de la referencia`;
  }
  if (disgon) {
    asuntoDisgon = `DISGON`;
    strDisgon = `🚚🚩🚩ATENCIÓN RECOGE DISGON🚩🚩🚚`;
    if(origen != 'SANTIAGO'){
      strDisgon = `🚚🚩🚩ATENCIÓN RECOGE LOGISTICA🚩🚩🚚`;
      asuntoDisgon = `LOGISTICA`;
    }
    if(origen == 'VALENCIA'){
      strDisgon = ``;
      asuntoDisgon = ``;
    }
  }
  if (fragil) {
    mailFragil = encodeURIComponent(`
    *******__‼️ ATENCIÓN ‼️__*******
    ******************************
    **⚠️⚠️ MATERIAL FRÁGIL ⚠️⚠️**
    ******************************
    
    `);
  }
  if (nfm)
    strNfm = `La entrada en Geode debe ser realizada como entrada 109. PIEZA SIN SOLUCIÓN DE REEMPLAZO. `
  if (origen == 'SANTIAGO')
    origen = 'GALICIA';
  if (destino == 'SANTIAGO')
    destino = 'GALICIA';
  if(origen == 'VALENCIA' && destino == 'PALMA'){
    strNfm += `Por favor, dfs ¿podéis añadir esta referencia a la ruta dedicada? `
    mailDestino += ';dfs1@stellantis.com'
  }
  const fecha = new Date();
  const mailSub = `${asuntoDisgon} CESION ${origen} -> ${destino}`;
  const mailSaludo = fecha.getHours() > 14 ? `${strDisgon}${mailFragil}Buenas tardes: ` : `${strDisgon}${mailFragil}Buenos días: `;
  mailTarget = encodeURIComponent(`
Va a llegar de la placa de ${origen} a ${destino} ${strCantidad} ${referencia} para la cuenta ${cliente.replaceAll('&','and')}.
${strNfm}
Saludos.`);

  window.open(`mailto:${destinoFragil};${mailDestino};${mailOrigen}?subject=${mailSub}&cc=${bcc}&body=${mailSaludo + mailTarget}`);
}

const direcciones = {
  MADRID: 'Carretera de Seseña a Esquivias, Km 0,8 - 45224 Seseña Nuevo (Toledo)',
  VALENCIA: 'Carrer dels Bombers, 20 - 46980 PATERNA - VALENCIA',
  GALICIA: 'Vía Pasteur 41, CP:15898 Santiago de Compostela (A CORUÑA)',
  SANTIAGO: 'Vía Pasteur 41, CP:15898 Santiago de Compostela (A CORUÑA)',
  BARCELONA: 'Calle D, nº 41 - Polig. Ind. Zona Franca - 08040 BARCELONA',
  ZARAGOZA: 'C/ Río de Janeiro, 3 Polígono Industrial Centrovia 50198 - La Muela - ZARAGOZA',
  GRANADA: 'Polígono Industrial Huerta Ardila - Ctra. A-92 Km 6 - 18320 SANTA FE - GRANADA',
  SEVILLA: 'Parque Logístico de Carmona - MANZANA B, NAVE 1.Autovía A-4 Km. 521    41410 Carmona - Sevilla',
  PALMA:'Avda. 16 de Julio, 5 - 07009 SON CASTELLO- PALMA DE MALLORCA'
}

export const enviarMailDisgon = (cantidad,origen,destino,referencia,id) =>{
  $(`disgon${id}`).className = "wait"

  const hora = new Date().getHours()
  let saludo = `Buenos días:`
  if(hora > 14)
    saludo = `Buenas tardes:`

  const datos = new FormData()
  datos.append('search',referencia)
  fetch('../api/getRefer.php',{
    method: 'POST',
    body: datos
  })
  .then(item => item.json())
  .then(result => {
    $(`disgon${id}`).className = ""
    $(`disgon${id}`).innerHTML = "✅"
    if(origen == 'SANTIAGO')
      origen = 'GALICIA'
    if(destino == 'SANTIAGO')
      destino = 'GALICIA'
    const descRef = result.denominacion
    const dirOrigen = direcciones[origen]
    const dirDestino = direcciones[destino]
    const importe = Math.ceil(result.pvp * ((100 - result.dtoNum) / 100))
    const asunto = "RECOGIDA PPCR - DISGON"
    const mail = encodeURIComponent(`${saludo}
    Necesitamos recoger la referencia ${result.referencia.toUpperCase()} cantidad ${cantidad} ${descRef} en PPCR ${origen}
    ${dirOrigen}
    
    Para enviarlo a PPCR ${destino}
    ${dirDestino}
  
    ENVÍO ASEGURADO EN    ${importe}€
    
    
    Saludos.`)
    if(confirm(`¿Enviar Correo a Disgón?`)){
      window.open(`mailto:pedidos@disgon.com; incidencias@disgon.com; info@disgon.com; julio@disgon.com; carlosalberto.fernandez@stellantis.com?subject=${asunto}&body=${mail}`)
      $(`disgon${id}`).innerHTML = "✅"
    }
  })
}

export const createMailMat = (cantidad,misterauto,destino,referencia,cliente,pedido,nfm,fragil,destinatarios) => {
  const hora = new Date()
  const saludo = hora.getHours() > 14 ? `Buenas tardes:` : `Buenos días:`
  const numero = cantidad > 1 ? `${cantidad} unidades de la referencia` : `la referencia`
  const plate = new FormData()
  plate.append('placa', destino)
  fetch('../api/getCredentialMA.php',{
    method: 'POST',
    body: plate
  })
  .then(res => res.json())
  .then((credential) =>{
    const mensaje = `%0AEl cliente ${cliente.replaceAll('&','and')} ha autorizado a servir ${numero} ${referencia.toUpperCase()} con pedido a proveedor ${pedido} por alternativa ${misterauto.toUpperCase()} en Mister-Auto.

    %0APodéis descargar la factura desde el portal de M.A. https://www.mister-auto.es/

    %0AUsuario: ${credential[0]}
    %0AContraseña: ${credential[1]}

    %0APor favor, cuando podáis ¿podríais crear la referencia indicada?

    %0A%0AMuchas gracias.
  `

    window.location.href = `mailto:${destinatarios}?subject=Compra Mister-Auto ${destino}&body=${saludo}${mensaje}` //
  })
}

export const createMailExt = (cantidad,placaExterna,destino,referencia,cliente,pedido,nfm,fragil,destinatarios,bcc, correo_proveedor, comentario) => {
  const hora = new Date()
  const saludo = hora.getHours() > 14 ? `Buenas tardes:` : `Buenos días:`
  const numero = cantidad > 1 ? `${cantidad} unidades de la referencia` : `la referencia`
  let strNfm = 'La entrada en Geode debe ser realizada como entrada 109.'
  let placas = `desde la placa de ${placaExterna} a la`
  if (nfm)
    strNfm += ` PIEZA SIN SOLUCIÓN DE REEMPLAZO.`
  if (placaExterna.includes('OTRAS')){
    placas = 'desde proveedor externo en la'
    comentario != '' ? comentario = `Por favor, incluid en el pedido la referencia cliente "${comentario}"` : comentario = ''
  }else{
    comentario = ''
  }

  const mensaje = `%0ASe va a recibir ${numero} ${referencia.toUpperCase()} ${placas} placa de ${destino} para el cliente ${cliente.replaceAll('&','and')}.
  %0A${strNfm}
  %0A${comentario}
  %0A%0AMuchas gracias.
`
  window.location.href = `mailto:${destinatarios}?cc=${bcc}&subject=Compra externa - ${placaExterna}&body=${saludo}${mensaje}` 
}

export const createMailProv = (id,cantidad,placaExterna,destino,referencia,cliente,correo_proveedor,bcc,comentario) =>{
  $(`disgon${id}`).className = "wait"
  comentario == '' ? comentario = '' : comentario = `Referencia cliente: ${comentario}`
  const hora = new Date()
  const saludo = hora.getHours() > 14 ? `Buenas tardes:` : `Buenos días:`
  const numero = cantidad > 1 ? `${cantidad} unidades de la referencia` : `la referencia`
  const src = '../api/getDescRefer.php'
  const data = new FormData()
  if(destino == 'MADRID')
    bcc = "placamadridadministracion@stellantis.com;jacqueline.perez@stellantis.com;emilio.crespo@stellantis.com;juanantonio.palomo@external.stellantis.com"
  data.append('referencia',referencia)
  fetch(src,{
    method: 'POST',
    body: data
  })
  .then(items => items.json())
  .then(tarifa => {
    let pvp = `PVP:${tarifa.precio}€  DTO:${parseFloat(tarifa.descuento) - 3}%`
    if(placaExterna.includes('OTRAS'))
      pvp = ''
    let mensaje = `%0AProveedor: ${placaExterna}
%0ASolicito 
${numero}  ${referencia.toUpperCase()}   %0A${pvp} 
%0AEnvío a la placa de ${destino} [${direcciones[destino]}]
%0ACliente: ${cliente}
%0A ${comentario}
%0A⚠️Por favor enviadnos el albarán respondiendo a este correo⚠️`
    window.location.href = `mailto:${correo_proveedor}?cc=${bcc}&subject=Compra externa - PPCR ${destino}&body=${saludo}${mensaje}`
    if($(`disgon${id}`) != null){
      $(`disgon${id}`).classList.remove("wait")
      $(`disgon${id}`).innerHTML = "✅"
    }
  })
}

export const createMailBparts = (client) => {
  const hora = new Date()
  console.log(client)
  const destinatarios = "placamadridadministracion@stellantis.com;recambios-ppcr@stellantis.com;juanantonio.palomo@external.stellantis.com;ppcrmadrid@gecoinsa.es"
  const cc = ""
  const saludo = hora.getHours() > 14 ? `Buenas tardes:` : `Buenos días:`
  const asunto = `Pedido de B-Parts que llega a Seseña para el cliente ${client.code}`
  const mensaje = `%0AVa a llegar a Seseña este pedido de B-PArts para facturar y enviar al cliente ${client.code} (${client.cliente.replaceAll('&',' and ')}).
  %0A%0A%0A%0A
  Muchas gracias.
`
  window.location.href = `mailto:${destinatarios}?subject=${asunto}&body=${saludo}${mensaje}` //
}