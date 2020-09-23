import bs4
import time
import urllib
import os
import requests
import json
from urllib.request import urlopen as uReq
from bs4 import BeautifulSoup as soup
from datetime import datetime, date, time, timedelta
#Estudiar primer container
fecha_hoy=date.today()

# rut = 83628100
# # rut         = raw_input("Ingrese el rut de la empresa que quiere consultar: ")
# # mm          = raw_input("Ingrese el mes: ")
# # aa          = raw_input("Ingrese el año: ")
# # tipo_norma  = raw_input("Ingrese la norma: ")
# # payload     = json.dumps({"aa": aa, "forma":"P", "mm":mm, "tipo":"C", "tipo_norma":tipo_norma, "submit": "submit"})
# payload     = json.dumps({"aa": "2020", "forma":"P", "mm":"06", "tipo":"C", "tipo_norma":"IFRS", "submit": "submit"})
# url         = "https://www.cmfchile.cl/institucional/mercados/entidad.php?mercado=V&rut={}&grupo=&tipoentidad=RVEMI&row=&vig=VI&control=svs&pestania=3".format(rut)
# r           = requests.post(url, data=payload)
# html_soup   = soup(r.content, 'html.parser')
# print(html_soup)
url = "https://www.cmfchile.cl/institucional/mercados/entidad.php?mercado=V&rut=83628100&grupo=&tipoentidad=RVEMI&row=&vig=VI&control=svs&pestania=3"

payload = 'aa=2020&forma=P&mm=06&tipo=C&tipo_norma=IFRS'
headers = {
  'Upgrade-Insecure-Requests': '1',
  'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36',
  'Origin': 'https://www.cmfchile.cl',
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
  'Sec-Fetch-Site': 'same-origin',
  'Sec-Fetch-Mode': 'navigate',
  'Sec-Fetch-User': '?1',
  'Sec-Fetch-Dest': 'document'
}

response    = requests.request("POST", url, headers=headers, data = payload)
page_soup   = soup(response.content,"html.parser")
informes    = page_soup.find("div",{"id":"vis"}).div


filename="cw.csv"
f=open(filename,"w", encoding="utf-8")
contador = 0
for informe in informes:
    contador = contador + 1
    # objetivo: Setear los periodos en base a la primera fila de cabecera
    periodos          = informes.tbody.tr.findAll('th')
    # primera fila con los periodos
    headers = ""
    
    if contador == 1: 
        for p in periodos:
            headers = headers +"," + p.text.strip()
        headers = headers + " \n"
        # print(headers)
        # f.write(headers)
    headers = ""
tablas = page_soup.findAll('tbody')
# print(len(tablas))
contador = 0
for t in tablas:
    contador = contador + 1
    # if(contador>3):
    #     print(contador)
    #     break
    filas = t.findAll('tr')
    # print(len(filas))
    # break
    # print("Cantidad de filas: "+ str(len(filas)))
    for fila in filas:
        row = ""
        celdas = fila.findAll('td')
        # print(len(celdas))
    #     # break
        
        if len(celdas) < 25 and celdas is not None:
            for c in celdas:
                if c is not None:
                    texto = c.text.replace(',', ' ').strip()
                    row = row + "," + texto
            row = row +"\n"
            f.write(row)
f.close()
