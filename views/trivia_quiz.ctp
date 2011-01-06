<?php 
include('header.ctp');

if (isset($correct)) {
    if ($correct)
        echo "Correct. ";
    else
        echo "Incorrect. ";

    echo $old_question . " " . $old_answer . ".";
    echo '<br /><br />';
}

echo $question->get_question();
echo '<br />';

echo $form->create(false, array('action' => 'trivia_quiz'));
echo $form->input('answers', array('type' => 'radio', 'options' => $choices));
echo $form->hidden('question_id', array('value' => $question_id));
echo $form->hidden('justice_id', array('value' => $justice_id));
echo $form->end('Submit');

?>
