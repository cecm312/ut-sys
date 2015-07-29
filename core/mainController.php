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

define("MODULES_DIR", $appDir."modules/");
define("LIBS_DIR", $appDir."libs/");
define("UPLOADS_DIR", $appDir."uploads/");

define("SYSTEM_ROOT_DIR", $actual_directory);
define("SYSTEM_SITE_DIR", $actual_directory."/site/");
define("SYSTEM_MODULES_DIR", $actual_directory."/modules/");
include_once("view.php");
$objView=new View(SYSTEM_SITE_DIR);
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
    $page="index";
    $keys=array("PAGE"=>$objView->print_template("pages/".$_REQUEST["page"]));
    $web_page=$objView->print_template($template, $keys);
}else if(isset($_REQUEST["module"])){
    $module=$_REQUEST["module"];
    include_once(SYSTEM_MODULES_DIR.$module."/".$_REQUEST["module"]."_controller.php");
    if(isset($html) and $html!=""){
        $template="back";
        $keys=array("CONTAINER"=>$html);
        $web_page=$objView->print_template($template, $keys);
    } 
}else{
    $template="front";
    $page="index";
    $keys=array("PAGE"=>$objView->print_template("pages/index"));
    $web_page=$objView->print_template($template, $keys);
}

if(isset($web_page) and $web_page!=""){
   $keys=array("MODULES_DIR"=>MODULES_DIR,"LIBS_DIR"=>LIBS_DIR,"UPLOADS_DIR"=>UPLOADS_DIR);
   print $objView->render_data($web_page, $keys);
}








