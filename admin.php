<!DOCTYPE html>
<?php 
session_start();
require_once "connection.php";
 if (isset($_SESSION['admin'])==false){
       $_SESSION['admin']=null;
    }
    $select_projects ="SELECT * FROM projects";
    $list_projects = $konekcija->prepare($select_projects);
    $list_projects->execute();
    $projects = $list_projects->fetchAll();
    $projects = array_reverse($projects);
?>

<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">

<head>
    <title>MBstudio</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--iOS compatibile-->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="MBstudio">
    <link rel="apple-touch-icon" href="putanja do ikonice favicon li neke">

    <!--Android compatibile-->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="aplication-name" content="MBstudio">
    <link rel="icon" type="icon/png" href="putanja do ikonice favicon li neke">

    <!--FONTOVI-->
    <!--Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--bootstrap-->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />

    <!--external css, like plugins ...-->
    <link href="css/owl.carousel.css" rel="stylesheet" type="text/css" />

    <!--theme css-->
    <link href="css/theme.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light p-0">
                <h1>
                    <a class="navbar-brand text-uppercase" href="index.html">mb studio</a>
                    <a href="index.html" class="text-uppercase navbar-brand-info d-none d-md-inline-block">it's all
                        about design</a>
                </h1>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu"
                    aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="main-menu">
                    <ul class="navbar-nav ml-auto text-uppercase">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.html"><img class="home" src="img/icon_home-01.svg"></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="process.html">process</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="work.php">work</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="about.html">about</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">contact</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main>
    <?php if($_SESSION['admin']!= true):?>
            <div class="login-form">
            <form action="admin.php" id="login-form" method="post">
            <input type="text" name="username" placeholder="username" id="login-username">
            <input type="password" name="password" id="login-password">
            <input type="submit" name="submit_user" value="Log in" >
            </form>
            <?php if(isset($_POST['submit_user'])):?>
                <?php
                    $query_user ="SELECT * FROM users WHERE username=:username AND password=:password";
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $password = md5($password);
                    $stmt = $konekcija->prepare($query_user);
                            $stmt->bindParam(":username", $username);
                            $stmt->bindParam(":password", $password);
                            $stmt->execute();
                    $user = $stmt->fetch();
                    if($user!= false){
                        $_SESSION['admin']=true;
                        header('location:admin.php ');
                    }
                    else{
                        header('location:index.html ');
                    };
                ?>
                <?php endif;?>
        <?php else:?>
            <!-- Admin Panel -->
            <!-- creating new project -->
            <h3>Create a project</h3>
            <form action="admin.php" method="POST"name="project" id="project" enctype="multipart/form-data">
                <input type="text" name="project_name" placeholder="Project Name">
                <textarea id="content-textarea" placeholder="Write project content here" rows="4" cols="30" name="project_text"></textarea>
                <select name="project_category">
                    <option value="exterior">EXTERIOR</option>
                    <option value="interior">INTERIOR</option>
                    <option value="multi-residental">MULTI-RESIDENTAL</option>
                </select>
                <input type="text" name="project_year" placeholder="Project Year">
                <input type="file" name="project_image" accept="image/jpg,image/jpeg" /> 
                <input type="file" name="my_file[]" multiple>
                <input type="submit" name="project" value="Create project">
            </form>
                <?php if(isset($_POST['project'])):?>
                <?php   $heading = $_POST['project_name'];?>
                <?php if(strlen($heading)>0):?>
                    <?php  
                    //  featured
                     if(move_uploaded_file($_FILES['project_image']['tmp_name'], __DIR__.'/img/'.$_FILES['project_image']['name'])) { 
                    //    echo "File uploaded successfully!"; 
                       $image_path ='img/'. $_FILES['project_image']['name'];
                  
                      } else{ 
                        $image_path ='';
                      } 
                  
                    $content = $_POST['project_text'];
                    $category = $_POST['project_category'];
                    $year = $_POST['project_year'];
                    $query = "INSERT INTO projects (project_name,project_text,project_category,	project_year,project_image) VALUES (:name, :text,:category,:year,:project_image)";
                    $sth = $konekcija->prepare($query);
                    $sth->bindValue(':name', $heading);
                    $sth->bindValue(':text', $content);
                    $sth->bindValue(':category', $category);
                    $sth->bindValue(':year', $year);
                    $sth->bindValue(':project_image', $image_path);
                    $sth->execute();
                    ?>
                       <?php if (isset($_FILES['my_file'])):?> 
                    <?php   
                    
                    //  Gallery
                        $myFile = $_FILES['my_file'];
                        $fileCount = count($myFile["name"]);
                        $latest_id = "SELECT MAX(project_id) FROM projects";
                        $sth = $konekcija->prepare($latest_id);
                        $sth->execute();
                        $latest_id= $sth->fetchAll();
                        $latest_id = json_decode(json_encode($latest_id), True);
                        for ($i = 0; $i < $fileCount; $i++){
                            if(move_uploaded_file($myFile["tmp_name"][$i], __DIR__.'/img/'.$myFile["name"][$i])) { 
                                // echo "File uploaded successfully!"; 
                                $gallery_image_path ='img/'. $myFile["name"][$i];
                                $gallery = "INSERT INTO gallery (project_id,image_path) VALUES (:project_id, :image_path)";
                                $sth = $konekcija->prepare($gallery);
                                $sth->bindValue(':project_id', $latest_id[0]["MAX(project_id)"]);
                                $sth->bindValue(':image_path', $gallery_image_path);
                                $sth->execute();
                             
                               }
                              }
                     ?>
                      <script>
                        // refreshes page(better than header)
                        if ( window.history.replaceState ) {
                        window.history.replaceState( null, null, window.location.href );
                        }
                    </script>   
                     <?php endif;?>
                    
                    <?php else :?>
                            <p>Unesite ime projekta</p>
                    <?php endif; ?>            
                <?php endif;?>
                    <!-- end of creating new project -->
                    <!-- list of projects -->
                    <div class="list-of-projects">
                        <table class="projects-table">
                            <th>Project name</th>
                            <th>Project thumbnail</th>
                            <th>Edit/Remove</th>
                            <?php foreach ($projects as $project):?>
                            <tr>
                                <td><?php echo ($project->project_name);?></td>
                                <td><img height="50" width="50"src="<?php echo ($project->project_image);?>" alt=""></td>
                                <td><a href="edit.php?id=<?php echo $project->project_id;?>">Edit</a><a href="delete.php?id=<?php echo $project->project_id;?>">Remove</a></td>
                            <!-- <?php  echo '<pre>' , var_dump($project) , '</pre>';?> -->
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
        <?php endif;?>
      </div>
       
       
    </main>
    <footer>
        <div class="copyright">
            <p>
                Copyright © mbstudio.us. All rights reserved.
            </p>
        </div>
    </footer>
    <!--SCRIPTS goes here-->
    <!--First jquery, then popper and finaly bootstrap-->
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/popper.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>

    <script src="js/owl.carousel.js" type="text/javascript"></script>
    <script src="js/TweenMax.min.js" type="text/javascript"></script>
    <script src="js/ScrollMagic.js" type="text/javascript"></script>
    <script src="js/animation.gsap.js" type="text/javascript"></script>
    <script src="js/debug.addIndicators.js" type="text/javascript"></script>
    <!--All page js-->
    <script src="js/main.js" type="text/javascript"></script>
</body>

</html>