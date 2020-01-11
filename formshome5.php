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
//print_r($region);
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
    if (empty($var) || (!array_key_exists($var, $region)) || $var === 0) {
        return true;
    }
    return false;
}
$err = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputFirstname = filterInput($_POST['firstname']);
    $inputLastname = filterInput($_POST['lastname']);
    $inputRegion = filterInput($_POST['region']);
    $inputAdress = filterInput($_POST['adress']);
    $inputCity = filterInput($_POST['city']);
    $inputDate = filterInput($_POST['date']);

    if (!preg_match('/^[А-Яа-я\s]{2,32}$/u', $inputFirstname)) {
        echo 'Имя введено некорректно';
        //$err = "err";
        $errors['firstname'] = $inputFirstname;
    } else if (!preg_match('/^[А-Яа-я-]{2,32}$/u', $inputLastname)) {
        echo 'Фамилия введена некорректно';
        // $err = "err";
        $errors['lastname'] = $inputLastname;
    } else if (validateRegion($inputRegion)) {
        echo 'Область проживания  введена некорректно';
        // $err = "err";
        $errors['region'] = $inputRegion;
    } else if (!preg_match('/^[А-Яа-я\s-]{2,32}$/u', $inputCity)) {
        echo 'Город проживания  введен некорректно';
        $err = "err";
        $errors['city'] = $inputCity;
    } else if (!preg_match('/^[А-Яа-я0-9\s-,\.]{2,32}$/u', $inputAdress)) {
        echo 'Адрес проживания  введена некорректно';
        //$err = "err";
        $errors['adress'] = $inputAdress;
    } else if (validateDate($inputDate)) {
        echo 'Дата рождения введена некорректно';
        //$err = "err";
        $errors['date'] = $inputDate;
    } else {
        $date = date_create_from_format('Y-m-d', $inputDate);
        $inputDateFormat = date_format($date, 'd.m.Y');
        echo <<<EOT
"Пользователь $inputFirstname $inputLastname, $inputDateFormat г.  рождения, проживающий по адресу: $region[$inputRegion], г. 
$inputCity, $inputAdress, был успешно добавлен в систему"
EOT;
    }
}
?>
<?php if ($_SERVER['REQUEST_METHOD'] == 'GET'|| !empty($errors)){ ?>
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
        <input class="<?php if (array_key_exists('firstname', $errors)) echo 'err' ;?>"
               value="<?php if (!empty($inputFirstname)) echo $inputFirstname; else echo''; ?>" name="firstname">
        <br>
        <lablel>Фамилия пользователя</lablel>
        <br>
        <input class="<?php if (array_key_exists('lastname', $errors)) echo 'err' ;?>"
               value="<?php if (!empty($inputLastname)) echo $inputLastname; else echo''; ?>" name="lastname">
        <br>
        <lablel>Область проживания</lablel>
        <br>
        <select class="<?php if (array_key_exists('region', $errors)) echo 'err' ;?>" name="region" size="1">
            <?php
            foreach($region as $key => $value) {
                echo '<option value=' . $key . '>' . $value . '</option>';
            }
            ?>
        </select>
        <br>
        <lablel>Город проживания</lablel>
        <br>
        <input class="<?php if (array_key_exists('city', $errors)) echo 'err' ;?>"
               value="<?php if (!empty($inputCity)) echo $inputCity; else echo''; ?>" name="city">
        <br>
        <lablel>Адрес проживания </lablel>
        <br>
        <textarea class="<?php echo $err;?>"
                  placeholder="<?php if (!empty($inputAdress)) echo $inputAdress; else echo''; ?>"
                  name="adress" cols="45" rows="8"></textarea>
        <br>
        <label>Дата рождения:</label>
        <input class="<?php if (array_key_exists('date', $errors)) echo 'err' ;?>" type="date" id="date"
               value="<?php if (!empty($inputDate)) echo $inputDate; else echo''; ?>" name="date"/>
        <br>
        <button type="submit">Отправить</button>
</body>
</html>
<?php } ?>
