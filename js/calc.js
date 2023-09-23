$('cvkw').addEventListener("submit", e=>{
  e.preventDefault()
})

$('opr').addEventListener("submit", e=>{
  e.preventDefault()
})

$('date').addEventListener('change', e =>{
  const toDay = new Date()
  const pr0 = new Date('1976-11-08')
  const inputDate = Date.parse(e.target.value)
  $('nopr').value = (inputDate - pr0)/86400000
})

$('nopr').addEventListener('change', e =>{
  const toDay = new Date()
  let pr0 = new Date('1976-11-08')
  const inputDate = e.target.value
  pr0.setDate(pr0.getDate() + parseInt(inputDate))
  $('date').value = `${pr0.getFullYear()}-${("0" + (pr0.getMonth() + 1)).slice(-2)}-${("0" + pr0.getDate()).slice(-2)}`
})

$('cv').addEventListener('keyup', e =>{
  $('kw').value = Math.round(((e.target.value) * 1.36)*100)/100
})

$('kw').addEventListener('keyup', e =>{
  $('cv').value = Math.round(((e.target.value) / 1.36)*100)/100
})