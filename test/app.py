from flask import Flask, render_template, request
from flask_sslify import SSLify
from playwright.async_api import async_playwright
import asyncio, queue, time, threading, pathlib, json, os
from datetime import datetime

app = Flask(__name__)
sslify = SSLify(app)
entrada_cola = queue.Queue()
ruta = pathlib.Path(__file__).parent.resolve()
ruta = str(ruta).replace('C:','').replace('\\','/')
keys = open(ruta + '/config.json','r').read()
claves = json.loads(keys)
imagen = os.environ.get('USERPROFILE').replace('\\','/') + claves["routePictures"]
fecha = str(datetime.now().day) + '_' + str(datetime.now().month) + '_' + str(datetime.now().year)
carga = ""

@app.route('/')
def index():
  return render_template('index.html')

@app.route('/ejecutar', methods=['POST'])
def ejecutar():
  resultado = asyncio.run(run_playwright())
  return resultado

def leerEntrada(cola,referencia):    
  cola.put(referencia.upper())

async def abrirContextoParts(browser):
  context = await browser.new_context(
    http_credentials={"username": claves["usuarioParts"], "password": claves["passwordParts"]}
  )
  page = await context.new_page()
  await page.goto("https://parts.citroen.com/")
  try:
    await page.get_by_text('Español ').click()
  except:
    print("Usuario o contraseña incorretos")
  time.sleep(1)
  return page

async def run_playwright():
  pw = await async_playwright().start()
  browser = await pw.chromium.launch()
  data = request.get_json()
  print('Abriendo Parts...')
  hilo_referencia = threading.Thread(target=leerEntrada, args=(entrada_cola, data.get('referencia')))
  hilo_referencia.start()
  page = await abrirContextoParts(browser)
  referencia = entrada_cola.get()
  referencia = referencia.replace(' ','').replace('\t', '').replace('\n','')
  cadena = ''
  if referencia != '':
    await page.get_by_role("link", name="Referencia").hover()
    time.sleep(1)
    print("Buscando en P@rts: " + referencia)
    await page.get_by_role("link", name="Mostrar disponibilidad pieza").click()
    time.sleep(1)
    await page.fill('#focus',referencia)
    await page.click('#keyboard_ok')
    time.sleep(1)
    await page.screenshot(path = './test/img/' + fecha + '_Villaverde_'+referencia+'.png')
    parrafos = await page.locator("p").all()
    if(len(parrafos) == 1):
      cadena = "Parts: " + await parrafos[0].inner_text()
      cadena += '<a href="./test/img/' + fecha + '_Villaverde_'+referencia+'.png' + '"> Ver en Parts</a>'
    else:
      tabla = await page.locator('table').all()
      celdas = await page.locator('td').all()
      lugar = await celdas[32].inner_text()
      dispo = ""
      provision = await celdas[39].inner_text()
      if(provision.strip() != ''):
        provision = " - Provisión: " + provision + "€"
      pvp = await celdas[33].inner_text()
      descripcion = await celdas[7].inner_text()
      result = "PVP: " + pvp.strip() + "€ (" + descripcion.strip() + ")" + provision.strip()
      pedido = await tabla[6].locator('td').all()
      division = await pedido[1].inner_text()
      if(len(tabla) >= 7):
        fila = await tabla[8].locator('tr').all()
        for i in fila:
          mensaje = await i.inner_text()
          if mensaje != 'Mensajes':
            cadena += "<p> Parts: " + division + "-> " + await i.inner_text()
            cadena += '<a href="./test/img/' + fecha + '_Villaverde_'+referencia+'.png' + '"> Ver en Parts</a>'
      await page.get_by_text("Otro Articulo ").click()
      time.sleep(1)
      await page.fill('#focus',referencia)
      btnOptions = await page.locator('input[type=radio]').all()
      await btnOptions[1].click()
      await page.click('#keyboard_ok')
      time.sleep(1)
      btnOptions = await page.locator('input[type=radio]').all()
      await btnOptions[1].click()
      await page.get_by_text("Validar destinatario ").click()
      time.sleep(1)
      await page.screenshot(path = './test/img/' + fecha + '_Vesoul_'+referencia+'.png')
      tabla = await page.locator('table').all()
      pedido = await tabla[6].locator('td').all()
      division = await pedido[1].inner_text()
      celdas = await page.locator('td').all()
      lugar = await celdas[32].inner_text()
      if len(tabla) > 7:
        fila = await tabla[8].locator('tr').all()
        for i in fila:
          mensaje = await i.inner_text()
          if mensaje != 'Mensajes':
            cadena += "<p>Parts: " + division + "-> " + await i.inner_text()
            cadena += '<a href="./test/img/' + fecha + '_Vesoul_'+referencia+'.png' + '" > Ver en Parts</a>'
  return cadena

if __name__ == '__main__':
  app.run(debug=True, host='127.0.0.1', port=5000)