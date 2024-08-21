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
        window.location.href = "../views/Home.html"
    }
    document.getElementById("forum-name").innerHTML = $_GET["forumname"];
    document.getElementById("forumname").value = $_GET["forumname"];


    // JavaScript for getting posts from the database and displaying them
    postsContainer = $("#posts");
    postsContainer.empty();

    fetch("../php/getPosts.php?forumname=" + $_GET["forumname"])
        .then(res => res.json())
        .then(data => {
            if (data.length != 0) {
                data.forEach(function(row) {
                    var postContainer = document.createElement("div");
                    postContainer.classList.add("post");
    
                    // Creating an anchor tag and setting its href attribute to the postPage.html with postId and forumname parameters
                    var postLink = document.createElement("a");
                    postLink.href = "postPage.html?postId=" + row['postid'] + "&forumname=" + $_GET["forumname"];
                    postLink.classList.add("post-link"); // Add a class to the anchor tag for styling
                    postLink.innerHTML = "<h2>" + row['posttitle'] + "</h2><p>" + row['posttext'] + "</p>";
    
                    // Add like button with appropriate status
                    var likeButton = document.createElement("button");
                    likeButton.textContent = "Like";
                    likeButton.disabled = row['liked']; // Disable the like button if post is already liked
                    likeButton.dataset.postid = row['postid']; // Store post ID as a data attribute
                    likeButton.addEventListener("click", function() {
                        likePost(row['postid'], likeButton);
                    });
    
                    // Appending the anchor tag and like button to the post container
                    postContainer.append(postLink);
                    postContainer.append(likeButton);
                    postsContainer.append(postContainer);
                });
            }

        })
        .catch(error => {
            console.error('Error fetching posts:', error);
        });
        fetch("../php/getInForum.php")
        .then(res => res.json())
        .then(data => {
            var inforum = false;
            if(data[0]!=0){
                data.forEach(function(row) {
                    if(row['forumname'] == $_GET["forumname"]){
                        inforum = true;
                    }
                });
            }
            if(!inforum){
                document.getElementById("join-button").innerHTML = "<a class='button' href='../php/joinForum.php?forumname="+$_GET["forumname"]+"'>Join</a>";
            }else{
                document.getElementById("join-button").innerHTML = "<a class='button' href='../php/leaveForum.php?forumname="+$_GET["forumname"]+"'>Leave</a>";
            }
        });
        // JavaScript for getting admin status and displaying link to admin page
        fetch("../php/getAdmin.php?forumname="+$_GET["forumname"])
        .then(res => res.json())
        .then(data => {
            if(data[0]!=0){
                document.getElementById("admin-link").innerHTML = "<a class='button' href='../views/forumAdmin.php?forumname="+$_GET["forumname"]+"'>Admin</a>";
            }
        });
    
            
    
        // JavaScript for getting posts from database and displaying them
        refreshPosts();
    
        setInterval(refreshPosts, 5000);
});

function likePost(postId, likeButton) {
    fetch("../php/likePost2.php", {
        method: 'POST',
        body: JSON.stringify({ postId: postId }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log("Post liked successfully");
            // Disable the like button after liking the post
            likeButton.disabled = true;
        } else {
            if(data.message === "User not logged in.") {
                window.location.href = "../views/login.html";
            }
            console.error("Failed to like post:", data.message);
        }
    })
    .catch(error => {
        console.error('Error liking post:', error);
    });
}


function refreshPosts(){
        // JavaScript for getting posts from database and displaying them
        postsContainer = $("#posts");
        fetch("../php/getPosts.php?forumname=" + $_GET["forumname"])
        .then(res => res.json())
        .then(data => {
            postsContainer.empty();
            data.forEach(function(row) {
                var postContainer = document.createElement("div");
                postContainer.classList.add("post");

                // Creating an anchor tag and setting its href attribute to the postPage.html with postId and forumname parameters
                var postLink = document.createElement("a");
                postLink.href = "postPage.html?postId=" + row['postid'] + "&forumname=" + $_GET["forumname"];
                postLink.classList.add("post-link"); // Add a class to the anchor tag for styling
                postLink.innerHTML = "<h2>" + row['posttitle'] + "</h2><p>" + row['posttext'] + "</p>";

                // Add like button with appropriate status
                var likeButton = document.createElement("button");
                likeButton.textContent = "Like";
                likeButton.disabled = row['liked']; // Disable the like button if post is already liked
                likeButton.dataset.postid = row['postid']; // Store post ID as a data attribute
                likeButton.addEventListener("click", function() {
                    likePost(row['postid'], likeButton);
                });

                // Appending the anchor tag and like button to the post container
                postContainer.append(postLink);
                postContainer.append(likeButton);
                postsContainer.append(postContainer);
            });
        });
}