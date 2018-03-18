<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-4 col-md-offset-4">
            <form>
                <div class="bs-example">

                    <?php if (!empty($questions)) {
                        foreach ($questions as $question) { ?>
                            <div class="form-group question" id="question<?php echo $question->id; ?>" question_id="<?php echo $question->id; ?>" answer_type="<?php echo $question->answer_type; ?>">
                                <label><?php echo $question->question_text; ?></label>
                                <?php if ($question->answer_type == 'checkbox' && !empty($question->answers)) {
                                    foreach ($question->answers as $answer) { ?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" answer_id="<?php echo $answer->id; ?>" name="answer[<?php echo $question->id; ?>][<?php echo $answer->id; ?>]"> <?php echo $answer->answer_text; ?>
                                    </label>
                                </div>
                                    <?php }
                                } elseif ($question->answer_type == 'radio' && !empty($question->answers)) {
                                    foreach ($question->answers as $answer) { ?>
                                        <input type="radio" answer_id="<?php echo $answer->id; ?>" name="answer[<?php echo $question->id; ?>][<?php echo $answer->id; ?>]"> <?php echo $answer->answer_text; ?>
                                    <?php }
                                } elseif ($question->answer_type == 'select' && !empty($question->answers)) { ?>
                                    <select  class="form-control" name="answer[<?php echo $question->id; ?>]" >
                                        <?php foreach ($question->answers as $answer) { ?>
                                            <option value="<?php echo $answer->id; ?>"><?php echo $answer->answer_text; ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } elseif ($question->answer_type == 'text') { ?>
                                    <input type="text" class="form-control" name="answer[<?php echo $question->id; ?>]" value="">
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <button class="btn btn-primary btn-lg btn-block" id="saveQuestions">Ответить</button>
                    <?php } else { ?>
                        <div> Вопросник пуст :)</div>
                    <?php } ?>
                </div>
        </div>
    </div>
    </form>
        </div>

</div>

</div>

<div class="toaster" id="snackbar">Ваш ответ отправлен</div>
<div class="toaster" id="snackbarError"></div>