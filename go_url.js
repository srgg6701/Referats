// JavaScript Document
//Отправляет юзера на Diplom.com.ru, через форму поиска, если он ничего не нашёл на Referats.info
function sendOrder (wType,reqOrder) {
location.href='http://diplom.com.ru/order1.php?fromlocation=http://referats.info?q='+wType+' '+document.all[reqOrder].value;
}
function sendOrder2 (reqOrder) {
location.href='http://diplom.com.ru/order1.php?fromlocation=http://referats.info?q='+document.all[reqOrder].value;
}
//->