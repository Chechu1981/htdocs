document.getElementsByTagName("form")[0].addEventListener("submit",e =>{
  e.preventDefault()
  const result = document.getElementById('resp')
  const medida = document.getElementById('medida')
  const qy = document.getElementById('qy')
  result.innerHTML = `Cargando...`
  fetch("../python/test.py")
  .then((item) => item.text())
  .then((res) => result.innerHTML = res)
})