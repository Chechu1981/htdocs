

document.getElementById('testApi').addEventListener("click",()=>{
  console.log("Clicks clicked")
  let valor = document.getElementById('id').value
  fetch(`/ejecutar`)
  .then(e => {
    e.JSON()
  })
  .then(e => console.log(e))
})