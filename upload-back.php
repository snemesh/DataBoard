<?php
// Каталог, в который мы будем принимать файл:

$uploaddir = './uploads/';
$uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);
$delimiter = ";";
// Копируем файл из каталога для временного хранения файлов:
if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile))
{
    //echo "<h3>Файл успешно загружен на сервер</h3>";
}
else { echo "<h3>Ошибка! Не удалось загрузить файл на сервер! Убедитесь что вы выбрали правелный файл</h3>"; exit; }
$myFile=$_FILES['uploadfile']['name'];
// Выводим информацию о загруженном файле:
//echo "<h3>Информация о загруженном на сервер файле: </h3>";
//echo "<p><b>Оригинальное имя загруженного файла: ".$myFile."</b></p>";
//echo "<p><b>Mime-тип загруженного файла: ".$_FILES['uploadfile']['type']."</b></p>";
//echo "<p><b>Размер загруженного файла в байтах: ".$_FILES['uploadfile']['size']."</b></p>";
//echo "<p><b>Временное имя файла: ".$_FILES['uploadfile']['tmp_name']."</b></p>";

$fullFilePath = "uploads/".$myFile;
//echo($fullFilePath);

$file_array = file($myFile);
array_pop($file_array);
array_shift($file_array);
$countOfArray=count($file_array);


foreach ($file_array as $key=>$value){
    //echo("<br>".$value);
    $arr = explode($delimiter, $value);
    $arrName[]=$arr[2];
    $arrProjectName[]=$arr[0];
    $arrEstimate[]=$arr[3];
    $arrLoged[]=$arr[4];
}
$finalArrayOfProjects=array();
$finalArrayOfEstimation=array();
$finalArrayOfLoged=array();
$finalArrayOfName=array();


$countOfArray=count($arrProjectName);
for ($i=0; $i<$countOfArray; $i++){
    if (!in_array($arrProjectName[$i], $finalArrayOfProjects)) {
        $finalArrayOfProjects[]=$arrProjectName[$i];
    }
}

//foreach ($arrName as $key=>$value){
//    echo ("<br>".$value);
//}

$i=0;
$j=0;

for ($j=0; $j<count($finalArrayOfProjects); $j++) {
    for ($i = 0; $i < $countOfArray; $i++) {
        if ($finalArrayOfProjects[$j] == $arrProjectName[$i]) {
            $sum = $sum + (float)str_ireplace(",",".",$arrEstimate[$i]);
            $sum1= $sum1 + (float)str_ireplace(",",".",$arrLoged[$i]);

            //echo ("<br>".(float)str_ireplace(",",".",$arrEstimate[$i]));
            //echo ("<br>".$arrName[$i]);
        }
    }
    $finalArrayOfEstimation[] = $sum;
    $finalArrayOfLoged[] = $sum1;
    $finalArrayOfName[]=$arrName[$i];
    //echo ("<br>".$arrName[$j]);
    //echo ("<br> Sum = ".$sum);
    $sum=0;
    $sum1=0;
}
array_pop($finalArrayOfProjects);
array_pop($finalArrayOfEstimation);
array_pop($finalArrayOfLoged);
echo ("<head><script src=\"script.js\"></script><link rel=\"stylesheet\" href=\"style.css\"></head>");
echo ("<table class='table'>");
echo ("<tr><td>Project name</td><td>Dev Name</td><td>Total Estimatiom</td><td>Total loged</td></tr></tr>");
for ($i = 0; $i < count($finalArrayOfProjects); $i++) {
    echo ("<tr>");
    echo("<td>".$finalArrayOfProjects[$i]."</td>");
    echo("<td>".$finalArrayOfName[$i]."</td>");
    echo("<td>".$finalArrayOfEstimation[$i]."</td>");
    echo("<td>".$finalArrayOfLoged[$i])."</td> ";
    echo ("</tr>");
}
echo ("</table>");

?>