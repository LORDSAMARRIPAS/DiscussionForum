function getErrors(){
    // get query arguments
    var $_GET = {},
    args = location.search.substr(1).split(/&/);
    for (var i=0; i<args.length; ++i) {
        var tmp = args[i].split(/=/);
        if (tmp[0] != "") {
            $_GET[decodeURIComponent(tmp[0])] = decodeURIComponent(tmp.slice(1).join("").replace("+", " "));
        }
    }
    if($_GET['errors']==1){
        fetch("../php/getSession.php")
        .then(res => res.json())
        .then(data => {
            for(var key in data['errors']){
                $('#'+key).after('<p class="error">' + data['errors'][key] + '</p>');
            }
        });
    }
    
}