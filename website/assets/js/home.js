(function($) {
    var myInputs = localStorage.getItem("myInputs");
    setAllStorage();
    $('#saveQuestions').click(function (e) {
        e.preventDefault();
        var input_data  = $('form').serializeArray();

        $.ajax({
            url: "home/saveResult",
            data: input_data,
            type: 'POST',
            success: function(result){
                result = JSON.parse(result);

                if(result.result) {
                    myFunction('success');
                } else {
                    myFunction('error', result.message);
                }

            }
        });
    });

    $('input, select').change(function () {
        localStorage.clear();
        var input_data  = $('form').serializeArray();

        $.each(input_data, function (k, v) {
            localStorage.setItem(v.name, v.value);
        });

    });

    function myFunction(mesType, message) {

        if(mesType == 'success') {
            var x = document.getElementById("snackbar");
        } else {
            var x = document.getElementById("snackbarError");
        }

        if(message){
            x.innerHTML = message;
        }

        x.className = "show toaster";
        setTimeout(function(){ x.className = x.className.replace("show toaster", "hidden"); }, 3000);
    }

    function setAllStorage() {

        var archive = {}, // Notice change here
            keys = Object.keys(localStorage),
            i = keys.length;

        while ( i-- ) {
            archive[ keys[i] ] = localStorage.getItem( keys[i] );
            var answer_type = $('input[name="'+ keys[i] + '"]').closest('.question').attr('answer_type');
            if(typeof answer_type == 'undefined'){
                answer_type = $('select[name="'+ keys[i] + '"]').closest('.question').attr('answer_type');
            }

            if (answer_type == 'select'){
                $('select[name="'+  keys[i] + '"]').val(localStorage.getItem( keys[i] ));
            } else if (answer_type == 'checkbox' ){
                $('input[name="'+  keys[i] + '"]').prop('checked', true);
            } else {
                $('input[name="' + keys[i] + '"]').val(localStorage.getItem(keys[i]));
            }
        }

        return archive;
    }

})(jQuery);