

document.getElementById('testApi').addEventListener("click",()=>{
  let valor = document.getElementById('id').value
  let result = document.getElementById('result')
  result.innerHTML = `Buscando la referencia ${valor} en PowerSupply...`
  fetch(`https://ppcr.es:3001/ejecutar`,{
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      referencia: valor
    })
  })
  .then(response => response.text())
  .then(data => {
    result.innerHTML = data
  })
})