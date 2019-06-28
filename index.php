<?php
include_once 'spyc.php';
$yml= spyc_load_file('spyc.yml');

if($_ENV){
    define( 'WEBSITE', $_ENV['WEBSITE'] );
    define( 'NAME', $_ENV['NAME'] );
    define( 'IMG_HREF', $_ENV['IMG_HREF'] );
    define( 'BUCKET', $_ENV['BUCKET'] );
    define( 'FOLDER_NAME', $_ENV['FOLDER_NAME'] );

    $yml['WEBSITE'] = WEBSITE;
    $yml['NAME'] = NAME;
    $yml['IMG_HREF'] = IMG_HREF;
    $yml['BUCKET'] = BUCKET;
    $yml['FOLDER_NAME'] = FOLDER_NAME;


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
    var name = '<?php echo $yml['NAME']; ?>';
    var website = '<?php echo $yml['WEBSITE']; ?>';
    window.web_name = name;
    window.web_website = website;

$TN.onsuccess(function(){
//验证通过
});
</script>

</body>
</html>
