 
<?php   
  
// Requires php5   
define('UPLOAD_DIR', 'uploads/signature/');
$img = $_POST['imgBase64'];   
$filename = $_POST['filename']; 
$img = str_replace('data:image/png;base64,', '', $img);   
$img = str_replace(' ', '+', $img);   
$data = base64_decode($img);   
$file = UPLOAD_DIR . $filename;   
$success = file_put_contents($file, $data);   
echo $file;
  
?>