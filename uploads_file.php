<?php
//Thư mục bạn sẽ lưu file upload
$thu_muc    = "uploads_file/";
//Vị trí file lưu tạm trong server
$vitri_file_luutam   = $thu_muc . basename($_FILES["fileupload"]["name"]);
$chophep_Upload   = true;
//Lấy phần mở rộng của file
$imageFileType = pathinfo($vitri_file_luutam,PATHINFO_EXTENSION);
$chophep_Upload_kichthuoc_file   = 800000; //(bytes)
////Những loại file được phép upload
$allowtypes    = array('jpg', 'png', 'jpeg', 'gif');


if(isset($_POST["submit"])) {
    //Kiểm tra xem có phải là ảnh
    $check = getimagesize($_FILES["fileupload"]["tmp_name"]);
    if($check !== false) {
        echo "Đây là file ảnh - " . $check["mime"] . ".";
        $chophep_Upload = true;
    } else {
        echo "Không phải file ảnh.";
        $chophep_Upload = false;
    }
}

// Kiểm tra nếu file đã tồn tại thì không cho phép ghi đè
if (file_exists($vitri_file_luutam)) {
    echo "File đã tồn tại.";
    $chophep_Upload = false;
}
// Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
if ($_FILES["fileupload"]["size"] > $chophep_Upload_kichthuoc_file)
{
    echo "Không được upload ảnh lớn hơn $chophep_Upload_kichthuoc_file (bytes).";
    $chophep_Upload = false;
}


// Kiểm tra kiểu file
if (!in_array($imageFileType,$allowtypes ))
{
    echo "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF";
    $chophep_Upload = false;
}

// Kiểm tra xem $ uploadOk có được đặt thành 0 do lỗi không
if ($chophep_Upload) {
    if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $vitri_file_luutam))
    {
        echo "File ". basename( $_FILES["fileupload"]["name"]).
        " Đã upload thành công";
    }
    else
    {
        echo "Có lỗi xảy ra khi upload file.";
    }
}
else
{
    echo "Không upload được file!";
}
?>

<form method="post" enctype="multipart/form-data">
  <p>Chọn file để upload:
    (Cỡ lớn nhất mà PHP đang cấu hình cho phép upload là
    <?=ini_get('upload_max_filesize')?>)</p>

    <input name="fileupload" type="file" multiple="multiple" />
    <input type="submit" value="Đăng ảnh" name="submit">
</form>