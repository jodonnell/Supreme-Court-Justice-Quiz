<?php

class Question {
    private $question; // This should be a formattable string with one string(the justice name) in it.
    private $justice_name;
    private $question_id;

    function __construct($question_id, $question, $justice_name) {
        $this->question = $question;
        $this->justice_name = $justice_name;
        $this->question_id = $question_id;
    }

    public function get_question() {
        return sprintf($this->question, $this->justice_name);
    }

    public function get_question_id() {
        return $this->question_id;
    }
}

?>