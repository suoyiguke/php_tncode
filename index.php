<?php
include_once 'spyc.php';
$yml= spyc_load_file('spyc.yml');
if(array_key_exists('code_website',$_ENV)){
    $yml['website'] = $_ENV['code_website'];
    $yml['name'] = $_ENV['code_name'];
    $yml['img_href'] = $_ENV['code_img_href'];
    $yml['bucket'] = $_ENV['code_bucket'];
    $yml['folder_name'] = $_ENV['code_folder_name'];

}
?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>TnCode</title>
    <script type="text/javascript" src="./tn_code.js?v=35"></script>
    <link rel="stylesheet" type="text/css" href="style.css?v=27" />
</head>

<body>
<script type="text/javascript">
var name = '<?php echo $yml['name']; ?>';
var website = '<?php echo $yml['website']; ?>';
window.web_name = name;
window.web_website = website;

$TN.onsuccess(function(){
//验证通过
});
</script>

</body>
</html>
