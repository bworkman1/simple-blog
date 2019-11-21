var app = {
    base_url: '',

    init: function() {
        app.submitNewBlogPost();
        app.base_url = $('body').attr('data-base');
    },
    
    submitNewBlogPost: function () {
        $('#submitBlogPostBtn').click(function (e) {
            e.preventDefault();
            app.resetNewBlogPostForm();

            // Send a post request to the server to save it
            $.post(app.base_url + '/index.php/add-post', $('#newBlogPostForm').serialize(), function(res) {
                if(res.success) {
                    $('#form-feedback').html(res.msg).addClass('text-success');
                    window.location.replace(app.base_url + '/index.php/post?id=' + res.data.post_id);
                } else {
                    app.showFormErrors(res.data);
                }
            }, 'json');
        });
    },

    resetNewBlogPostForm: function () {
        $('#form-feedback').html('').removeAttr('class');
        $('.is-invalid').removeClass('is-invalid');
        $('.inputHelper').html('');
    },

    showFormErrors: function(inputs) {
        if(typeof inputs != null) {
            for(let i in inputs) {
                $('#' + i).addClass('is-invalid').parent().find('.inputHelper').html(inputs[i]);
            }
        }
    }

}

$(function() {
   app.init();
});


