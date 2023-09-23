function customConfirm(cabecera,description,salida){
  const heading = document.createElement('h1')
  const btnTrue = document.createElement('button')
  const btnFalse = document.createElement('button')
  btnTrue.value = true
  btnFalse.value = false
  btnFalse.textContent = "Falso"
  btnTrue.textContent = "Veradero"
  notify.style.display = "flex"
  notify.appendChild(heading)
  notify.append(btnTrue)
  notify.append(btnFalse)
  notify.style.display = "none"
  notify.style.display = "block"
  heading.innerText = cabecera
  const text = description
  notify.append(text)
  
  btnTrue.addEventListener("click", () =>{
    notify.style.display = "none"
    salida.innerText = true
  })
  btnFalse.addEventListener("click", ()=>{
    notify.style.display = "none"
    salida.innerText = false
  })
}

document.getElementById('boton').addEventListener('click',(e)=>{
  e.target.disabled = true
  customConfirm("Cabezera","¿Es verdadero o falso?",salida)
})