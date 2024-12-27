<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSVP</title>
</head>
<body>
    <section id="rsvp-form" class="container-fluid p-5 d-flex justify-content-center">
                
        <div class="col-md-5 col-sm-12 shadow p-3 rounded d-flex text-center flex-column gap-4">
            <!-- <?=$_SESSION['guestId']?> -->
            <h2>RSVP</h2>
            <?php
            // $username = isset($_SESSION["username"]) ? $_SESSION["username"] : 'Guest';
            $getUsername = "SELECT * FROM users";
            $fetchData = mysqli_query($conn, $getUsername);
            $result = mysqli_fetch_assoc($fetchData);
            $username = $result['username'];
            $rsvpMessage = "SELECT * FROM details WHERE username = '$username'";
            $fetchQuery = mysqli_query($conn, $rsvpMessage);
            $result = mysqli_fetch_assoc($fetchQuery);
            if ($result === false || !is_array($result) || $result["id"] == null) {
                ?>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum tellus quis sem sagittis, nec vestibulum ipsum pretium.</p>
                    <?php
            } else {
                ?>
                    <p><?='Hello, ' . $_SESSION["guest"] . '! ' . $result['rsvp_message'] ?></p>
                    <?php
            }
            ?>
            <form action="../server/server-api.php" method="post" autocomplete="off" id="rsvpAnswer"class="d-flex flex-column justify-content-center align-items-center">
                <div class="d-flex gap-5 justify-content-center align-items-center my-4">
                    <!-- <input type="hidden" name="id" id="id" value="<?=$_SESSION["guestId"]?>"> -->
                    <input type="radio" name="response" id="yes" value="yes" class="btn-check">
                    <label class="btn btn-outline-success w-100" for="yes">Yes</label>
                    <input type="radio" name="response" id="no" value="no" class="btn-check">
                    <label class="btn btn-outline-success w-100" for="no">No</label>
                </div>
                <button type="submit" name="rsvp-response" class="btn btn-success my-4 w-100">Submit</button>
            </form>
        </div>
        </div>
    </section>
    
</body>
</html>
