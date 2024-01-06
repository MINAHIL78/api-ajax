function loadContent(page) {
    $.ajax({
        url: page,
        type: 'GET',
        success: function(data) {
            $('#main-content').html(data);
        },
        error: function() {
            alert('Error loading content.');
        }
    });
}
