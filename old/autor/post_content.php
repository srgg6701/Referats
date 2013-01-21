<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Загрузка содержания работы</title>
<link href="autor.css" rel="stylesheet" type="text/css">
</head>

<body><? require ("../../temp_transparency_author.php");?>
<div class="bottomPad6"><b>Отослать содержание работы и часть текста</b></div>
Тема работы:
<input type="text" name="textfield" style="width:100%"> 
Тип работы:
<select name="select">
  <option value="0">-Выберите-</option>
  <option value="1">Диплом</option>
  <option value="2">Курсовая</option>
  <option value="3">Реферат</option>
  <option value="4">Диссертация</option>
  <option value="5">Другое</option>
</select> 
Другое:
<input type="text" name="textfield"> 
Ваша цена: 
<input name="textfield" type="text" size="4">
руб<div class="bottomPad6">
  <p>    Содержание:
    <br>
      <textarea name="textfield" rows="20" style="width:100%;"></textarea>
    <input type="reset" name="Reset" value="Очистить">
    <input type="submit" name="Submit" value="Сохранить изменения">
</p>
  <p>Текст:      
      <textarea name="textarea" rows="26" style="width:100%;"></textarea>
    <input type="reset" name="Reset2" value="Очистить">
    <input type="submit" name="Submit3" value="Сохранить изменения">
  <hr size="1" noshade>
    <input type="submit" name="Submit2" value="Сохранить всё">
      </p>
</div>
</body>
</html>
