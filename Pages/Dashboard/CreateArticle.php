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
    <h1 class="text-center">Create Article</h1>
    <!-- sending the filled form to articples.php -->
    <form method="post" enctype="multipart/form-data" action="../../API/PhysiciansAPI/articles.php">
    <div class="form-input py-2">
        <h6>* Required Fields</h6>
        <div class="form-group">
        <h3>Article heading (250 CHAR MAX)*:</h3>
          <input type="text" class="form-control" name="article_name"
                 placeholder="Article name" maxlength="250"required>
        </div>   
        <div class="form-group">
        <h3>Author Name (250 CHAR MAX)*:</h3>
        <input type="text" class="form-control" name="author_name"
                 placeholder="Author name" maxlength="250"required>
        </div>
        <div class="form-group"> 
            <h3>Abstract (400 CHAR MAX) *:</h3>
        <textarea class = "form-control" style="height:150px"id="abstract" name="abstract"  maxlength="400" required>

        </textarea>
        </div>                   
        <div class="form-group">
            <h3>Upload file (pdf only) (20 MB MAX) *:</h3>
          <input type="file" name="pdf_file"
                 class="form-control" accept=".pdf"
                 title="Upload PDF" required>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary"
                 name="create_article" value="CREATE ARTICLE" > 
        </div>
   </div>
</form>
</div>