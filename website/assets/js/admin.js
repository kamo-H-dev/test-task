(function($) {
    var table = $('.answerResults').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv'
        ],
        "bAutoWidth": false,
        "sPaginationType": "simple_numbers"
    });
    $('.answerResults').data('table', table);

    var allCount = [];
    var labels = [];

    $.each(statistic, function (key, value) {
        allCount.push(value.count*100/countSum);
        labels.push(value.question_text);
    });
    var ctx = document.getElementById("myChart").getContext('2d');

    var config = {
        type: 'pie',
        data: {
            datasets: [{
                data: allCount,
                backgroundColor: [
                    'rgba(255, 0, 0, 0.5)',
                    'rgba(0, 255, 0, 0.5)',
                    'rgba(0, 0, 255, 0.5)'
                ],
                label: 'Dataset 1'
            }],
            labels: labels
        },
        options: {
            responsive: true
        }
    };

    var myChart = new Chart(ctx,config);

    $(document.body).undelegate('.removeResult', "click").delegate('.removeResult', "click", function(e) {
        e.preventDefault();
        var tableRow =  $(this).closest('tr');
        var user_ip = $(this).closest('tr').attr('user_ip');
        var answer_date = $(this).closest('tr').attr('answer_date');
        $.ajax({
            url: "admin/removeAnswer",
            data: {user_ip:user_ip, answer_date:answer_date},
            type: 'POST',
            success: function(result) {
                result = JSON.parse(result);

                if(result.result == true) {
                    tableRow.remove();
                    myFunction()
                }
            }
        });

    });

    function myFunction() {
        var x = document.getElementById("snackbar");
        x.className = "show toaster";
        setTimeout(function(){ x.className = x.className.replace("show toaster", "hidden"); }, 3000);
    }

})(jQuery);