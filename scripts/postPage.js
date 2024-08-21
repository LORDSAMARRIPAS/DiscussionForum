var $_GET = {},
args = location.search.substr(1).split(/&/);
document.addEventListener("DOMContentLoaded", function() {
    for (var i=0; i<args.length; ++i) {
        var tmp = args[i].split(/=/);
        if (tmp[0] != "") {
            $_GET[decodeURIComponent(tmp[0])] = decodeURIComponent(tmp.slice(1).join("").replace("+", " "));
        }
    }
    if ($_GET["forumname"] == null) {
        window.location.href = "../views/accountPage.html"
    }

    document.getElementById("posttitle").innerHTML = $_GET["postId"];
    document.getElementById("postId").value = $_GET["postId"];
    document.getElementById("forumname").value = $_GET["forumname"];

    // JavaScript for getting posts from database and displaying them
    var post = $("#post");
    post.empty();
    fetch("../php/getPost.php?postId=" + $_GET["postId"])
    .then(res => res.json())
    .then(data => {
        if(data[0]==0){
            window.location.href = "../views/Home.html";
        }
        data.forEach(function(row) {
            console.log(row['posttitle']);
            var pst = document.createElement("div");
            pst.classList.add("post");
            pst.innerHTML = "<h2>" + row['posttitle'] + "</h2><p>" + row['posttext'] + "</p>";
            post.append(pst);
        });
    });

    refreshComments();
    
    setInterval(refreshComments, 2000);

});

function refreshComments() {
    var comments = $("#comments");

    fetch("../php/getComments.php?postId=" + $_GET["postId"])
    .then(res => res.json())
    .then(data => {
        comments.empty();
        if(data[0]==0){
            window.location.href = "../views/Home.html";
        }
        data.forEach(function(row) {
            var comment = document.createElement("div");
            comment.classList.add("post");
            comment.innerHTML = "<h2>" + row['username'] + "</h2><p>" + row['messagetext'] + "</p>";
            comments.append(comment); 
        });
    });
}