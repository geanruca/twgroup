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

url = "https://www.previred.com/web/previred/indicadores-previsionales"

response    = requests.request("GET", url)
page_soup   = soup(response.content,"html.parser")
valorUF     = page_soup.find_all('strong')

print(valorUF[1])


# filename="valorUF.csv"
# f=open(filename,"w", encoding="utf-8")
# contador = 0


# for informe in informes:
#     contador = contador + 1
#     # objetivo: Setear los periodos en base a la primera fila de cabecera
#     periodos          = informes.tbody.tr.findAll('th')
#     # primera fila con los periodos
#     headers = ""
    
#     if contador == 1: 
#         for p in periodos:
#             headers = headers +"," + p.text.strip()
#         headers = headers + " \n"
#         # print(headers)
#         # f.write(headers)
#     headers = ""
# tablas = page_soup.findAll('tbody')
# # print(len(tablas))
# contador = 0
# for t in tablas:
#     contador = contador + 1
#     # if(contador>3):
#     #     print(contador)
#     #     break
#     filas = t.findAll('tr')
#     # print(len(filas))
#     # break
#     # print("Cantidad de filas: "+ str(len(filas)))
#     for fila in filas:
#         row = ""
#         celdas = fila.findAll('td')
#         # print(len(celdas))
#     #     # break
        
#         if len(celdas) < 25 and celdas is not None:
#             for c in celdas:
#                 if c is not None:
#                     texto = c.text.replace(',', ' ').strip()
#                     row = row + "," + texto
#             row = row +"\n"
#             f.write(row)
# f.close()
