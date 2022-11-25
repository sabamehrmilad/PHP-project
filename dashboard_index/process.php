<?php



$mysqli=new mysqli('localhost','root','','things') or die($mysqli->error);

if(isset($_POST['save'])){
    $code=$_POST['code'];
    $title=$_POST['title'];
    $description=$_POST['description'];
    $user=$_POST['user'];
    $category=$_POST['category'];
    $branch=$_POST['branch'];
    $number=$_POST['number'];
    $file=$_FILES['image'];

    $filename=$_FILES['image']['name'];
    $fileTmpName=$_FILES['image']['tmp_name'];
    $fileSize=$_FILES['image']['size'];
    $fileError=$_FILES['image']['error'];
    $fileType=$_FILES['image']['type'];
    $file = $_FILES['image']['tmp_name']; 
    if($file!="")
    {
    $sourceProperties = getimagesize($file);
    $fileNewName = time();
    $folderPath = "../img/";
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageType = $sourceProperties[2];
    $fileSecondName=$fileNewName."_thump".'.'.$ext;
    switch ($imageType) {


        case IMAGETYPE_PNG:
            $imageResourceId = imagecreatefrompng($file); 
            $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
            imagepng($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
            break;


        case IMAGETYPE_GIF:
            $imageResourceId = imagecreatefromgif($file); 
            $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
            imagegif($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
            break;


        case IMAGETYPE_JPEG:
            $imageResourceId = imagecreatefromjpeg($file); 
            $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
            imagejpeg($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
            break;


        default:
            echo "Invalid Image type.";
            exit;
            break;
    }
    $mysqli->query("INSERT INTO things(code,title,Description,image,category,branch_id,user_id,numbers)VALUES ('$code','$title','$description','$fileSecondName','$category','$branch','$user','$number')") or die($mysqli->error);
    header("location:index.php");
}else{
    $mysqli->query("INSERT INTO things(code,title,Description,category,branch_id,user_id,numbers)VALUES ('$code','$title','$description','$category','$branch','$user','$number')") or die($mysqli->error);
    header("location:index.php");
}
    
}

    

    // $fileExt=explode('.',$filename);
    // $fileActualExt=strtolower(end($fileExt));

    // $allowed=array('jpg','jpeg','png');
    // if(in_array($fileActualExt,$allowed))
    // {
    //     if($fileError===0){
    //         if($fileSize<0.5){
    //              $fileDestination='../img/'.$filename;
    //              move_uploaded_file($fileTmpName,$fileDestination);

    //         }
    //         else{
    //             $_SESSION['message']="حجم فایل مورد نظر بالاست!";
    //             $_SESSION['msg_type']="danger";
                

    //         }

    //     }else{
    //         $_SESSION['message']="مشکلی در آپلود فایل وجود دارد!";
    //         $_SESSION['msg_type']="danger";
            
    //         }
    // }else
    // {
    //     $_SESSION['message']="عکسی آپلود نشد یا مشکلی در فرمت فایل وجود دارد !";
    //     $_SESSION['msg_type']="danger";
        


    // }

    

    




if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   $mysqli->query("DELETE FROM things WHERE id=$id") or die($mysqli->error);
   $_SESSION['message']="کالا مورد نظر حذف شد!";
   $_SESSION['msg_type']="danger";
   header("location:index.php");

}

//if(isset($_GET['sync'])) {
//    $id = $_GET['sync'];
//    $result = $mysqli->query("SELECT * FROM events WHERE id='$id'") or die($mysqli->error());
//    if (count(array($result)) == 1) {
//        require_once 'jdf.php';
//        $row = $result->fetch_array();
//        $title = $row['day_title'];
//        $year = $row['year_num'];
//        $month = $row['month_num'];
//        $day = $row['day_num'];
//        $day_type = $row['if_off'];
//        $description = $row['description'];
//        $later_year=$year+1;
//        $mysqli->query("UPDATE events SET day_title='$title'  ,year_num='$later_year'  ,month_num='$month'  ,day_num='$day'  ,description='$description'   ,if_off='$day_type' WHERE id='$id'")or die($mysqli->error);
//        $_SESSION['message']="تاریخ مورد نظر ویرایش شد!";
//        $_SESSION['msg_type']="warning";
//        header("location:index.php");
//
//    }
//}

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $code=$_POST['code'];
    $title=$_POST['title'];
    $Description=$_POST['description'];
    $user=$_POST['user'];
    $branch=$_POST['branch'];
    $numbers=$_POST['number'];
    $category=$_POST['category'];
    $file=$_FILES['image'];
    $filename=$_FILES['image']['name'];
    $fileTmpName=$_FILES['image']['tmp_name'];
    $fileSize=$_FILES['image']['size'];
    $fileError=$_FILES['image']['error'];
    $fileType=$_FILES['image']['type'];
    $file= $_FILES['image']['tmp_name']; 
    if ($file!=""){
    $sourceProperties = getimagesize($file);
    $fileNewName = time();
    $folderPath = "../img/";
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageType = $sourceProperties[2];
    $fileSecondName=$fileNewName."_thump".'.'.$ext;
        switch ($imageType) {

            case IMAGETYPE_PNG:
                $imageResourceId = imagecreatefrompng($file); 
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagepng($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;
    
    
            case IMAGETYPE_GIF:
                $imageResourceId = imagecreatefromgif($file); 
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagegif($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;
    
    
            case IMAGETYPE_JPEG:
                $imageResourceId = imagecreatefromjpeg($file); 
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagejpeg($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;
    
    
            default:
                echo "Invalid Image type.";
                exit;
                break;
        }

        $mysqli->query("UPDATE things SET code='$code'  ,title='$title'  ,Description='$Description'  ,image='$fileSecondName'  ,category='$category'   ,numbers='$numbers',user_id='$user',branch_id='$branch' WHERE id='$id'")or die($mysqli->error);
        header("location:index.php");
    }else{
        $mysqli->query("UPDATE things SET code='$code'  ,title='$title'  ,Description='$Description'    ,category='$category'   ,numbers='$numbers',user_id='$user',branch_id='$branch' WHERE id='$id'")or die($mysqli->error);
        header("location:index.php");
    }
      



    
}


//        $c_update="update things set customer_name='$c_name', customer_email='$c_email', customer_pass='$c_pass',  customer_image= '$c_image'
//     where customer_id='$customer_id'";
//     }else
//     {
//         $mysqli->query("UPDATE things SET code='$code'  ,title='$title'  ,Description='$Description'    ,category='$category'   ,numbers='$numbers',user_id='$user',branch_id='$branch' WHERE id='$id'")or die($mysqli->error);


//     }
//     $_SESSION['message']="کالا مورد نظر ویرایش شد!";
//     $_SESSION['msg_type']="warning";
// }



if (isset($_POST['report']))
{
   $id = $_POST['id'];
   $report = $_POST['report_text'];
   $number=$_POST['number'];
   $changed_number=$_POST['changed_number'];
   $category=$_POST['category'];
   $remainder=$number-$changed_number;
   $mysqli->query("INSERT INTO report(report,number,changed_number,things_id,category)VALUES ('$report','$remainder','$changed_number','$id','$category')") or die($mysqli->error);
   $mysqli->query("UPDATE things SET numbers='$remainder' WHERE id=$id") or die($mysqli->error);

    header("location:index.php");


}
function imageResize($imageResourceId,$width,$height) {


    $targetWidth =200;
    $targetHeight =200;


    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);


    return $targetLayer;
}
