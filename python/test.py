# -*- coding: utf-8 -*-
import time
from datetime import datetime
from playwright.sync_api import sync_playwright
from bs4 import BeautifulSoup

def search_bridgestone(url,username,password,medida,cantidad):
    with sync_playwright() as playwright:
        datetoday = datetime.today().strftime("%d %m %Y")
        print("Buscando " + cantidad + " neumáticos Bridgestone de la medida " + medida)
        print("Abriendo el navegador...")
        browser = playwright.chromium.launch()
        page = browser.new_page()
        page.goto(url)
        print("Abriendo al url de Bridgestone: " + url)
        page.screenshot(path = 'screenshot1.png')
        button_selector = 'button' + ''.join([f'.{button_class}' for button_class in ['btn', 'btn-primary', 'btn-block']])
        page.click(button_selector)
        print("Esperando a que carge la página...")
        page.wait_for_load_state()
        time.sleep(1)
        page.screenshot(path = 'screenshot2.png')
        page.fill('input[id="logonIdentifier"]', username)
        page.fill('input[id="password"]', password)
        page.click('#next')
        page.wait_for_load_state()
        time.sleep(4)
        page.screenshot(path = 'screenshot3.png')
        print("consultando la medida...")
        page.goto("https://tyrelink2.bridgestone.eu/es/search?searchType=tyre&productType=tyre&text="+medida+"&frontSize=&rearSize=&deliveryDate="+datetoday+"&qty="+cantidad+"&brand=&warranty=on")
        page.screenshot(path = 'screenshot4.png')
        time.sleep(5)
        
        page.wait_for_selector('div[class*="product-list__search"]')
        print("pasa por wait_for_selector")
        product_list = page.content()
        print("Crea html list...")
        # Crear un objeto BeautifulSoup para analizar el contenido HTML
        soup = BeautifulSoup(product_list, 'html.parser')

        def filter_labels(element):
            return element.name == 'label' and 'hidden' not in element.get('class', [])

        # Encontrar el div con la clase "productlist__search"
        productlist_search_div = soup.find('div', class_='product-list__search')

        # Verificar si el objeto es None antes de llamar a find_all()
        if productlist_search_div is not None:

            # Encontrar los divs con la clase "product_list" dentro del div "productlist__search"
            product_list_divs = productlist_search_div.find_all('div', class_='px-16 lg:px-0 mb-16')

            # Recorrer los divs y obtener su contenido
            for div in product_list_divs:
                medida = div.find('a', class_='product__title').text.replace('  ','').replace('\n', '')
                referencia = div.find('li', class_='customer__ref').text.replace('  ','').replace('\n', '').replace('Referencia del cliente:','')
                disponibilidadArray = div.find('div',class_="product__availability-plp").find_all(filter_labels)
                disponibilidad = disponibilidadArray[0].text.replace('  ','').replace('\n','')
                print(medida + " => " + referencia + ": " + disponibilidad)
        else:
            print("No se encontró el elemento deseado.")
        page.close()
        
def search_continental(url,username,password,medida,cantidad):
    with sync_playwright() as playwright:
        datetoday = datetime.today().strftime("%d %m %Y")
        print("Buscando " + cantidad + " neumáticos Continental de la medida " + medida)
        print("Abriendo el navegador...")
        browser = playwright.chromium.launch()
        page = browser.new_page()
        page.goto(url)
        print("Abriendo al url de Continental: " + url)
        page.click('#cmpbntyestxt')
        page.screenshot(path = 'continental1.png')
        page.fill('#username',username)
        page.fill('#password',password)
        page.click('#login_btn')
        time.sleep(4)
        page.screenshot(path = 'continental2.png')
        page.close()

# Ejemplo de uso
bridgestone = 'https://tyrelink2.bridgestone.eu/es'
continental = 'https://www.contionlinecontact.com/'
print("Escribe la medida sin guinoes ni espacios: ")
medida = input()
print("¿Cuántas necesitas?")
cantidad = input()
search_bridgestone(bridgestone,"recambios-ppcr@mpsa.com","Bridgestone1",medida,cantidad)
#search_continental(continental,"R08143499","res99pla",medida,cantidad)
