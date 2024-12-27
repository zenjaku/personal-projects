<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSVP</title>
</head>
<body>
    <section id="rsvp" class="container-fluid p-5">
        <div class="row text-center d-flex justify-content-center p-lg-5 mb-3 gap-4" id="checkGuest">
            <div class="col-md-5 col-sm-12 shadow p-3 rounded d-flex flex-column gap-4">
                <h2>RSVP</h2>
                <?php
                $getUsername = "SELECT * FROM users";
                $fetchData = mysqli_query($conn, $getUsername);
                $result = mysqli_fetch_assoc($fetchData);
                $username = isset($result['username']) ? $result['username'] : null;

                if ($username) {
                    $rsvpMessage = "SELECT * FROM details WHERE username = '$username'";
                    $fetchQuery = mysqli_query($conn, $rsvpMessage);
                    $result = mysqli_fetch_assoc($fetchQuery);

                    if ($result && isset($result['rsvp_message'])) {
                        ?>
                        <p><?=$result['rsvp_message']?></p>
                        <?php
                    } else {
                        ?>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum tellus quis sem sagittis, nec vestibulum ipsum pretium.</p>
                        <?php
                    }
                } else {
                    ?>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum tellus quis sem sagittis, nec vestibulum ipsum pretium.</p>
                    <?php
                }
                ?>
                <form action="../server/server-api.php" method="post" autocomplete="off" id="rsvpForm">
                    <div class="form-floating my-3">
                        <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                        <label for="fname">First Name</label>
                    </div>
                    <div class="form-floating my-3">
                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                        <label for="lname">Last Name</label>
                    </div>
                    <button type="submit" class="btn btn-success w-100" id="checkBtn" name="check-guest">Submit</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
