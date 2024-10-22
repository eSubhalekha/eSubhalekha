<?php


function getImgURL($name){
  $gallery = new Gallery();
  $row=$gallery->getGalleryImg($_REQUEST['id'],$name);
  
  if($row['imageURL']){
    return $row['imageURL'];
  }
  else{
    return false;
  }
  
}



controller('Theme');
controller("Wedding");
controller("Gallery");

$wedding = new Wedding();
$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);

// Instantiate the ThemeController class
$themeController = new ThemeController();
// Call the getThemes method
if(isset($_REQUEST['theme'])){
       $folders = array_filter(glob('themes/*'), 'is_dir');
    
      foreach ($folders as $folder) {
            
            $themeID = ucwords(explode("_", basename($folder))[1]);
           
            if($themeID == $_REQUEST['theme'] ){
        
                $themes = $themeController->render(basename($folder));        
            }
      }
      
//  $themes = $themeController->render($_REQUEST['theme'], $_REQUEST['type']);  
}
else if(isset($weddingData['template'])){
  locked(['user', 'host', 'manager', 'admin']);
  $themes = $themeController->render($weddingData['template'], $_REQUEST['type']);  

}
