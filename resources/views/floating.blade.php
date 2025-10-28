<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website dengan WhatsApp Button</title>

    <!-- 1. LINK FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* 2. STYLE FLOATING BUTTON */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .whatsapp-float:hover {
            background-color: #128C7E;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Website Anda</h1>
        <p>Konten website di sini...</p>
    </div>

    <!-- 3. FLOATING BUTTON -->
    <a href="https://wa.me/6289505647628?text=Halo,%20saya%20tertarik%20dengan%20produk%20Anda"
       class="whatsapp-float"
       target="_blank">
       <i class="fab fa-whatsapp"></i>
    </a>

</body>
</html>
