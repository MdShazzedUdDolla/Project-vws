<?php 
session_start();

include_once "../../API/Database/config.php";
include_once "../../API/Database/security/sanitization.php";


// creating the article 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_article'])) {

    $articlename = $_POST['article_name']; // $articlename is obtained from createArticle page
    $author = $_POST['author_name'];       // $author is obtained from createArticle page
    $abstract = $_POST['abstract'];         // $abstract is obtained from createArticle page
  
    if (!is_dir('../../uploads')) {
        mkdir('../../uploads');
    }

    if (isset($_FILES['pdf_file']['name'])) {
        
        $filename = "../../uploads/" . $_FILES['pdf_file']['name']; // $filename is obtained from createArticle page and added with location of desired location to move the uploaded article 



        // Set the maximum upload file size to 20MB
        ini_set('upload_max_filesize', '20M');
        ini_set('post_max_size', '20M');
        ini_set('memory_limit', '128M');
        $error = "";
       // Check if the file size is within the limit
      // echo $_FILES["pdf_file"]["size"];
        if($_FILES["pdf_file"]["size"] > 20 * 1024 * 1024) {
            echo "Error: Please upload a file smaller than 20MB.";
            $error = "Error: Please upload a file smaller than 20MB.";
            header("location: ../../Pages/Dashboard/resourceAndEducation.php?Error=$error ");
            exit("Please upload a file smaller than 10MB.");
        }
       
        if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $filename)==true) { 
            echo "The file " . basename($_FILES["pdf_file"]["name"]) . " has been uploaded."; 
          
            //add to database only after it was actually uploaded 
            $sqlForCreateArticle = "INSERT into article (USR_AUTO_KEY, article_name,author,abstract,filename) VALUES (?, ?,?,?,?)";
            $conn = startConnection();
            $user_auto_key = $_SESSION['user_auto_key'];
            $resultForCreateArticle = SafeRunInsert($conn, $sqlForCreateArticle, [$user_auto_key, $articlename, $author, $abstract, $filename]);
            if($resultForCreateArticle==true){
                closeConnection($conn);  
            }else{
                
                echo "There was an error adding record of upload";
                $error="There was an error adding record of upload";
            }
            
        } else {
                    echo "Sorry, there was an error uploading your file.".$_FILES['pdf_file']['error'];
                    $error="Sorry, there was an error uploading your file.";
                }
                header("location: ../../Pages/Dashboard/resourceAndEducation.php?Error=$error ");
               exit($error);
        
        } else {
        ?>
            <div class=
            "alert alert-danger alert-dismissible
            fade show text-center">
              <a class="close" data-dismiss="alert"
                 aria-label="close"></a>
              <strong>Failed!</strong>
                  File must be uploaded in PDF format!
            </div>
          <?php
    }
} else {
    error_reporting(E_ALL);
ini_set('display_errors', 1);

}


/*
For displaying the articles in resource and education page
- to store the table of article in a session
*/
$conn = startConnection();
$sqlforarticle = "SELECT * FROM article";
$resultforarticle = runSelect($conn, $sqlforarticle,);



/*
function to search for articles with matching author name, article name or article abstract
@param $search - the article name,abstract and autho name to be searched 
return $resultForSearch - the matching parameters
*/

function searchArticle($search){
          $conn = startConnection();
          $san = new  sanitization();
          $search = $san->sanitize_data($search, 'string');
          $search = $san->sanitize($search);
          $sqlForSearch = "SELECT *
          FROM article
          WHERE author LIKE ?
          UNION
          SELECT *
          FROM article
          WHERE abstract LIKE ?
          UNION
          SELECT *
          FROM article
          WHERE article_name LIKE ?;
            ";
       
        $resultForSearch= SafeRunSelect($conn, $sqlForSearch, ["%$search%", "%$search%", "%$search%"]);
        if($resultForSearch!=null)
        {
            closeConnection($conn);
            return $resultForSearch;
            
        }else {
            echo "No matches Found!<br>";
        }
       
}
?>