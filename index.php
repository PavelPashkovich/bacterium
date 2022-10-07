<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bacterium</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Ubuntu Mono", sans-serif;
        }

        .form-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            display: flex;
            flex-direction: column;
            width: 300px;
        }

        input {
            margin: 10px 0;
            padding: 10px;
            border: none;
            border-bottom: 2px solid #e3e3e3;
            outline: none;
        }

        button {
            padding: 10px;
            background-color: #e3e3e3;
            border: none;
            cursor: pointer;
        }

        .error {
            font-size: 12px;
            color: red;
            margin-bottom: 10px;
        }

        .msg {
            margin-top: 10px;
            border: 2px solid blue;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            color: black;
        }

        .red {
            color: red;
        }

        .green {
            color: green;
        }

    </style>
</head>
<body>

<!--     Form-->
<div class="form-wrapper">
    <form action="" method="POST">

        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your name here..." value="<?php echo $_POST['name'] ?? '' ?>">
        <?php
            if (isset($_POST['name'])) {
                echo validateName($_POST['name']);
            }
        ?>

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" placeholder="+375445556677" value="<?php echo $_POST['phone'] ?? '' ?>">
        <?php
            if (isset($_POST['phone'])) {
                echo validatePhone($_POST['phone']);
            }
        ?>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email here..." value="<?php echo $_POST['email'] ?? '' ?>">
        <?php
            if (isset($_POST['email'])) {
                echo validateEmail($_POST['email']);
            }
        ?>

        <label for="cycles">Number of cycles</label>
        <input type="text" id="cycles" name="cycles" placeholder="Enter the number of cycles here..." value="<?php echo $_POST['cycles'] ?? '' ?>">
        <?php
            if (isset($_POST['cycles'])) {
                echo validateCycles($_POST['cycles']);
            }
        ?>

        <input type="hidden" name="errors" value="0">

        <button type="submit">Submit</button>

        <?php
            if (isset($_POST['cycles']) && !$_POST['errors']) {
                echo showBacteria($_POST['cycles']);
            }
        ?>

    </form>
</div>

</body>
</html>

<?php

function validateName($name) {
    if (!preg_match('/^[ a-zA-Z]+$/', $name) || strlen($name) < 2) {
        $_POST['errors'] = 1;
        return '<p class="error">*Name must contain only letters (min 2 chars)!</p>';
    }
}

function validatePhone($phone) {
    if (!preg_match('/^[-+0-9]+$/', $phone) || strlen($phone) < 7) {
        $_POST['errors'] = 1;
        return '<p class="error">*Phone must contain only digits, "+" and "-"! (min 7 chars)</p>';
    }
}

function validateEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_POST['errors'] = 1;
        return '<p class="error">*You must enter a valid email!</p>';
    }
}

function validateCycles($cycles) {
    if(!is_numeric($cycles) || !preg_match('/^[-+0-9]+$/', $cycles) || $cycles < 0) {
        $_POST['errors'] = 1;
        return '<p class="error">*You must enter a non-negative integer!</p>';
    }
}

function showBacteria($cycles) {
    $green = 1;
    $red = 1;
    $allGreen = 0;
    $allRed = 0;

    if ($cycles == 0) {
        $allGreen = $green;
        $allRed = $red;
    } else {
        for ($i = 1; $i <= $cycles; $i++) {
            $allGreen += $green * 3 + $red * 7;
            $allRed += $green * 4 + $red * 5;

            $green = $allGreen;
            $red = $allRed;
        }
    }

    return '<div class="msg">
                <p><span class="red">Red</span>: <span class="red">' . $allRed. '</span></p>
                <p><span class="green">Green</span>: <span class="green">' . $allGreen . '</span></p>
                <p>Total: ' . $allGreen + $allRed . '</p>
            </div>';
}
