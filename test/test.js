

document.getElementById('testApi').addEventListener("click",()=>{
  console.log("Clicks clicked")
  let valor = document.getElementById('id').value
  fetch(`http://www.google.es/search?q=${valor}`,{
    metthod: 'GET',
    mode: 'no-cors'
  })
  .then(e => {
    e.text()
  })
  .then(e => console.log(e))
})