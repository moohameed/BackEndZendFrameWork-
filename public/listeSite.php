<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
/*echo '---->'.gethostbyname('www.pedicure-podologue-trioux.fr');
echo'<br>';
print_r(gethostbynamel('www.alliance-cbm.fr'));
echo'<-------';
exit;*/
$ipQlic='167.114.236.30';
$tabs=array();

$file = fopen('C:\Users\haith\Desktop\siteFerme.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
  //$line is an array of the csv elements
    $tabs[]=trim($line[0]);
 // print_r($line);
}
fclose($file);

$tableClic=array();
$tableAutre=array();
foreach ($tabs as $site){
    $ipSite=gethostbyname($site);
    if($ipSite!=$site){
        if($ipSite==$ipQlic){
           $tableClic[]=$site.' ==> '.$ipSite;
        }else{
             $tableAutre[]=$site.' ==> '.$ipSite;
        }
        
    }
    
}

echo '-------------167.114.236.30----------------<br>';
foreach ($tableClic as $site){
    echo $site.'<br>';
}

echo '---------Autre---------------<br>';
foreach ($tableAutre as $site){
    echo $site.'<br>';
}



exit;

echo '<pre>';
 print_r($tabs);
 

exit;


chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
