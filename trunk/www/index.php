<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Конвертор FictionBook2 в PDF для Sony Reader</title>

<script type="text/javascript">
function toggleUploadMode(file) 
{
    if (file) 
    {
        document.getElementById('upfile').style.display='block';
        document.getElementById('upurl').style.display='none';
    } else 
    {
        document.getElementById('upfile').style.display='none';
        document.getElementById('upurl').style.display='block';
    }
 }
 
function doUpload()
{
    // hide form
    document.getElementById('form').style.display = 'none';
    // show progress indicator
    document.getElementById('progress').style.display = '';
    // submit form
    document.getElementById('uploadform').submit();
    // hack for IE: when form is submitted, IE stops to load and animate pictures 
    // so we'll ask IE to show picture again _AFTER_ form submission, with some delay (200ms)
    setTimeout('showProgress()', 200);
}

function showProgress()
{
    // refresh image source to start animation
    var o = document.getElementById('pimage');
    if (o)
        o.src = 'images/progress.gif';
}

function showForm()
{
    // hide progress indicator
    document.getElementById('progress').style.display = 'none';
    // show form
    document.getElementById('form').style.display = '';
}

</script>
</head>
<body>

<!-- div to display upload form -->
<div id="form">
    <h4 align="center">Этот сервис (альфа версия) предназначен для конвертации книг из формата <a href="http://ru.wikipedia.org/wiki/FictionBook">FictionBook2(FB2)</a> в формат <a href="http://en.wikipedia.org/wiki/Sony_Reader">Sony Reader</a>.</h4>
    <p>Пожалуйста загрузите книгу в FB2 или ZIP формате (ZIP может содержать только одну книгу в FB2 формате) или укажите URL.
    <br>Для удобства, Вы также можете (но не обязаны) указать адрес Вашей электронной почты, и мы пошлём вам письмо, как только книга будет готова. 
    <br><br><sub>Введённый Вами адрес электронной почты используется <u>только</u> для уведомления о готовности книги. 
    Мы гарантируем конфидициальность, и обязуемся <u>не использовать</u> указанный Вами адрес для рассылки рекламы.</sub>
    <p>

    <form id="uploadform" enctype="multipart/form-data" action="uploader.php" method="POST">
        <input type="radio" name="uploadtype" value="file" onclick="toggleUploadMode(true);" checked /> file
        <input type="radio" name="uploadtype" value="url" onclick="toggleUploadMode(false);" /> url

        <div id="upfile">
            <input type="file" name="fileupload" size="30" id="fileupload"/>
        </div>
 
        <div id="upurl" style="display: none">
            <input type="text" id="fileupload" value="наберите URL здесь" name="url" size="30"/>
        </div>
 
        <br>email (не обязательно):
        <br><input type="text" id="email" value="" name="email" size="30"/>
        
        <br><br><input type="button" onclick="doUpload()" value="Конвертировать" />
    </form>
    
    <h4 align="center">Новые книги</h4>
    <?php
    require_once 'awscfg.php';
    require_once 'db.php';
    require_once 'utils.php';

    global $dbServer, $dbName, $dbUser, $dbPassword;
    
    // list of new books
    $db = new DB($dbServer, $dbName, $dbUser, $dbPassword);
    $blist = $db->getBooks(10);
    if ($blist !== false)
    {
        foreach ($blist as $value) 
        {
            $author = $value["author"];
            $title  = $value["title"];
            $url    = get_page_url("status.php?id=" . $value["storage_key"]);
            echo "$author <a href=\"$url\">$title</a><br>";
        }            
    }
    else
    {
        error_log("FB2PDF ERROR. Unable to get list of books"); 
    }
    ?>
    
    <p>Обнаружили ошибку? У Вас есть предложения по улучшению сервиса? Хотите оставить комментарий?
    <br>Это можно сделать <a href="http://groups.google.com/group/fb2pdf-users/about?hl=ru">здесь</a>
</div>

<!-- div to display progress indicator -->
<div id="progress" style="display:none;text-align:center">
    <h4 align="center">Загрузка файла. Пожалуйста, подождите...</h4> 
    <img id="pimage" src="images/progress.gif"/>
</div>

<hr WIDTH="100%">
<a href="http://www.crocodile.org/"><img src="http://www.crocodile.org/noir.png"></a> 

</body>
 