<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  @if(isset($seoData,$seoData[0]) && !empty($seoData[0]->seo_title))
    <title>{{$seoData[0]->seo_title}}</title>
  @else
     <title>B-Safe</title>
  @endif
 
  @if(isset($seoData,$seoData[0]) && !empty($seoData[0]->seo_description))
    <meta content="{{$seoData[0]->seo_description}}" name="description">
  @else
    <meta content="" name="description">
  @endif

  @if(isset($seoData,$seoData[0]) && !empty($seoData[0]->seo_keywords))
    <meta content="{{$seoData[0]->seo_keywords}}" name="keywords">
  @else
    <meta content="" name="keywords">
  @endif
  <meta name="robots" content="index, follow">

  <!-- OG Tags -->
    @if (isset($seoData,$seoData[0]->seo_title))
      <meta property="og:title" content="{{ $seoData[0]->seo_title }}">
    @else
      <meta property="og:title" content="B-Safe">
    @endif

    @if (isset($seoData,$seoData[0]->image_name))
    <meta property="og:image" content="{{ $seoData[0]->image_name }}">
    @else
    <meta property="og:image" content="/assets/img/bsafe_fav.png">
    @endif

    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="628" />
    @if(isset($seoData,$seoData[0]) && !empty($seoData[0]->seo_description))
      <meta property="og:description" content="{{$seoData[0]->seo_description}}">
    @else
      <meta property="og:description" content="">
    @endif
    <meta property="og:type" content="website" />

  <!-- Twitter Card tags for Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    @if (isset($seoData,$seoData[0]->seo_title))
      <meta name="twitter:title" content="{{ $seoData[0]->seo_title }}">
    @else
      <meta name="twitter:title" content="B-safe">
    @endif

    @if(isset($seoData,$seoData[0]) && !empty($seoData[0]->seo_description))
      <meta name="twitter:description" content="{{$seoData[0]->seo_description}}">
    @else
      <meta name="twitter:description" content="">
    @endif
    @if (isset($seoData,$seoData[0]->image_name))
    <meta name="twitter:image" content="{{ $seoData[0]->image_name }}">
    @else
    <meta name="twitter:image" content="/assets/img/bsafe_fav.png">
    @endif


  <!-- Favicons -->
  <link href="/assets/img/bsafe_fav.png" rel="icon">
  <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/assets/custom/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="/assets/custom/animate.css/animate.min.css" rel="stylesheet">
  <link href="/assets/custom/aos/aos.css" rel="stylesheet">
  <link href="/assets/custom/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/custom/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/custom/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/assets/custom/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="/assets/custom/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <meta name="theme-color" content="#66bc29">
  <!-- Template Main CSS File -->
  <link href="/assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/assets/css/24limousine.com_wp-content_themes_24Limousine_assets_css_owl.carousel.min.css">



</head>