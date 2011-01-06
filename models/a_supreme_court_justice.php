<?php

class ASupremeCourtJustice {
    private $id;
    private $first_name;
    private $last_name;
    private $appt_by;
    private $first_day;
    private $birthday;

    function __construct($properties) {
        $this->id = $properties['id'];
        $this->first_name = $properties['first_name'];
        $this->last_name = $properties['last_name'];
        $this->appt_by = $properties['appt_by'];
        $this->first_day = $properties['first_day'];
        $this->birthday = $properties['birthday'];
    }


    public function get_id() {
        return $this->id;
    }

    public function get_first_name() {
        return $this->first_name;
    }

    public function get_last_name() {
        return $this->last_name;
    }

    public function get_appointed_by() {
        return $this->appt_by;
    }

    public function get_first_year() {
        return date('Y', strtotime($this->first_day));
    }

    public function get_full_name() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function get_age() {
        $diff = time() - strtotime($this->birthday);
        return floor($diff / SECONDS_IN_A_YEAR);
    }

    public function get_birthday() {
        return date('m/d/Y', strtotime($this->birthday));
    }

    // given a question id, returns the correct field to answer the question
    public function get_question_answer($question_id) {
        switch ($question_id) {
            case  APPOINTED_QUESTION:
                return $this->get_appointed_by();
            case AGE_QUESTION:
                return $this->get_age();
            case FIRST_YEAR_QUESTION:
                return $this->get_first_year();
            default:
                throw new Exception('Bad question id.');
        }
    }
}

?>