$(document).ready(function() {
    var $input = $('input[type="search"]');

    $input.on('input', function() {
        var query = $(this).val();

        // Perform AJAX request to get search results
        $.ajax({
            url: '../scripts/search_script.php',
            type: 'GET',
            data: { search: query },
            success: function(data) {
                // Process the results
                // For example, if you're returning HTML:
                $('.search-results').html(data);
                // If you're returning JSON, you'll need to parse it and build the HTML
            }
        });
    });
});
