<?php
include "../../API/PhysiciansAPI/articles.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resources and Education</title>
    <link rel="" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css"> 
</head>


<body>
<?php 
include_once "../../Components/general/header.php";
?>
<?php
include_once "../../Components/general/sidebar.php";
 
?>
<div id="main">
    <h1 class="text-center">Resource and Education</h1>

  

  <br>
  <!-- search bar for looking up articles  with matching author name, article name or article abstract -->
  <form class="form-inline my-2 my-lg-0"  method="GET">
    <input class="form-control mr-sm-2" type="search" name="search" placeholder="What are you looking for?" aria-label="Search" style="width:50%">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit">Search</button>
    <!-- create article for button for admin and physician -->
    <?php if($_SESSION['privilege_level']==2||$_SESSION['privilege_level']==1) 
    {?>
    <div style="float:right; margin-left:30%">
    <a class="btn btn-primary" href="../../Pages/Dashboard/CreateArticle.php" style="text-align:center">+ CREATE ARTICLE</a>
    </div>  
   <?php }
  //show if there was any error while uploading
    if(isset($_GET['Error']) && strcmp($_GET['Error'], "")!=0){
      echo '<br><div class="alert alert-warning" role="alert">
     '.$_GET['Error'].'
    </div>';
    }
  ?>  
 
  
  </form>

  <br>
  <hr>
  <?php

// display the searched article
if (isset($_GET['submit'])){
  ?>
    <a class="btn btn-primary" href="./resourceAndEducation.php">Clear Filter</a> <!-- search article -->  
  <?php


  $search=$_GET['search'];
 
   $resultForSearch= searchArticle($search);
  
  if ($resultForSearch!=null) {
      if (($numres =mysqli_num_rows($resultForSearch)) > 0) {
        echo "<br>Number of results found: ".$numres;
        $column_count = 0;
        ?>
        <div class="row">
          <?php
        while($articles = mysqli_fetch_assoc($resultForSearch)){
          ?>
          <div class="col-sm-6">
                <div class="card" style="height: 32rem">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $articles["article_name"] ?></h5><footer class="blockquote-footer"><?php echo $articles["author"] ?></footer>
                    <p class="card-text"><?php echo $articles["abstract"] ?></p>
                    <a href="<?php echo $articles["filename"] ?>" class="btn btn-primary">Read Article</a>

                </div>
                </div>
          </div>
          <?php
              $column_count++;}

        if($column_count==2)
          {
          ?>
        </div>
        <?php $column_count = 0;}
      } 
  }
}
else {
// display all articles 
 ?>

    <!-- display the 2 articles per rows -->
    <!-- display 4 articles per page -->
    <?php
    $limit=4;
    $sqlforarticle = "SELECT * FROM article";
    $conn = startConnection();
    $resultforarticle = runSelect($conn, $sqlforarticle);
    if($resultforarticle!=null){
    $total_rows = mysqli_num_rows($resultforarticle);
    $total_pages = ceil ($total_rows / $limit);
    if (!isset ($_GET['page']) ) {

        $page_number = 1;

    } else {

        $page_number = $_GET['page'];

    }
    $initial_page = ($page_number-1) * $limit;
    $sqlforarticle = "SELECT * FROM article LIMIT " . $initial_page . ',' . $limit;
    $resultforarticle = runSelect($conn, $sqlforarticle);

    if(!$resultforarticle || mysqli_num_rows($resultforarticle)==0)
    {
      ?> 
        <!-- display text if no articles uploaded -->
        <h3> To be Added</h3>  </div>
     <?php 
    }
    else
    if (mysqli_num_rows($resultforarticle) > 0) {
      $column_count = 0;
      ?>
<div class="row">
        <?php
        while (($articles = mysqli_fetch_assoc($resultforarticle))) {

          ?>

   <!-- displaying the articles in card style  -->
  <div class="col-sm-6">
        <div class="card" style="height: 32rem">
        <div class="card-body">
            <h5 class="card-title"><?php echo $articles["article_name"] ?></h5><footer class="blockquote-footer"><?php echo $articles["author"] ?></footer>
            <p class="card-text"><?php echo $articles["abstract"] ?></p>
            <a href="<?php echo $articles["filename"] ?>" class="btn btn-primary">Read Article</a>
            
        </div>
        </div>
  </div>
  <?php 
      $column_count++;}

      if($column_count==2)
        {
        ?>
</div>
      <?php $column_count = 0;}?>
 
  
        <?php
        closeConnection($conn);}

    
    ?>
</div>

<!-- pagination for article page -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
           <?php for($i = 1; $i<= $total_pages; $i++){ ?>
             <li><a class="btn btn-primary" href="./resourceAndEducation.php?page=<?= $i; ?>"><?= $i; ?></a></li>
           <?php } ?>

  </ul>
</nav>
   <?php } ?>
   <?php } ?>