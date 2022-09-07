<?php
 

include('config.php');


  if(isset($_GET['id'])){
     $listID = $_GET['id'];
    $sql3 = "SELECT * FROM list WHERE list_id = '$listID'";
    $result = mysqli_query($conn, $sql3);
    $row = mysqli_fetch_assoc($result);

 
 }

 if(isset($_POST['Sub'])){
     $listID = $_POST['hiddenID'];
     $list_name = $_POST['listname'];
    $list_category = $_POST['listcategory'];
     $list_date = $_POST['listdate'];
    $list_text = $_POST['listtext'];
    $list_textarea=$_post['listtextarea'];


        if(isset($_FILES) & !empty($_FILES)){
            $name = $_FILES['listimage']['name'];
            $size = $_FILES['listimage']['size'];
            $type = $_FILES['listimage']['type'];
            $tmp_name = $_FILES['listimage']['tmp_name']; 
            $max_size = 10000000;
            $extension = substr($name, strpos($name, '.') + 1); 
            if(isset($name) && !empty($name)){
                if(($extension == "jpg" || $extension == "jpeg") && $type == "image/jpeg" && $size<=$max_size){
                    $location = "img/";
                    $filePath = $location.$name;
                    if(move_uploaded_file($tmp_name, $filePath)){
                        //$smsg = "Uploaded Successfully";  
                        
            $sql2 = "UPDATE list SET listname='$list_name',listcategory='$list_category',listdate='$list_date',listtext='$list_text', listtextarea='$list_textarea', listimage='$filePath' WHERE list_id='$listID'";
 
                        $res = mysqli_query($conn, $sql2);
                        if($res){
                            //echo "Product Created";
                            $message = 'Saved Successfully with image';
                        }else{
                            $message = "Failed to Create Product";
                            echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
                        }
                    }else{
                        $message = "Failed to Upload File";
                    }
                }else{
                    $message = "Only JPG files are allowed and should be less that 1MB";
                }
            }else{
                $message = "Please Select a File";
            }
        } 
        
$sql_update = $sql2 = "UPDATE list SET listname='$list_name',listcategory='$list_category',listdate='$list_date',listtext='$list_text', listtextarea='$list_textarea' WHERE list_id='$listID'";
        
        if (mysqli_query($conn, $sql_update)) {
           
        $message = 'Saved Successfully';
        } else {
          echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
        }

     
    
 

}


    

      

 

?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FANFAIR</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>FANFAIR</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user2.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">USER</h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    
                       
                    <a href="signin.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Sign In</a>
                    <a href="signup.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Sign Up</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Channels</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="Insertwarfaze.php" class="dropdown-item">Add Warfaze Information</a>
                            <a href="warfazetable.php" class="dropdown-item">View Warfaze Information</a>
                            <a href="Insertartcell.php" class="dropdown-item">Add Artcell Information</a>
                            <a href="artcelltable.php" class="dropdown-item">View Artcell Information</a>
                            <a href="Insertkarnival.php" class="dropdown-item">Add Karnival Information</a>
                            <a href="karnivaltable.php" class="dropdown-item">View Karnival Information</a>
                            <a href="Insertnemesis.php" class="dropdown-item">Add Nemesis Information</a>
                            <a href="nemesistable.php" class="dropdown-item">View Nemesis Information</a>
                            <a href="Insertminerva.php" class="dropdown-item">Add Minerva Information</a>
                            <a href="minervatable.php" class="dropdown-item">View Minerva Information</a>
                            

                        </div>
                    </div>
                       <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Merch</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="form.php" class="dropdown-item">Categories</a>
                            <a href="merchandiseproducts.php" class="dropdown-item">Merchandise Products</a>
                            <a href="Products.php" class="dropdown-item">View Products</a>
                            <a href="cartitems.php" class="dropdown-item">Cart-items</a>
                        </div>
                    </div>
                   <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Ticket Selling</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="ticketSelling.php" class="dropdown-item">Add Ticket Selling Information</a>
                            <a href="ticketview.php" class="dropdown-item">View Ticket Information</a>
                            <a href="ticketbilling.php" class="dropdown-item"> Billing Information</a>
                           
                        </div>
                    </div>
                     <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Music Albums</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="Musicview.php" class="dropdown-item">Add Music Album Information</a>
                            <a href="Musicviewlist.php" class="dropdown-item">View Album Information</a>
                          
                           
                        </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Contact messages</a>
                        <div class="dropdown-menu bg-transparent border-0">
                         <a href="contactView.php" class="dropdown-item">View Contact messages</a>   
                            
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <--Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control bg-dark border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                    
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notification</span>
                        </a>
                        
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user2.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">ADMIN</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="#" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Form Start -->
            <div class="container-fluid">
                <div class="row  pt-4 px-4">

                         

                     
                        <div class="col-md-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h2 class="mb-4">Insert List View Information</h2>
                            <?php
        if(isset($message)){
            ?>
    <div class="alert alert-success"><?php echo $message ?></div>
        <?php
        }
        ?>
                            <form method="post" enctype="multipart/form-data">
                                <div class="col-mb-12 py-4">
                                    <label   for="Listname" class="form-label">Band name</label>
                                    <input type="text" class="form-control" id="Listname" name="listname"  placeholder="Band Name"  value='<?php echo $row['listname'];?>' >
                                    
                                </div>
                                <div class="col-mb-12">
                                    <label for="Listcategory"  class="form-label">Category</label>
                                   
                                     <input type="text" class="form-control" id="Listcategory" name="listcategory"  placeholder="Category"  value='<?php echo $row['listcategory'];?>'>
                                </div>
                               <div class="col-mb-12 py-4">
                                  <label for="listtdate">Date</label>
                             
                                     <input type="text" class="form-control" id="listdate" name="listdate"  placeholder="Date"  value='<?php echo $row['listdate'];?>' >


                              
                            </div>
                               <div class="col-mb-12 py-4">
                                  <label for="Listtext">Text</label>
                             
                                     <textarea type="text" class="form-control" id="Listtext" name="listtext"  placeholder="Text Area" rows="3"  value='<?php echo $row['listtext'];?>' ></textarea>


                              
                            </div>
                             <div class="col-mb-12 py-4">
                                  <label for="Listtextarea">Link</label>
                             
                                     <input type="text" class="form-control" id="Listtextarea" name="listtextarea"  placeholder="Link"  value='<?php echo $row['listtextarea'];?>' >


                              
                            </div>

                               <?php if(isset($row['listimage']) && !empty($row['listimage'])){
                  ?>
                                    <img src="<?php echo $row['listimage']; ?>" alt="" height='150' width='150'><br>
                                    <a href="delprodulmg.php?id=<?php echo $row['list_id'];?>">Delete Image</a><br>

                                <?php
                            
                            }else{

 ?>
                                <div class="col-mb-6 py-4">
                                <label for="productimage" class="form-label">list Image</label>
                                <input class="form-control bg-dark" type="file" id="formFile" name="productimage" id="productimage">
                                <p class="">Only jpg/png are allowed.</p>
                            </div>
                            <?php
                            } ?>

                                <button type="submit"  name ='submit' value="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>




                  
                
                   

                </div>
                   </div>


            <!-- Form End -->


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">FANFAIR</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">FANFAIR</a>
                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->




        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>