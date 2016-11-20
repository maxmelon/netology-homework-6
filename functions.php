<?php

function showUploadedTests ($uploadDir) {

    if ($handle = opendir($uploadDir)) {

        $i = 1;
        $tests = [];

        while (false !== ($entry = readdir($handle))) {

            $sourceFileName = basename($entry);
            $sourceFileType = substr($sourceFileName, -4, 4);

        echo "<ul>";

            if ($sourceFileType === 'json')
            {
                $tests[$i] = $sourceFileName;
                echo "<li>Тест $i</li>";
                $i++;
            }

            echo "</ul>";
        }
    }

    return $tests;
}

function checkAnswers ($sumbittedQuestionID, $correctAnswer) {
    if (isset($sumbittedQuestionID) && !is_null($sumbittedQuestionID)) {
        $usersAnswer = mb_strtolower($sumbittedQuestionID);
        $correctAnswer = mb_strtolower($correctAnswer);

        if ($usersAnswer == $correctAnswer) {
            echo "<i>Верно!</i></br>";
        } else {
            echo "<i>Неверно</i></br>";
        }
    }
}

function notAllFieldsFilled ($jsonDecoded) {
    foreach ($jsonDecoded as $question) {
        if (empty($_POST["answer_$question[id]"])) {
            $notAllFieldsFilled = true;
            return $notAllFieldsFilled;
        }
    }
}

function showTest ($jsonDecoded) {

    echo "<form method=\"post\">";

    foreach ($jsonDecoded as $question) {
        if (!empty($_POST)) {
            $usersAnswer = $_POST["answer_$question[id]"];
        } else {
            $usersAnswer = "";
        }
        echo "<dl><dt><label for=\"answer_$question[id]\">Вопрос № $question[id]. $question[question]</label></dt>";
        echo "<dd><input id=\"answer_$question[id]\" name=\"answer_$question[id]\" value=\"$usersAnswer\"/></dd></dl>";
        if (notAllFieldsFilled($jsonDecoded) !== true) {
            checkAnswers ($usersAnswer, $question['answer']);
        }
    }

    if (notAllFieldsFilled($jsonDecoded) == true) {
        echo "</br>";
        echo "<button type=\"submit\">Проверить</button>";
    }

    echo "</form></br>";

    if (notAllFieldsFilled($jsonDecoded) == true && !empty($_POST)) {
        echo "Прежде чем проверить тест, ответьте, пожалуйста, на все вопросы";
    }

}

/*
function json_error () {
    switch(json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - Keine Fehler';
            break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximale Stacktiefe überschritten';
            break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Unterlauf oder Nichtübereinstimmung der Modi';
            break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unerwartetes Steuerzeichen gefunden';
            break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntaxfehler, ungültiges JSON';
            break;
        case JSON_ERROR_UTF8:
            echo ' - Missgestaltete UTF-8 Zeichen, möglicherweise fehlerhaft kodiert';
            break;
        default:
            echo ' - Unbekannter Fehler';
            break;
    }
}
*/
