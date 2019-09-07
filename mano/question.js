function Quiz(questions) {
    this.score = 0;
    this.questions = questions;
    this.questionIndex = 0;
}

Quiz.prototype.getQuestionIndex = function () {
    return this.questions[this.questionIndex];
}

Quiz.prototype.guess = function (answer) {
    if (this.getQuestionIndex().isCorrectAnswer(answer)) {
        this.score++;
    }

    this.questionIndex++;
}

Quiz.prototype.isEnded = function () {
    return this.questionIndex === this.questions.length;
}


function Question(text, choices, answer) {
    this.text = text;
    this.choices = choices;
    this.answer = answer;
}

Question.prototype.isCorrectAnswer = function (choice) {
    return this.answer === choice;
}

function populate() {

    if (quiz.isEnded()) {
        showScores();
    }
    else {
        setTimeout(function () {

            alert("tavo laikas baigėsi");
        }, 60000);


        var time = 60;

        // Funkcija kuri kvieciama kiekviena sekunde
        setInterval(skaiciuotiLaika, 1000);

        function skaiciuotiLaika() {
            time--;
            if (time < 0) {

            } else {
                $("#timer span").text(time + " s");

            }


        }
        // show question
        var element = document.getElementById("question");
        element.innerHTML = quiz.getQuestionIndex().text;

        // show options
        var choices = quiz.getQuestionIndex().choices;
        for (var i = 0; i < choices.length; i++) {
            var element = document.getElementById("choice" + i);
            element.innerHTML = choices[i];
            guess("btn" + i, choices[i]);
        }

        showProgress();
    }
};

function guess(id, guess) {
    var button = document.getElementById(id);
    button.onclick = function () {
        quiz.guess(guess);
        populate();
    }
};


function showProgress() {
    var currentQuestionNumber = quiz.questionIndex + 1;
    var element = document.getElementById("progress");
    element.innerHTML = "Klausimas " + currentQuestionNumber + " iš " + quiz.questions.length;
};

function showScores() {
    var gameOverHTML = "<h1>Rezultatas</h1>";
    gameOverHTML += "<h2 id='score'> Tavo taškai: " + quiz.score + "</h2>";
    var element = document.getElementById("quiz");
    element.innerHTML = gameOverHTML;
};

// create questions hereKoks tai medis
var questions = [
    new Question("<img src='image/azuolas.jpg' width='280' height='280'/><br/ >Koks tai medis?", ["Ąžuolas", "Beržas", "Liepa", "Juodalksnis"], "Ąžuolas"),
    new Question("<img src='image/liepa.jpg' width='280' height='280' /><br/Koks tai medis?>Koks tai medis?", ["Beržas", "Obelis", "Liepa", "Pušis"], "Liepa"),
    new Question("<img src='image/egle.jpg' width='280' height='280' /><br/Koks tai medis?>Koks tai medis?", ["Pušis", "Maumedis", "Pocūgė", "Eglė"], "Eglė"),
    new Question("<img src='image/berzas.jpg' width='280' height='280' /><br/Koks tai medis?>Koks tai medis?", ["Ąžuolas", "Uosis", "Šermukšnis", "Beržas"], "Beržas"),
    new Question("<img src='image/pocuge.jpg' width='280' height='280' /><br/Koks tai medis?>Koks tai medis?", ["Eglė", "Pušis", "Liepa", "Pocūgė"], "Pocūgė")

];

// create quiz
var quiz = new Quiz(questions);

// display quiz
populate();

