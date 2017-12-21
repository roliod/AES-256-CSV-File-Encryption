<?php

$error_msg = "";

//check for post data
if ($_FILES && ! empty($_POST['enc_key'])) {

    /*
     * The variables we need
     *
     */

    $iv = random_bytes(16);
    $cipher = "AES-256-CBC";
    $key = $_POST['enc_key']; //heres the encryption key
    $filename = $_FILES["batch"]["name"];
    $content = file_get_contents($_FILES["batch"]["tmp_name"]);

    return encrypt_file($content, $iv, $key, $cipher, $filename);
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
