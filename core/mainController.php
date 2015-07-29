<?php
session_start();

$document_root=$_SERVER['DOCUMENT_ROOT'];
$document_root=str_replace("/","\\",$document_root );
$actual_directory=  getcwd();
$actual_directory=  str_replace("/","\\",$actual_directory );
$appDir="/".str_replace($document_root,"",$actual_directory)."/";
define("ROOT_DIR", $appDir);
define("MODULE_DIR", $appDir."modules/");
define("LIBS_DIR", $appDir."libs/");
define("UPLOADS_DIR", $appDir."uploads/");
define("SITE_DIR", $appDir."site/");

$params=$_REQUEST;

$usuario=$_SESSION["user"];

