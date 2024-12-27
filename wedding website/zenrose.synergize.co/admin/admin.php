<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <section id="admin-panel" class="container py-5">
            <?php
            $username = $_SESSION['username'];
            $profile = "SELECT * FROM users WHERE username = '$username'";
            $fetchData = mysqli_query($conn, $profile);
            $result = mysqli_fetch_assoc($fetchData);
            ?>
            
        <div class="row gap-3">
            <div class="col-md-6 col-sm-12 p-3 p-lg-0">
                <div class="card shadow p-3 bg-success text-white">
                    <div class="header mb-3">
                        <h1><?= $result['fname'] . ' ' . $result['lname'] ?></h1>
                        <p>@<?= $username ?></p>
                    </div>
                    <div class="card-body">
                        <p><strong>Email Address: </strong><?= $result['email'] ?></p>
                        <?php
                        $username = $_SESSION['username'];
                        $fetchPartner = "SELECT * FROM partner WHERE username = '$username'";
                        $fetchQuery = mysqli_query($conn, $fetchPartner);
                        $result = mysqli_fetch_assoc($fetchQuery);
                        if ($result === false || !is_array($result) || $result['id'] == null) {
                        ?>
                        <form action="../server/server-api.php" method="post" autocomplete="off" id="update" class="d-flex flex-column gap-3">
                            <div class="form-floating">
                                <input type="text" name="fname" placeholder="Partner's First Name" class="form-control" id="fname" required>
                                <label for="fname">Partner's First Name</label>
                            </div>
                            <div class="form-floating">
                                <input type="text" name="lname" placeholder="Partner's Last Name" class="form-control" id="lname" required>
                                <label for="lname">Partner's Last Name</label>
                            </div>
                            <div class="form-floating">
                                <input type="date" name="wedding-date" id="wedding-date" class="form-control" placeholder="Wedding Date" required>
                                <label for="wedding-date">Wedding Date</label>
                            </div>
                            <button type="submit" class="btn btn-success" name="partner">Submit</button>
                        </form>
                        <?php
                        } else {
                            ?>
                            <div class="d-flex flex-column gap-3">
                                <input type="text" name="fname" value="<?= $result['fname'] . ' ' . $result['lname'] ?>" class="form-control" disabled>
                                <input type="text" name="wedding-date" value="<?= $result['date']?>" class="form-control" disabled>
                                <button type="button" class="btn btn-light" popovertarget="editPartner">Edit Details</button>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-warning w-100" popovertarget="guest">Register a guest?</button>
                                    <button type="button" class="btn btn-dark w-100" popovertarget="guest-list">View Guests</button>
                                </div>
                                <button type="button" class="btn btn-danger" popovertarget="event">Add Event</button>
                            </div>
                            <section id="editPartner" class="container py-5 p-5" popover>
                                <div class="row p-2 p-lg-0 d-flex justify-content-center">
                                    <form action="../server/server-api.php" method="post" autocomplete="off" id="update" class="d-flex flex-column gap-3">
                                        <div class="form-floating">
                                            <input type="text" name="fname" placeholder="Partner's First Name" class="form-control" id="fname">
                                            <label for="fname">Partner's First Name</label>
                                        </div>
                                        <div class="form-floating">
                                            <input type="text" name="lname" placeholder="Partner's Last Name" class="form-control" id="lname">
                                            <label for="lname">Partner's Last Name</label>
                                        </div>
                                        <div class="form-floating">
                                            <input type="date" name="wedding-date" id="wedding-date" class="form-control" placeholder="Wedding Date">
                                            <label for="wedding-date">Wedding Date</label>
                                        </div>
                                        <button type="submit" class="btn btn-success" name="partner-update">Submit</button>
                                    </form>
                                </div>
                            </section>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <hr>
                <div class="row p-2">
                    <div class="card shadow p-2">
                        <h3 class="text-center">Details</h3>
                        <hr>
                        <div class="card-body">
                            <?php
                            $username = $_SESSION['username'];
                            $fetchDetails = "SELECT * FROM details WHERE username = '$username'";
                            $fetchQuery = mysqli_query($conn, $fetchDetails);
                            $result = mysqli_fetch_assoc($fetchQuery);
                            if ($result === false || !is_array($result) || $result["id"] == null) {
                                ?>
                                <form action="../server/server-api.php" method="post" id="detailsForm" class="d-flex flex-column gap-3">
                                    <div class="form-floating">
                                        <textarea type="text" name="story" id="story" class="form-control" placeholder="Your Story" required></textarea>
                                        <label for="story">Your Story</label>
                                    </div>
                                    <div class="form-floating">
                                        <textarea type="text" name="rsvp-message" id="rsvp-message" class="form-control" placeholder="RSVP Message" required></textarea>
                                        <label for="rsvp-message">RSVP Message</label>
                                    </div>
                                    <button type="submit" class="btn btn-success" name="details">Submit</button>
                                </form>
                                <?php
                            } else {
                                ?>
                                <form action="../server/server-api.php" method="post" id="editDetails" class="d-flex flex-column gap-3">
                                    <div class="form-floating">
                                        <p class="form-control result-message bg-dark bg-opacity-10"><?=$result['story']?></p>
                                        <textarea type="text" name="story" id="update-story" class="form-control" placeholder="Your Story"></textarea>
                                        <label for="story">Your Story</label>
                                    </div>
                                    <div class="form-floating">
                                        <p class="form-control result-message bg-dark bg-opacity-10"><?=$result['rsvp_message']?></p>
                                        <textarea type="text" name="rsvp-message" id="update-rsvp-message" class="form-control" placeholder="RSVP Message"></textarea>
                                        <label for="rsvp-message">RSVP Message</label>
                                    </div>
                                    <button type="button" class="btn btn-warning" id="updateDetails">Edit</button>
                                    <button type="submit" class="btn btn-success" name="details-update" id="details-update">Submit</button>
                                    <button type="button" class="btn btn-danger" id="cancel-btn">Cancel</button>
                                </form>
                                <?php
                            }
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-5 col-sm-12 p-3 p-lg-0">
                <div class="card shadow p-4">
                    <h3 class="text-center">Upload Photos</h3>
                    <small>* only .jpg, .jpeg and .png is allowed.</small>
                    <hr>
                    <div class="card-body">
                        <form action="../server/server-api.php" method="post" id="uploadPhoto" class="d-flex flex-column gap-3" enctype="multipart/form-data">
                            <div class="form-floating">
                                <input type="file" name="carousel-images[]" id="images1" placeholder="Carousel Photos" class="form-control" accept=".jpg, .jpeg, .png" multiple>
                                <label for="images1">Carousel Images</label>
                            </div>
                            <div class="form-floating">
                                <input type="file" name="overlay-images" id="images2" placeholder="Carousel Photos" class="form-control" accept=".jpg, .jpeg, .png">
                                <label for="images2">Overlay Background of timer</label>
                            </div>
                            <div class="form-floating">
                                <input type="file" name="details-images[]" id="images3" placeholder="Carousel Photos" class="form-control" accept=".jpg, .jpeg, .png" multiple>
                                <label for="images3">Details</label>
                            </div>
                            <button type="submit" class="btn btn-success" name="upload-photo">Upload</button>
                        </form>
                    </div>
                </div>

                <div class="row p-3">
                    <div class="card shadow p-3">
                        <h3 class="text-center">Google Map</h3>
                        <hr>
                        <div class="card-body">
                            <?php
                            $username = $_SESSION['username'];
                            $fetchData = "SELECT * FROM google WHERE username = '$username'";
                            $fetchQuery = mysqli_query($conn, $fetchData);
                            $result = mysqli_fetch_assoc($fetchQuery);
                            if ($result === false || !is_array($result) || $result["id"] == null) {
                                ?>
                                <form action="../server/server-api.php" method="post" id="googleMapForm" class="d-flex flex-column gap-3">
                                    <div class="form-floating">
                                        <input name="wed-place" id="wed-place" class="form-control" placeholder="Wedding Place Name" required>
                                        <label for="wed-place">Wedding Place Name</label>
                                    </div>
                                    <div class="form-floating">
                                        <textarea name="map-link-wed" id="map-link-wed" class="form-control" placeholder="Google Map Link (Wedding Place)" required rows="3"></textarea>
                                        <label for="map-link-wed">Google Map Link (Wedding Place)</label>
                                    </div>
                                    <div class="form-floating">
                                        <input name="rep-place" id="rep-place" class="form-control" placeholder="Reception Place Name" required>
                                        <label for="rep-place">Reception Place Name</label>
                                    </div>
                                    <div class="form-floating">
                                        <textarea name="map-link-rep" id="map-link-rep" class="form-control" placeholder="Google Map Link (Reception Place)" required rows="3"></textarea>
                                        <label for="map-link-rep">Google Map Link (Reception Place)</label>
                                    </div>
                                    <button type="submit" class="btn btn-success" name="google-map" id="googleMap">Submit</button>
                                </form>

                                <?php
                            } else {
                                ?>
                                <form action="../server/server-api.php" method="post" id="editGoogleMap" class="d-flex flex-column gap-3">
                                    <div class="form-floating">
                                        <input name="wed-place" id="edit-place" class="form-control" placeholder="Wedding Place Name" value="<?=$result['wed_place']?>" >
                                        <label for="edit-place">Wedding Place Name</label>
                                    </div>
                                    <div class="form-floating">
                                        <p class="form-control bg-dark bg-opacity-10 displayed-fields"><?= $result['map_wed'] ? 'Map Link Stored' : '' ?></p>
                                        <textarea name="map-link-wed" id="edit-link-wed" class="form-control" placeholder="Google Map Link (Wedding Place)" rows="3"></textarea>
                                        <label for="edit-link-wed">Google Map Link (Wedding Place)</label>
                                    </div>
                                    <div class="form-floating">
                                        <input name="rep-place" id="edit-place" class="form-control" placeholder="Reception Place Name" value="<?=$result['rep_place']?>" >
                                        <label for="edit-place">Reception Place Name</label>
                                    </div>
                                    <div class="form-floating">
                                        <p class="form-control bg-dark bg-opacity-10 displayed-fields"><?= $result['map_wed'] ? 'Map Link Stored' : '' ?></p>
                                        <textarea name="map-link-rep" id="edit-link-rep" class="form-control" placeholder="Google Map Link (Reception Place)" rows="3"></textarea>
                                        <label for="edit-link-rep">Google Map Link (Reception Place)</label>
                                    </div>
                                    <button type="button" class="btn btn-warning" id="updateEdit">Edit</button>
                                    <button type="submit" class="btn btn-success" name="google-update" id="updateSubmit">Submit</button>
                                    <button type="button" class="btn btn-danger" id="cancelBtn">Cancel</button>
                                </form>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="event" class="container py-5" popover>
        <div class="row">
            <div class="col-12">
                <div class="card shadow rounded p-4 p-lg-5 text-center">
                    <h1>Events</h1>
                    <form action="../server/server-api.php" method="post" id="eventForm" class="d-flex flex-column gap-2 px-lg-5" enctype="multipart/form-data">
                        <div class="form-floating">
                            <input type="text" name="event-header" id="event-header" class="form-control" placeholder="Event Title" required>
                            <label for="event-header">Event Title</label>
                        </div>
                        <div class="form-floating">
                            <input type="file" name="event-images[]" id="images4" placeholder="Carousel Photos" class="form-control" accept=".jpg, .jpeg, .png">
                            <label for="images4">Event Photo</label>
                        </div>
                        <div class="form-floating">
                            <textarea name="event-details" id="event-details" class="form-control" placeholder="Event Details" required rows="3"></textarea>
                            <label for="event-details">Event Details</label>
                        </div>
                        <button type="submit" name="submit-event" id="eventBtn" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- popovers -->
    <section id="guest" class="container py-5" popover>
        <div class="row p-2 p-lg-0 d-flex justify-content-center">
            <div class="col-md-8 col-sm-12">
                <div class="card card shadow rounded p-4 gap-4 text-center">
                    <h3>Guest's Registration</h3>
                    <div class="card-body">
                        <form action="../server/server-api.php" method="post" autocomplete="off" id="guestForm" class="d-flex flex-column gap-3">
                            <div class="form-floating">
                                <input type="text" name="g-fname" id="g-fname" placeholder="Guest's First Name" class="form-control" required>
                                <label for="g-fname">Guest's First Name</label>
                            </div>
                            <div class="form-floating">
                                <input type="text" name="g-lname" id="g-lname" placeholder="Guest's Last Name" class="form-control" required>
                                <label for="g-lname">Guest's Last Name</label>
                            </div>
                            <button type="submit" name="guest-register" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="guest-list" class="container p-4 p-lg-5" popover>
        <div class="row d-flex justify-content-center">
            <div class="col card rounded shadow d-flex flex-column gap-4 p-2 p-lg-4">
                <h3 class="text-center">Guest List</h3>
                <table class="table table-bordered border-success border-opacity-25 table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Response</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    <?php
                    $username = $_SESSION['username'];
                    $guestList = "SELECT * FROM guests WHERE username = '$username'";
                    $fetchQuery = mysqli_query($conn, $guestList);
                    $guestFound = false;
                    $count = 1;
                    while( $result = mysqli_fetch_assoc($fetchQuery) ) {
                        $guestFound = true;
                        $itemNumber = $count++;
                    ?>
                    <tr>
                        <td><?=$itemNumber?></td>
                        <td class="w-50"><?=$result['fname'] . ' ' . $result['lname']?></td></td>
                        <td><?=$result['response'] ? $result['response'] : 'No response yet.' ?></td>
                    </tr>
                    <?php
                    }
                    if (!$guestFound) {
                    ?>
                    <tr>
                        <td colspan="3">No Guest found.</td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>