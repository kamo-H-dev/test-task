
<div class="container">
    <div class="row">
        <table class="table table-striped table-bordered dataTable answerResults text-center">
            <thead>
                <th> IP </th>
                <?php foreach ($questions as $question) { ?>
                <th> Результат <?php echo $question->id; ?>  вопроса (<?php echo $question->question_text; ?> )</th>
                <?php } ?>
                <th> Количество отправок теста </th>
                <th> Удалить </th>
            </thead>

            <tbody>
                <?php foreach ($userAnswers as $answer) { ?>
                    <tr user_ip="<?php echo $answer['userIp'] ?>"  answer_date="<?php echo $answer['answerDate'] ?>" >
                        <td><?php echo $answer['userIp'] ?></td>
                    <?php foreach ($answer['answersRes'] as $questAnswer) { ?>
                        <td> <?php echo $questAnswer['questionAnswer'] ?></td>
                    <?php } ?>
                        <td> <?php echo $answer['count'] ?> </td>
                        <td> <button class="btn btn-danger removeResult">-</button> </td>
                    </tr>
                <?php } ?>

            </tbody>

        </table>
    </div>
</div>

<div id="canvas-holder" style="width:40%">
    <canvas id="myChart"></canvas>
</div>



<div class="toaster" id="snackbar">Столбец успешно удалён!</div>
<script>
    var statistic = <?php echo json_encode($statistic); ?>;
    var countSum = <?php echo $totalCount; ?>;
</script>
