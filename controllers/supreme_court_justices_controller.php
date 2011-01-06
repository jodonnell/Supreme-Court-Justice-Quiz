<?php

define('AGE_QUESTION', 0);
define('APPOINTED_QUESTION', 1);
define('FIRST_YEAR_QUESTION', 2);

define('NUM_INCORRECT_ANSWERS', 3);

define('SECONDS_IN_A_YEAR', 31557600);


class SupremeCourtJusticesController extends AppController {
    var $name = 'SupremeCourtJustices';

    function view_source() {
    }

    function name_quiz() {
        App::import('model', 'a_supreme_court_justice');

        $supreme_court_justices = array();
        foreach ($this->SupremeCourtJustice->find('all') as $supreme_court_justice_model)
            $supreme_court_justices[] = new ASupremeCourtJustice($supreme_court_justice_model['SupremeCourtJustice']);

        $this->set('supreme_court_justices', $supreme_court_justices);
    }

    function trivia_quiz() {
        App::import('model', 'question');
        App::import('model', 'a_supreme_court_justice');
 
        $rand_justice = get_random_justice($this->SupremeCourtJustice);
        $question = get_random_question($rand_justice);

        $answer = $rand_justice->get_question_answer($question->get_question_id());
        $choices = array($answer => $answer);

        get_incorrect_answers($this->SupremeCourtJustice, $rand_justice, $question, $choices);
        shuffle_assoc($choices);

        $this->set('question', $question);
        $this->set('choices', $choices);
        $this->set('question_id', $question->get_question_id());
        $this->set('justice_id', $rand_justice->get_id());

        if (!empty($this->data)) {
            $questions = get_questions();
            $justice = get_justice_by_id($this->SupremeCourtJustice, $this->data['justice_id']);
            $old_question = new Question($this->data['question_id'], $questions[$this->data['question_id']], $justice->get_full_name());
            $question_answer = $justice->get_question_answer($old_question->get_question_id());
            
            $correct = is_answer_correct($question_answer, $this->data['answers']);

            $this->set('correct', $correct);
            $this->set('old_question', $old_question->get_question());
            $this->set('old_answer', $question_answer);
        }
    }
}

function is_answer_correct($correct_answer, $guessed_answer) {
    $correct = false;
    if ($correct_answer == $guessed_answer)
        $correct = true;
    return $correct;
}

function get_justice_by_id($supreme_court_justice_model, $justice_id) {
    $justice_model = $supreme_court_justice_model->find('first', array('conditions' => array('SupremeCourtJustice.id' => $justice_id)));
    return new ASupremeCourtJustice($justice_model['SupremeCourtJustice']);
}

// Modifies the choices array.
function get_incorrect_answers($supreme_court_justice_model, $correct_justice, $question, &$choices) {
    $incorrect_justices = $supreme_court_justice_model->find('all', array('order' => 'rand()', 'limit' => NUM_INCORRECT_ANSWERS, 
                                                                          'conditions' => array("SupremeCourtJustice.id <>" => $correct_justice->get_id())));

    foreach ($incorrect_justices as $incorrect_justice) {
        $wrong_justice = new ASupremeCourtJustice($incorrect_justice['SupremeCourtJustice']);
        $wrong_answer = $wrong_justice->get_question_answer($question->get_question_id());
        $choices[$wrong_answer] = $wrong_answer;
    }
}

function get_random_question($justice) {
    $questions = get_questions();
    $question_id = array_rand($questions);
    return new Question($question_id, $questions[$question_id], $justice->get_full_name());
}

function get_questions() {
    return array(AGE_QUESTION => "What is %s's age?", APPOINTED_QUESTION => 'Who appointed %s?', 
                 FIRST_YEAR_QUESTION  => 'What year did %s become a Supreme Court Justice?');
}

function get_random_justice($supreme_court_justice_model) {
    $rand_justice_model = $supreme_court_justice_model->find('first', array('order' => 'rand()'));
    return new ASupremeCourtJustice($rand_justice_model['SupremeCourtJustice']);
}

// Shuffles an array without losing the keys, modifies the array.
function shuffle_assoc(&$array) {
    $keys = array_keys($array);
    shuffle($keys);
    
    foreach ($keys as $key)
        $new[$key] = $array[$key];

    $array = $new;
}

?>