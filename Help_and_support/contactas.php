<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title> <!-- Updated title to 'Contact Us' -->
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>

<header>
    <h1>Contact Us</h1> <!-- Header named 'Contact Us' -->
</header>

<div class="form-container">
    <form class="form" action="#" method="post">
        <div class="form-group">
            <label for="email">Company Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="textarea">How Can We Help You?</label>
            <textarea name="textarea" id="textarea" rows="10" cols="50" required></textarea>
        </div>
        <button class="form-submit-btn" type="submit">Submit</button>
    </form>
</div>

</body>
</html>
