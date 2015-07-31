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
include_once("dbModel.php");

include_once(SYSTEM_MODULES_DIR."/user/user_model.php");

$objView=new View(SYSTEM_SITE_DIR);

if(isset($_SESSION["iduser"])){
  $idUser=$_SESSION["iduser"]; 
}else{
   $idUser=0;
}
$objUser=new User($idUser);

$template="front";
$page="index";
if(isset($_REQUEST["page"])){
    $keys=array("PAGE"=>$objView->print_template("pages/".$_REQUEST["page"]));
    $web_page=$objView->print_template("front", $keys);
}else if(isset($_REQUEST["module"])){
    $moduleName=$_REQUEST["module"];
    include_once(SYSTEM_MODULES_DIR."/module/module_model.php");
    $objModule=new Module($moduleName);
    switch($objUser->type){
        case 1:
            if($objModule->guestAccess){
                $template="front";
                $accesModule=true;
            }else{
                $accesModule=false;
                $template="login";
            }
            break;
        case 2:
            $template="front";
            $accesModule=true;
            break;
        case 3:
            $template="back";
            $accesModule=true;
            break;
    }
    if($accesModule){
        include_once(SYSTEM_MODULES_DIR.$moduleName."/".$moduleName."_controller.php");
    }
    $keys=array();
    if(isset($html) and $html!=""){
       $keys["CONTAINER"]=$html;   
    }  
    $web_page=$objView->print_template($template, $keys);
}else{
    $keys=array("PAGE"=>$objView->print_template("pages/index"));
    $web_page=$objView->print_template("front", $keys);
}
if(isset($web_page) and $web_page!=""){
   $keys=array("MODULES_DIR"=>MODULES_DIR,"LIBS_DIR"=>LIBS_DIR,"UPLOADS_DIR"=>UPLOADS_DIR);
   print $objView->render_data($web_page, $keys);
}








