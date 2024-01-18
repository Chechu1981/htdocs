if(typeof(src) === undefined){
  let src = ''
}

if(typeof(href) != "object"){
  const href = {
  "notas": "api/getNotesEdition.php",
  "mails": "helper/centerNames.php",
  "Centros":"api/getmailsEdition.php",
  "colores": "api/getColors.php",
  "rutas": "update/configRoutes.php",
  "soc": "update/configSoc.php",
  "tarifa": "update/updatePrice.php",
  "pending": "update/configPending.php",
  "clientes": "update/configClient.php",
  "repere": "update/configRepere.php"
  }

  const colores = {
    "azul": "blue",
    "rojo": "red",
    "verde": "green",
    "negro": "black"
  }

  const src = ruta[window.location.pathname.split('/').length]

  $('config').addEventListener('click', e => {
    if(e.target.id == "save"){
      const data = new FormData()
      data.append('center', $$('H2')[1].innerText)
      data.append('cc', $('cc').value)
      data.append('bcc', $('bcc').value)
      data.append('fcc', $('fcc').value)
      fetch(src + 'api/saveMails.php',{
        method: 'POST',
        body: data
      })
      .then(response => response.text())
      .then(res =>{
        window.location.reload()
      })
    }
    if(e.target.title != '' || href[e.target.title] != undefined){
      const data = new FormData()
      if(e.target.title == 'color'){
        data.append('color',$('menu').childNodes[1].childNodes[1].firstChild)
        data.append('userId',window.location.search.split('=')[1])
        fetch(src + 'api/setColor.php',{
          method:'POST',
          body: data
        })
        .then(cerd => cerd.text())
        .then(compl => window.location.reload())
      }else if(e.target.title == 'customColor'){
        $('color').addEventListener('input',(e) => {
          const color = hexToHSL(e.target.value)
          const colorH = Math.round(color.h * 360)
          const colorS = Math.round(color.s * 100)
          const colorL = Math.round(color.l * 100)
          document.documentElement.style.setProperty('--main-font-color',`hsl(${colorH},${colorS}%,${colorL}%)`)
          document.documentElement.style.setProperty('--second-bg-color',`hsl(${colorH},${colorS - 30}%,${colorL + 25}%)`)
          document.documentElement.style.setProperty('--search-line',`hsla(${colorH},${colorS - 14}%,${colorL + 35}%,1)`)
          document.documentElement.style.setProperty('--cards-border-color',`hsl(${colorH},${colorS + 20}%,${colorL + 50}%)`)
          document.documentElement.style.setProperty('--cards-active-color',`hsl(${colorH},${colorS + 23}%,${colorL + 27}%)`)
          document.documentElement.style.setProperty('--bg-body-color',`hsl(${colorH},${colorS - 57}%,${colorL + 67}%)`)
          document.documentElement.style.setProperty('--bg-font-color',`hsl(${colorH},${colorS + 1}%,${colorL - 22}%)`)
        })
        $('color').value = rgbToHex(window.getComputedStyle(document.body).color)
        $('changeColor').addEventListener('click', (e) =>{
          let colorHSL = hexToHSL($('color').value)
          let data = new FormData()
          data.append('userId',window.location.search.split('=')[1])
          data.append('h', colorHSL.h * 360)
          data.append('s', colorHSL.s * 100)
          data.append('l', colorHSL.l * 100)
          fetch('../api/updateColor.php',{
            method: 'POST',
            body: data
          })
          .then(e => e.text())
          .then(e => window.location.reload(true))
        })
      }else if(e.target.title == 'pending' || e.target.title == 'rutas' || e.target.title == 'repere' || e.target.title == 'soc' || e.target.title == 'clientes' || e.target.title == 'tarifa'){
        window.location.href = src + href[e.target.title] + window.location.search
      }else{
        data.append('title',e.target.innerHTML)
        fetch(src + href[e.target.title],{
          method: 'POST',
          body:data
        })
        .then(res=> res.text())
        .then(response=>{
          document.getElementsByClassName('note-body')[0].childNodes[1].innerHTML = response
        })
      }
    }
  })
}

function componentToHex(c) {
  let num = parseInt(c)
  let hex = num.toString(16);
  return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(rgb) {
  let color = rgb.replace('rgb(','')
  color = color.replace(')','')
  let r = color.split(',')[0]
  let g = color.split(',')[1]
  let b = color.split(',')[2]
  return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}

function hexToHSL(hex) {
  var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex)
    r = parseInt(result[1], 16)
    g = parseInt(result[2], 16)
    b = parseInt(result[3], 16)
    r /= 255, g /= 255, b /= 255
    var max = Math.max(r, g, b), min = Math.min(r, g, b)
    var h, s, l = (max + min) / 2
    if(max == min){
      h = s = 0; // achromatic
    }else{
      var d = max - min;
      s = l > 0.5 ? d / (2 - max - min) : d / (max + min)
      switch(max){
        case r: h = (g - b) / d + (g < b ? 6 : 0); break
        case g: h = (b - r) / d + 2; break
        case b: h = (r - g) / d + 4; break
      }
      h /= 6
    }
  var HSL = new Object()
  HSL['h']=h
  HSL['s']=s
  HSL['l']=l
  return HSL
}