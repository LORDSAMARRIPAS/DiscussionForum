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

    document.getElementById("posttitle").textContent = $_GET["postId"];
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
            var titleEl = document.createElement("h2");
            titleEl.textContent = row['posttitle'];
            var textEl = document.createElement("p");
            textEl.textContent = row['posttext'];
            pst.appendChild(titleEl);
            pst.appendChild(textEl);
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
            var userEl = document.createElement("h2");
            userEl.textContent = row['username'];
            var msgEl = document.createElement("p");
            msgEl.textContent = row['messagetext'];
            comment.appendChild(userEl);
            comment.appendChild(msgEl);
            comments.append(comment); 
        });
    });
}