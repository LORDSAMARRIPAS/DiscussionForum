document.addEventListener("DOMContentLoaded", function() {
    var $_GET = {},
        args = location.search.substr(1).split(/&/);

    for (var i = 0; i < args.length; ++i) {
        var tmp = args[i].split(/=/);
        if (tmp[0] !== "") {
            $_GET[decodeURIComponent(tmp[0])] = decodeURIComponent(tmp.slice(1).join("").replace("+", " "));
        }
    }

    // JavaScript for getting posts from the database and displaying them
    var postsContainer = $("#posts");
    postsContainer.empty();

    // Fetch liked posts for the current user
    fetch("../php/getLikedPosts.php")
        .then(res => res.json())
        .then(likedPosts => {
            fetch("../php/home.php")
                .then(res => res.json())
                .then(data => {
                    if (data.length != 0) {
                        data.forEach(function(row) {
                            var postContainer = document.createElement("div");
                            postContainer.classList.add("post");
    
                            // Creating an anchor tag and setting its href attribute to the postPage.html with postId and forumname parameters
                            var postLink = document.createElement("a");
                            postLink.href = "postPage.html?postId=" + row['postid'] + "&forumname=" + row["forumname"];
                            postLink.classList.add("post-link"); // Add a class to the anchor tag for styling
                            postLink.innerHTML = "<h2>" + row['posttitle'] + "</h2><p>" + row['posttext'] + "</p>";
    
                            // Add like button with appropriate status
                            var likeButton = document.createElement("button");
                            likeButton.textContent = "Like";
    
                            // Check if the post has been liked by the user
                            var isLiked = likedPosts.find(post => post.postid === row.postid);
                            if (isLiked) {
                                likeButton.disabled = true; // Disable the like button if post is already liked
                            } else {
                                likeButton.addEventListener("click", function() {
                                    likePost(row['postid'], likeButton);
                                });
                            }
    
                            // Create a link to the forum page for the post
                            var forumLink = document.createElement("a");
                            forumLink.href = "forumPage.html?forumname=" + row["forumname"];
                            forumLink.textContent = 'In: ' + row["forumname"];
                            forumLink.classList.add("forum-link");
    
                            // Appending the anchor tag, forum link, and like button to the post container
                            postContainer.append(forumLink);
                            postContainer.append(postLink);
                            postContainer.append(likeButton);
                            postsContainer.append(postContainer);
                        });
                    }

                })
                .catch(error => {
                    console.error('Error fetching posts:', error);
                });
        })
        .catch(error => {
            console.error('Error fetching liked posts:', error);
        });
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
            if (data.message === "User not logged in.") {
                window.location.href = "../views/login.html";
            }
            console.error("Failed to like post:", data.message);
        }
    })
    .catch(error => {
        console.error('Error liking post:', error);
    });
}
