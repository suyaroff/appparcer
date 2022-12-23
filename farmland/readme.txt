Базовая ссылка на api
https://api.farmlend.ru/v2

Каждый запрос должен содержать в Headers параметры 
hash: acddc545e5ca7ab351e307657d71ee09
timestamp: 1671809499
app-version: 198


Вычесляем хеш, 
$hash = md5(префикс + полная ссылка + время в секудах unixtime);
Например 
$hash = md5(7e8480b9523030d0a7d9679d90e50d2ehttps://api.farmlend.ru/v2/filter?location=218&token=&categoryLevel=2&categoryId=171671809499);