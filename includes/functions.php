<?php

$error_msg = "";

//check for post data
if ($_FILES && ! empty($_POST['enc_key'])) {

    /*
     * The variables we need
     *
     */

    $iv = random_bytes(16);
    $type = $_POST['type'];
    $cipher = "AES-256-CBC";
    $key = $_POST['enc_key']; //heres the encryption key
    $filename = $_FILES["batch"]["name"];
    $content = file_get_contents($_FILES["batch"]["tmp_name"]);

    if ($type == 'encrypt') {
        return encrypt_file($content, $iv, $key, $cipher, $filename);
    } else {
        return decrypt_file($content, true, $key, $cipher);
    }
}

function encrypt_file($value, $iv, $key, $cipher, $filename, $serialize = true)
{
    //were the magic happens
    $value = \openssl_encrypt(
        $serialize ? serialize($value) : $value,
        $cipher, $key, 0, $iv
    );

    if ($value === false) {
       return false;
    }

    //just trying to make sure we can decrypt if we need to
    $mac = hash_mac($iv = base64_encode($iv), $value, $key);

    $json = json_encode(compact('iv', 'value', 'mac'));

    if (! is_string($json)) {
        return false;
    }

    $encrypted_content = base64_encode($json);

    $timestamp = strtotime(date('d-m-y H:i:s'));

    if (!is_dir('files')) {
        mkdir('files');
    }

    return file_put_contents('files/'.$timestamp. '_encrypted.csv', $encrypted_content);
}

function hash_mac($iv, $value, $key)
{
    return hash_hmac('sha256', $iv.$value, $key);
}

function decrypt_file($payload, $unserialize = false, $key, $cipher)
{
    $payload = getJsonPayload($payload, $key);

    $iv = base64_decode($payload['iv']);

    //remember i told you we needed the mac
    $decrypted = \openssl_decrypt(
        $payload['value'], $cipher, $key, 0, $iv
    );

    if ($decrypted === false) {
        die('Could not decrypt the data.'); //you should handle this error differently
    }

    $decrypt_content = $unserialize ? unserialize($decrypted) : $decrypted;

    $timestamp = strtotime(date('d-m-y H:i:s'));

    if (!is_dir('files')) {
        mkdir('files');
    }

    return file_put_contents('files/'.$timestamp. '_decrypted.csv', $decrypt_content);

}

function mac_hash($iv, $value, $key)
{
    return hash_hmac('sha256', $iv.$value, $key);
}

 function getJsonPayload($payload, $key)
{
    $payload = json_decode(base64_decode($payload), true);

    if (! validPayload($payload)) {
        die('The payload is invalid.'); //you should handle this error differently
    }

    if (! validMac($payload, $key)) {
        die('The MAC is invalid.'); //you should handle this error differently
    }

    return $payload;
}

function validPayload($payload)
{
    return is_array($payload) && isset(
        $payload['iv'], $payload['value'], $payload['mac']
    );
}

function validMac(array $payload, $key)
{
    $calculated = calculateMac($payload, $bytes = random_bytes(16), $key);

    return hash_equals(
        hash_hmac('sha256', $payload['mac'], $bytes, true), $calculated
    );
}

function calculateMac($payload, $bytes, $key)
{
    return hash_hmac(
        'sha256', mac_hash($payload['iv'], $payload['value'], $key), $bytes, true
    );
}
