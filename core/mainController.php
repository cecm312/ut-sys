<?php
session_start();

$document_root=$_SERVER['DOCUMENT_ROOT'];
$document_root=str_replace("\\","/",$document_root );
$actual_directory=  getcwd();
$actual_directory=  str_replace("\\","/",$actual_directory );
$appDir=str_replace($document_root,"",$actual_directory);
$appDir=str_replace("\\","",$appDir);
$appDir=str_replace("/","",$appDir);
$appDir="/".$appDir."/";




define("MODULE_DIR", $appDir."modules/");
define("LIBS_DIR", $appDir."libs/");
define("UPLOADS_DIR", $appDir."uploads/");

echo MODULE_DIR;
echo "<br>";
echo LIBS_DIR;
echo "<br>";
echo UPLOADS_DIR;
echo "<br>";

define("ROOT_DIR", $actual_directory);
define("SITE_DIR", $actual_directory."/site/");
define("MODULES_DIR", $actual_directory."/modules/");

echo ROOT_DIR;
echo "<br>";
echo SITE_DIR;
echo "<br>";
echo MODULES_DIR;
echo "<br>";



include_once("view.php");

$objView=new View(SITE_DIR);


if(isset($_SESSION["iduser"])){
    //aqui se obtiene la informacion del profile
    $user=array(
        "profile"=>1,
        "user_type"=>1,
        "name"=>"usuario registrado",
        "avatar"=>""
    );
    $_SESSION["iduser"]=1;
}else{
    $user=array(
        "profile"=>0,
        "user_type"=>0,
        "name"=>"usuario no registrado",
        "avatar"=>""
    );
}
$template="front";
$page="index";

if(isset($_REQUEST["page"])){
    $template="front";
    $page=$_REQUEST["page"];
}else if(isset($_REQUEST["module"])){
    $template="back";
}
$keys=array();
print $objView->print_template($template, $keys);




