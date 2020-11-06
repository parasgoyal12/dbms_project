<!doctype html>
<html lang="en">
    <?php
        $title = "Login";
        include($_SERVER['DOCUMENT_ROOT'].'\includes\head.html');
    ?>
  <body>
    <?php
        include($_SERVER['DOCUMENT_ROOT'].'\includes\navbar.php');
    ?>

    <div class="container text-center col-3 my-4">
        <form class="form-signin" action="/index.php">
            <h1>Sign In</h1><br>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <br>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
            <br>
            <button class="btn btn-lg btn-primary" type="submit">Sign in</button>
            <!-- <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p> -->
            <?php include 'footer.php'?>
        </form>
    </div>
    

</body>
</html>