<?php
ini_set('display_errors',1);
$str =  "Введите область проживания
* Винницкая область
* Волынская область
* Днепропетровская область
* Донецкая область
* Житомирская область
* Закарпатская область
* Запорожская область
* Ивано- Франковская область
* Киевская область
* Кировоградская область
* Крым
* Луганская область
* Львовская область
* Николаевская область
* Одесская область
* Полтавская область
* Ровенская область
* Сумская область
* Тернопольская область
* Харьковская область
* Херсонская область
* Хмельницкая область
* Черкасская область
* Черниговская область
* Черновицкая область";
$region = explode("*", $str);
function filterInput($var){
    return htmlspecialchars(strip_tags(stripslashes(trim($var))));
}
function validateString($var) {
    if (empty($var) || strlen($var) < 2 || strlen($var) > 32) {
        return true;
    }
    return false;
}
function validateDate($var) {
    $todey = date('Y-m-d');
    $old = '1900-01-01';
    if (empty($var) || $var < $old || $var > $todey) {
        return true;
        }
    return false;
}
function validateRegion($var){
    global $region;
    if (!is_int($var) || (!array_key_exists($var, $region)) || $var === 0) {
        return true;
    }
    return false;
}
$err = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputFirstname = filterInput($_POST['firstname']);
    $inputLastname = filterInput($_POST['lastname']);
    $inputRegion = filterInput($_POST['region']);
    $inputCyti =filterInput($_POST['place']);
    $inputDate = filterInput($_POST['date']);
}
if (validateString($inputFirstname)){echo 'Имя введено некорректно'; $err = "err";
} else if (validateString($inputLastname)){echo 'Фамилия введена некорректно';
} else if (validateDate($inputDate)){echo 'Дата рождения введена некорректно';
} else if (validateRegion($inputRegion)){echo 'Область проживания  введена некорректно';
}
else {
    echo <<<EOT
ok
EOT;
}
?>
<html>
<head>
<title>add-user</title>
    <style type='text/css'>
       .err{border-color: red}
    </style>
</head>
<body>
<form method="post" action="" autocomplete="on">
    <lablel>Имя пользователя</lablel>
        <br>
        <input class="<?php echo $err;?>" name="firstname">
        <br>
        <lablel>Фамилия пользователя</lablel>
        <br>
        <input name="lastname">
        <br>
        <lablel>Область проживания</lablel>
        <br>
        <select name="region" size="1">
            <?php
            foreach($region as $k => $v) {
                echo '<option value=' . $k . '>' . $v . '</option>';
            }
            ?>
        </select>
        <br>
        <lablel>Город проживания</lablel>
        <br>
        <textarea name="place" cols="45" rows="8"></textarea>
        <br>
        <label>Дата рождения:</label>
        <input type="date" id="date" name="date"/>
        <br>
        <button type="submit">Отправить</button>


</>
</body>
</html>