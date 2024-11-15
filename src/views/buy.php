<?php

use function Core\partial;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>მთავარი გვერდი</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href=<?= url . '/public/css/styles.css' ?>>

</head>

<body>
    <?php partial('header') ?>
    <div class="app-container">
        <div class="buy-centered">
            <div class="buy-container">
                <div class="buy-information">
                    <div class="buy-information-flex">
                        <div class="img-container">
                            <img src="/vgparts/public/images/assets/inf.png" class="inf-img">
                        </div>
                        <div class="information">ინფორმაცია</div>
                    </div>
                    <a href="/vgparts/" class="close">
                        <i class="material-symbols-outlined">arrow_back</i>
                    </a>
                </div>
                <div class="buy-description">
                    <p class="inf-paragraph">ტექნიკური სამუშაობის გამო, <b>2024 წლის 1 სექტემბრამდე</b> შეზღუდულია ონლაინ გადახდის სისტემა, ამიტომ პროდუქტის საყიდლად უნდა მობრძანდეთ ლოკაციაზე ან ისარგებლეთ ფასიანი მიტანის სერვისით</p>
                </div>
                <div class="contact-container">
                    <div class="delivery">
                        <i class="material-symbols-outlined">location_on</i>
                        <a href="https://www.google.com/maps/place/9+%E1%83%A8%E1%83%90%E1%83%9C%E1%83%93%E1%83%9D%E1%83%A0+%E1%83%9E%E1%83%94%E1%83%A2%E1%83%94%E1%83%A4%E1%83%98%E1%83%A1+%E1%83%A5%E1%83%A3%E1%83%A9%E1%83%90,+%E1%83%97%E1%83%91%E1%83%98%E1%83%9A%E1%83%98%E1%83%A1%E1%83%98/@41.6929266,44.8619146,17z/data=!4m5!3m4!1s0x40440dbe85bca99d:0x239cc0763bc8f76a!8m2!3d41.6944207!4d44.8625476?entry=ttu" class="decoration"> შანდორ პეტეფის ქუჩა, 9 </a>
                    </div>
                    <div class="delivery">
                        <i class="material-symbols-outlined">local_shipping</i>
                        <a href="tel:+995558121999" class="decoration">მიტანა | 15₾</a>
                    </div>

                </div>
                <div class="or">ან</div>
                <div class="contact-us">
                    <div class="delivery">
                        <mat-icon class="icon-delivery">phone</mat-icon>
                        <a href="tel:+995558121999" class="decoration">558 121-999</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php partial('footer') ?>
    <div class="overlay-container"></div>
    <div class="toast-container"></div>
    <script src="/vgparts/public/js/buy.mjs" type="module"></script>
</body>