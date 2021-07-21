<?
define('ID', '7908356');
define('SECRET', 'YqQQ8u3hk5zlE61NejwI');
define('URL', 'https://masyasm.ru/profile/vk.php');

if (!$_GET['code']) {
    exit('error code');
}

$token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id='.ID.'&redirect_uri='.URL.'&client_secret='.SECRET.'&code='.$_GET['code'].''), true);

if (!$token) {
    exit('error token');
}

$data = json_decode(file_get_contents('https://api.vk.com/method/users.get?user_id='.$token['user_id'].'&access_token='.$token['access_token'].'&fields=uid,first_name,last_name'), true);

if (!$data) {
    exit('error data');
}


echo '<pre>';
print_r($token);
'</pre>';

?>
