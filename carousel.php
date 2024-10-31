<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>carousel</title>
</head>

<body>

    <div>
        <!-- start carousel-->
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"
                    aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4"
                    aria-label="Slide 5"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5"
                    aria-label="Slide 6"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./images/carousel/sl1.jpg" class="d-block w-100" alt="Slide 1" style="height: 400px">
                </div>
                <div class="carousel-item">
                    <img src="./images/carousel/sl2.jpg" class="d-block w-100" alt="Slide 2" style="height: 400px">
                </div>
                <div class="carousel-item">
                    <img src="./images/carousel/sl3.jpg" class="d-block w-100" alt="Slide 3" style="height: 400px">
                </div>
                <div class="carousel-item">
                    <img src="./images/carousel/sl4.jpg" class="d-block w-100" alt="Slide 4" style="height: 400px">
                </div>
                <div class="carousel-item">
                    <img src="./images/carousel/sl5.jpg" class="d-block w-100" alt="Slide 5" style="height: 400px">
                </div>
                <div class="carousel-item">
                    <img src="./images/carousel/sl6.jpg" class="d-block w-100" alt="Slide 6" style="height: 400px">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span
                    class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span> <span
                    class="visually-hidden">Next</span>
            </button>
        </div>
        <!--end carousel-->
    </div>


    <script src="./js/carousel.js"></script>
</body>

</html>