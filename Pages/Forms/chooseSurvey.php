<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <title>Choose your survey</title>
    <style>
        #box1 {
            padding: 200px 0;
            text-align: center;
            position: relative;
            float: left;
            background-color: lightgrey;
            width: 40%;
            height: 500px;
            color: black;
            margin: 20px;
        }

        #box2 {
            padding: 200px 0;
            text-align: center;
            position: relative;
            float: right;
            background-color: lightgrey;
            width: 40%;
            height: 500px;
            color: black;
        }

        .carousel-item img {
            width: 100%;
            height: 600px;
            object-fit: cover;
            filter: blur(4px);
        }

        .carousel-item video {
            width: 100%;
            height: 600px;
            object-fit: cover;
           
        }
        .carousel-caption {

            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            text-align: center;
            width: 70%;
            color: #000;
            font-weight: bolder;
            font-family:Arial, Helvetica, sans-serif
            /* text-shadow: 2px 2px 2px #000; */


        }
    </style>
</head>

<body>
    <?php 
include_once "../../Components/general/header.php";
?>
    <?php 
include_once "../../Components/general/sidebar.php";

?>

    <div style="background-color: transparent;" id="main">

        <div class="container">
            <span class="col-12" id="health_measures">Surveys</span>

            <hr>
            <br>
            <div style="width:100%; display: inline-block" class="row">

                <div id="carouselExampleDark" class="carousel carousel-dark slide" >
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">

                    <div class="carousel-item active" >
                            <video src="../../Assets/Videos/vws_vid.mp4" autoplay loop controls></video>
                            <div class="carousel-caption d-none d-md-block">
                                <h3 style="color:#000; font-weight:bolder; "></h3>
                               
                            </div>
                        </div>

                        <div class="carousel-item">
                            <img style=" width:300 ;height:200"
                                src="../../Assets/img/functional-capacity-evaluation.jpg" class="d-block w-100"
                                alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h3 style="color:#000; font-weight:bolder; ">Connection for healthy living</h3>
                                <p style="color:#000; font-weight:bolder; ">In this survey you will be provided with a
                                    set of questions that
                                    enables health researchers study how your functional capacity looks like over time.

                                </p>
                                <a style=" color:#000; transition: color 0.3s;" onmouseover="this.style.color='green'"
                                    onmouseout="this.style.color='#000'" href="../../Pages/Forms/surveyForm.php">Click
                                    here to participate</a>
                            </div>
                        </div>



                        <div class="carousel-item" >
                            <img style=" width:300 ;height:200" src="../../Assets/img/psychology-at-healthpointe.jpg"
                                class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h3 style="color:#000; font-weight:bolder; ">Psychology Survey</h3>
                                <p style="color:#000; font-weight:bolder; ">In this survey you will be provided with a
                                    set of questions that
                                    enables health researchers study how your mental health looks like over time.
                                </p>
                                <a style=" color:#000; transition: color 0.3s;" onmouseover="this.style.color='green'"
                                    onmouseout="this.style.color='#000'"
                                    href="../../Pages/Forms/psychologicalForm.php">Click here to participate</a>
                            </div>

                        </div>

                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

            </div>

        </div>

    </div>

</body>

</html>