<?php
require_once '../php/connection.php';
session_start();

if(!isset($_SESSION['username'])){
    header("location: ../views/login.html");
    exit();
}else{
    $username = $_SESSION['username'];
}
if($_SERVER['REQUEST_METHOD'] != 'GET' || !isset($_GET['forumname'])){
    header("location: ../views/Home.html");
    exit();
}
$forumname = $_GET['forumname'];
$pdo = connectdb();
$sql = "SELECT siteadmin FROM users WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
if($stmt->fetch()['siteadmin'] != 1){
    $sql = "SELECT isadmin FROM inforum WHERE forumname = ? AND username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$forumname, $username]);
    if($user = $stmt->fetch()){
        if($user['isadmin'] != 1){
            header("location: ../views/Home.html");
            exit();
        }
    }
    else{
        header("location: ../views/Home.html");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous"/>   
    <script src="../scripts/dynamic-navbar.js"></script>
    <div id="navbar"></div>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="../scripts/jquery-3.1.1.min.js"></script>
    <script type="text/javascript">

    </script>

    <title><?php $forumname ?> Admin</title>
</head>
<body>

    <header>
        <h1 style="display: inline;" id="forum-name"><?php echo "<a href='forumPage.html?forumname=$forumname'>$forumname</a>" ?> Admin</h1>
        <form method="post" action="../php/deleteForum.php">
            <input type="hidden" id="forumname" name="forumname" value="<?php echo $forumname ?>">
            <button type="submit" id="delete-button" class="button" onclick="return confirm('Are you sure you want to delete this forum?')">Delete</button>
        </form>
        <div class="clearfix"></div>
    </header>
    <main>
        <div id="posts">
        <table>
            <tr>
                <th>Post ID</th>
                <th>User name</th>
                <th>Forum name</th>
                <th>Post Title</th>
                <th>Post Text</th>
                <th>Post Date</th>
            </tr>

            <?php 
            $sql = "SELECT postid, username, posttitle, posttext, postdate FROM posts WHERE forumname = ? ORDER BY postdate DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$forumname]);
            while ($row = $stmt->fetch()) {
                $postid = $row["postid"];
                echo "<tr>";
                echo "<td>$postid</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $forumname . "</td>";
                echo "<td>" . $row["posttitle"] . "</td>";
                echo "<td>" . $row["posttext"] . "</td>";
                echo "<td>" . $row["postdate"] . "</td>";
                echo "<td> <form method='post' action='../php/deletePost.php'>
                    <input type='hidden' name='forumname' value='$forumname'>
                    <input type='hidden' name='postid' value='$postid'>
                    <button type='submit' class='delete-post button' onclick='return confirm(\"Are you sure you want to delete this post?\")'>Delete</button>
                    </form></td>";
                echo "</tr>";
            }
            ?>

        </table>
        </div>
    </main>

 <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha384-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
