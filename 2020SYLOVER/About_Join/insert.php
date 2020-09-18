<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if ((($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android) {

        // 안드로이드 코드의 postParameters 변수에 적어준 이름을 가지고 값을 전달 받습니다.

        $id=$_POST['id'];
        $password=$_POST['password'];
        $name=$_POST['name'];
        $subname=$_POST['subname'];
        $age=$_POST['age'];

        if (empty($id)) {
            $errMSG = "아이디를 입력하세요.";
        } elseif (empty($password)) {
            $errMSG = "비밀번호를 입력하세요.";
        } elseif (empty($name)) {
            $errMSG = "이름을 입력하세요.";
        } elseif (empty($subname)) {
            $errMSG = "닉네임을 입력하세요.";
        } elseif (empty($age)) {
            $errMSG = "나이를 입력하세요.";
        }

        if (!isset($errMSG)) { // 이름과 나라 모두 입력이 되었다면
            try {
                // SQL문을 실행하여 데이터를 MySQL 서버의 person 테이블에 저장합니다.
                $stmt = $con->prepare('INSERT INTO syuserlist(id, password, name, subname, age) VALUES(:id, :password, :name, :subname, :age)');
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':subname', $subname);
                $stmt->bindParam(':age', $age);

                if ($stmt->execute()) {
                    $successMSG = "새로운 사용자를 추가했습니다.";
                } else {
                    $errMSG = "사용자 추가 에러";
                }
            } catch (PDOException $e) {
                die("Database error: " . $e->getMessage());
            }
        }
    }

?>


<?php
    if (isset($errMSG)) {
        echo $errMSG;
    }
    if (isset($successMSG)) {
        echo $successMSG;
    }

   $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

    if (!$android) {
        ?>
    <html>
       <body>

            <form action="<?php $_PHP_SELF ?>" method="POST" >
                아이디: <input type = "text" name = "id" />
                비밀번호: <input type = "text" name = "password" />
                이름: <input type = "text" name = "name" />
                닉네임: <input type = "text" name = "subname" />
                나이: <input type = "text" name = "age" />
                <input type = "submit" name = "submit" />
            </form>

       </body>
    </html>

<?php
    }
?>
