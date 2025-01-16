TOMARAO EXAMINATION PROJECT 6

Use XAMPP for PHP and mySQL
- Create a database with adminexam and tomarao_examination. *change it later*
- import adminexam.sql or .csv to adminexam database same with tomarao_Examination.sql or .csv to tomarao_examination database.

Admin Side
Test account: username: admin | password: 12345

* Can create exams
    - Set timers for every questionnaire.
    - Set the total of questions.
    - Tags is equal to levels (Easy, Medium & Hard).

* Can you view the students, rankings and overall history.
    - Can approve or delete a student accounts.

* Can see the list of questions created and edit them based on satisfactory.

User Side
Test account: username: student | password: 12345

* Can view the history of their previous scores.
* Can answer the exam's questionnaires.
* Can view the the rankings.


Examination Website Features
* Filter the rankings based on level (Easy, Medium & Hard).
* Have a running timers on each questionnaire.


Code highlights
* Join method 
    - Example: $query = "SELECT q.userId qz.userId FROM quiz qz JOIN questions q ON q.userId = qz.userId";
        ** Where qz is from quiz table and q is from question table.
        ** if joining two database it will be like this;
            - $query = "SELECT qz.eid q.userId r.tomarao_Id FROM adminExam.question q
                        JOIN tomarao_Examination.registration r ON a.userId = r.tomarao_Id
                        JOIN adminExam.quiz q ON a.eid = qz.eid";

                ** Where we need to define the database name which is tomarao_Examination and adminExam.

* Filter in server-side
    - Auto-submit the form **onchange="this.form.submit()"
    - Check if the easy parameter is set in the URL query string using $_GET['easy']
            **<?php if (isset($_GET['easy']) && $_GET['easy'] == '1') echo 'checked'; ?>
    - for example if name="easy" == value="1" it will display only the rankings for the easy level, etc.

* Using Javascript to implement timer and automatically go to the next page when the time expires.
    - let time = parseInt(document.getElementById('time').getAttribute('data-time')); //fetch the id and data-time attribute
        const form = document.getElementById('questionForm'); //get the id of the form

        function countdown() {
            if (time > 0) {
                let mins = Math.floor((time % 3600) / 60);
                let secs = time % 60;
                mins = mins < 10 ? '0' + mins : mins;
                secs = secs < 10 ? '0' + secs : secs;
                document.getElementById('time').innerText = `${mins}:${secs}`; //display format
                time--;
            } else {
                document.getElementById('time').innerText = "00:00";
                alert('Time is up! Moving to the next question.'); //informing the users
                form.submit(); //auto-submit the form making it incorrect and move to the next page
            }
        }

        setInterval(countdown, 1000); //sets the milliseconds by 1000