<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- SEO meta tags -->
    <title><?= isset($page_title) ? $page_title : ""; ?></title>

    <meta name="description"  content="<?= isset($page_description) ? $page_description : ""; ?>" />
    <meta name="keywords"  content="<?= isset($page_keywords) ? $page_keywords : ""; ?>" />
    <meta name="subject" content="<?= isset($page_title) ? $page_title : ""; ?>">
    <meta name="language" content="en">
    <meta name="distribution" content="Global">
    <meta name="rating" content="General">
    <meta name="robots" content="index,follow" />

    <!-- @og meta -->
    <meta property="og:title" content="<?= isset($page_title) ? $page_title : "Untitled Webpage"; ?>" />
    <meta property="og:url" content="<?= current_url() ?>" />
    <meta property="og:image" content="#" />
    <meta property="og:site_name" content="<?= isset($page_title) ? $page_title : "Untitled Webpage"; ?>" />
    <meta property="og:description" content="<?= isset($page_description) ? $page_description : ""; ?>" />

    <!-- @twitter meta -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@username" />
    <meta name="twitter:domain" content="@domain" />
    <meta name="twitter:title" content="<?= isset($page_title) ? $page_title : "Untitled Webpage"; ?>" />
    <meta name="twitter:description" content="<?= isset($page_description) ? $page_description : ""; ?>" />
    <meta name="twitter:image" content="<?= $theme_url ?>img/logo.png" />

    <!-- @favicon-->
    <link rel="icon" type="image/png" href="<?= $theme_url ?>img/favicon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= $theme_url ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $theme_url ?>css/custom.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    
  </head>
  <body>
    <?php
      if (isset($view_file)) {
        $this->load->view($module . '/' . $view_file);
      }
    ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= $theme_url ?>js/jquery-3.3.1.slim.min.js"></script>
    <script src="<?= $theme_url ?>js/popper.min.js"></script>
    <script src="<?= $theme_url ?>js/bootstrap.min.js"></script>
  </body>
</html>