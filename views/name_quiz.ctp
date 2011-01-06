<?php
include('header.ctp');
?>


<script type="text/javascript">

var justices = new Array(

<?php 

$all_justices = array();
foreach ($supreme_court_justices as $supreme_court_justice)
    $all_justices[] =  sprintf('"%s"', $supreme_court_justice->get_full_name());

echo join($all_justices, ',');

?>

);

var time = 0; // Keeps track of time after page load in tenths of seconds.
var timer; // The window timer object.

function updateTimer() {
    time++;
    document.getElementById('time').innerHTML = time;
    timer = setTimeout("updateTimer()", 1000);
}
window.onload = updateTimer;


function addToGuessedJusticeHTML(guessed_justice) {
    document.getElementById('guessed_justices').innerHTML += guessed_justice + ', ';
}

function clearGuessingInput() {
    document.getElementById('guess_input').value = '';
}

function updateNumJusticesLeftHTML(new_length) {
    document.getElementById('num_justices_left').innerHTML = new_length;
}

function checkForJustice(guess) {
    for (key in justices) {
        if (guess.toLowerCase() == justices[key].toLowerCase()) {
            addToGuessedJusticeHTML(justices[key]);
            clearGuessingInput();
            justices.splice(key, 1);
            updateNumJusticesLeftHTML(justices.length);

            if (!justices.length) {
                document.getElementById('inner_content').innerHTML = 'You got them all in ' + time + ' seconds.';
                clearTimeout(timer);
            }
            
            break;
        }
    }
}
</script>

<div id="inner_content">

    Your time: <span id="time">0</span> seconds
    <br />

    
    <br />
    Enter the first and last name of a Supreme Court Justice. If it's correct it will automatically submit.
    <input id="guess_input" type="text" value="" onkeyup="checkForJustice(this.value);">
    <br />

    <span id="num_justices_left"><?php echo count($supreme_court_justices); ?></span> 
    Supreme Court Justice<?php if (count($supreme_court_justices) > 1) echo 's';?> left.
    <br /><br />
    Named so far: <br />
    <div id="guessed_justices"></div>

</div>
