<?php
    include_once('includes/functions.php');

    $error_msg = "";
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>AES Encryption Alogarithm </title>

    <!-- styles -->
    <link href="assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
    <link href="assets/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all" />
    <link href="assets/css/main.min.css" rel="stylesheet" type="text/css" media="all" />
    <link href="assets/css/template.min.css" rel="stylesheet" type="text/css" media="all" />
    <link href="assets/css/encrypt.css" rel="stylesheet" type="text/css" media="all" />
    <link href="assets/libs/Ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css" media="all" />
    <link href="assets/css/fileinput.min.css" rel="stylesheet" type="text/css" media="all" />

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
  <header class="main-header">
    <nav class="navbar navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
              <a href="/" class="navbar-brand">
                  AES - 256 <b>ENCRYPTION</b>
              </a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                  <i class="fa fa-bars"></i>
              </button>
          </div>
      </div>
    </nav>
  </header>
  <div class="content-wrapper">
    <div class="container">
        <section class="content-header">
          <h1>Encrypt CSV File </h1>
        </section>
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="bs-callout bs-callout-warning">
                <h4>Please Note</h4>
                Encrypted and Decrypted files are saved in the 'files' Folder
              </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="clearfix">
                            <h3 class="box-title">Upload CSV File</h3>
                        </div>
                    </div>
                    <div class="box-body">
                        <form method="POST" action="" accept-charset="UTF-8" enctype="multipart/form-data">
                            <div class="form-group ">
                                <label for="batch" class="control-label required">CSV File</label>
                                <input class="file" id="upload-form" data-show-preview="true" data-max-file-size="0" name="batch" type="file" required>
                                <p class="help-block"> <?php if (isset($done)) { echo $done; }?></p>
                            </div>
                            <div class="form-group ">
                                <label for="type" class="control-label required">Type</label>
                                <select class="form-control" name="type" required/>
                                  <option value=""> Select Type </option>
                                  <option value="encrypt"> Encrypt </option>
                                  <option value="dencrypt"> Decrypt </option>
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="enc_key" class="control-label required">Encyrption Key</label>
                                <input class="form-control" name="enc_key" type="text" required>
                            </div>
                            <input class="btn btn-primary btn-lg btn-flat" type="submit" value="Shoot">
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>

      <!-- footer-->
      <footer class="main-footer">
        <div class="text-center hidden-xs">
          <strong>Copyright &copy; <?= date('Y'); ?> <a href="#" target="_blank">Soft Alliance</a>.</strong>
          All rights reserved.
        </div>
      </footer>

      <!--scripts-->
      <script src="assets/js/jquery-2.2.3.min.js"></script>
      <script src="assets/js/piexif.min.js"></script>
      <script src="assets/js/fileinput.min.js"></script>
      <script src="assets/libs/bootstrap/js/bootstrap.min.js"></script>
      <script>
        $("#upload-form").fileinput({
          'showUpload': false,
          'showPreview': true,
          'showDrag': true,
          allowedFileExtensions: ["csv"],
        });
      </script>
   </div>
</body>
</html>
