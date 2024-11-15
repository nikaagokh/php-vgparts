<?php
use function Core\partial;
use Core\Helper;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>მთავარი გვერდი</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" /><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href= <?= url . '/public/css/styles.css' ?>>

</head>
<body>
    <?php partial('header') ?>
    <div class="app-container">
        <div class="home-container">
            <div class="banner-container">
              <img src="<?= aurl. 'banner.jpg' ?>" class="banner-img">
            </div>
             <?php //partial('category', ['categories' => [['id' => 1, 'name' => 'Audi', 'image' => 'audiimage.png'], ['id' => 2, 'name' => 'BMW', 'image' => 'bmwimage.png']]]) ?>
             <?php partial('category', ['categories' => $categories]) ?>
             <?php partial('slider', ['products' => $discounts['products'], 'category' => 'ფასდაკლებები', 'hydration' => $discounts['products'], 'path' => 'discounted']) ?>
             <?php partial('slider', ['products' => $populars['products'], 'category' => 'პოპულარულები', 'hydration' => $populars['products'], 'path' => 'popular']) ?>
        </div>
          <div class="home-skeleton" style="display:none;">
          <div class="cards">
            <div class="card is-loading full">
              <div class="image mob"></div>
              <div class="content">
                  <h2 class="line"></h2>
                  <p class="line more"></p>
              </div>
            </div>
          <div class="cardbody">
           <div class="wrapper">
              <h2 class="line one"></h2>
              <h2 class="line two"></h2>
           </div>
           <div class="wrapper">
            <h2 class="line one"></h2>
            <h2 class="line two"></h2>
         </div>
         <div class="wrapper">
            <h2 class="line one"></h2>
            <h2 class="line two"></h2>
         </div>
         <div class="wrapper">
            <h2 class="line one"></h2>
            <h2 class="line two"></h2>
         </div>
         <div class="wrapper">
            <h2 class="line one"></h2>
            <h2 class="line two"></h2>
         </div>
        </div>
       </div>
      </div>
    </div>
    <?php partial('footer') ?>
    <div class="overlay-container"></div>
    <div class="toast-container"></div>
    <script src=<?= url . '/public/js/index.js' ?> type="module"></script>
</body>
</html>