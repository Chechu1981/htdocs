const marcas = {
    'Michelin': './tyres/michelin.php',
    'Pirelli': './tyres/pirelli.php',
    'Continental': './tyres/continental.php',
    'Firestone': './tyres/firestone.php',
    'Hankook': './tyres/hankook.php',
    'Dunlop': './tyres/dunlop.php',
    'tyres': './tyres/michelin.php'
}

let arr = Array.prototype.slice.call($('tyres-items').children[0].children[0].children)
let strlink = window.location.search.split('=')[1]
let src = marcas[strlink.substring(0,strlink.length -3)]
arr.map(item => {
    strlink == item.innerText ? item.classList.add('active') : null
})

fetch(src)
    .then((e) => e.text())
    .then((res) => {
        src != undefined ? $$('section')[2].innerHTML = res : null;
    })

$('tyres-items').addEventListener('click', e =>{
    src = marcas[e.target.innerText]
    arr.forEach(li => li.classList.remove('active'))
    e.target.classList.add('active')
    fetch(src)
    .then((e) => e.text())
    .then((res) => {
        src != undefined ? $$('section')[2].innerHTML = res : null;
    })
})