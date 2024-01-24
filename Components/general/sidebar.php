<style>
    
    .sidebar {
    height: 100%; /* 100% Full-height */
    width: 250px; /* width - change this with JavaScript*/
    position: fixed; /* Stay in place */
    z-index: 1; /* Stay on top */
    top: 0;
    left: 0;
    
    overflow-x: hidden; /* Disable horizontal scroll */
    padding-top: 60px; /* Place content 60px from the top */
    transition: 0.5s; /* 0.5 second transition effect to slide in the sidebar */
    }
    
    .sidebar .label {
    font-size: .75em;
    display: inline-block;
    border-radius: .2em;
    padding: 2px 5px;
    background-color: #ccc;
    color: black;
    margin: 0 3px; }


</style>


<!--<div id='main' style="height:100%; width:100%;border: none !important;">-->
    <!--<div style="margin-left:auto;padding:10px;height:100%;z-index:0;background-color:transparent;border: none !important;">-->
<!--<div style="overflow-y: hidden; overflow-x: hidden;">
    <div style="overflow-y: hidden; overflow-x: hidden;position: relative;margin:auto; z-index:0; top:-15%;">
            <iframe id="my_frame" scrolling="no" style="height:100%; width:100%; border: none !important;" src=""   name="contentframe"></iframe>
    </div>
</div>-->
<!--</div>-->
<div style="background-color: yellow; padding: 0; margin: 0; height:0%;">
<div style="margin:0;padding:0;height:0%;;z-index:0;background-color:transparent;border: none !important;">
        <iframe scrolling="no" style="height:100%; width:88%; border: none !important;" src=""   name="contentframe">
</iframe>
</div>
</div>

<aside style="background-color: #3a4651;" class="sidebar" id="mySidebar">
    <div class="sidebar-container">
        <div class="sidebar-header">
            <div class="brand">
                <br>
            </div>
        </div>
        <br>
        <nav class="menu">
            
            <ul class="sidebar-menu metismenu" id="sidebar-menu">
                <li>
                    <?php 
                  
                        if($_SESSION['privilege_level'] == 3){
                            $DashboardUrl = "../../Pages/Dashboard/patientDashboard.php";
                           
                        }else{
                            $DashboardUrl = "../../Pages/Dashboard/physicianDashboard.php";
                        }
                    ?>
                    <a href="<?php echo  $DashboardUrl;?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                     Health Measures </a>
                </li>
                <li>
                    <a  href="../../Pages/Forms/chooseSurvey.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-archive"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                     Surveys 
                    </a>
                </li>
                <li>
                    <a href="../../Pages/Dashboard/resourceAndEducation.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        Health Measures and Education 
                    </a>
                </li>
                <li>
                    <a href="../../Pages/Dashboard/graphing.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
                     Graphs 
                    </a>
                </li>
                <li>
                <?php if($_SESSION['privilege_level']==2||$_SESSION['privilege_level']==1) // $_SESSION["userlevel"] if needed as there is a session stored in articles.php
                 {?>
                    <a href="../../Pages/Dashboard/communicationDashboard.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail">  <path d="M20.992 4H3.008C2.449 4 2 4.443 2 5.005v13.99C2 19.55 2.443 20 3.008 20h17.984C21.551 20 22 19.557 22 18.995V5.005C22 4.45 21.556 4 20.992 4z"></path>
                     <polyline points="3.5 6.993 12 12.497 20.5 6.993"></polyline></svg>
                     Communication 
                     </a>
                 <?php }?>
                </li>

                <?php
                if($_SESSION['privilege_level'] == 1) {
                ?>
                <li>
                    <a href="../../Components/general/admin_page_verification.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                     Set Privileges 
                    </a>
                </li>
                <?php } ?>
            </ul>
        </nav>
    </aside>


<script type='text/javascript'>
$("document").ready(function(){


    $('a').click(function() {
        $('#my_frame').attr('src', this.href);
        //var name = $('#my_frame').attr('src');
    });









    $(".sidebar-menu>li").each(function() {
        var navItem = $(this);
        var current_location_last = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
        var href_item = navItem.find("a").attr("href");
        var href_item_last = href_item.substring(href_item.lastIndexOf('/')+1);
        if (href_item_last == current_location_last) {
            navItem.addClass("active");
        }
       //important : any types of form in pages/forms need to contain Form.php at the end of it so that sidebar keep survey Tab active
        if(current_location_last.includes("Form.php")  && href_item_last==="chooseSurvey.php" ){
           
            navItem.addClass("active");
        }
    });
});
</script>