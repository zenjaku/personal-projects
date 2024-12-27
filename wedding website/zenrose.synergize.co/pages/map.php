<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map</title>
</head>
<body>
    <section id="map" class="container-fluid p-5 d-flex justify-content-center align-items-center">
        <div class="row text-center">
            <?php
            if (isset($conn) && isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                
                $getUsername = "SELECT * FROM users WHERE username = '$username'";
                $fetchData = mysqli_query($conn, $getUsername);
                $result = mysqli_fetch_assoc($fetchData);

                if ($result) {
                    $query = "SELECT * FROM google WHERE username = '$username'";
                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <div class="col-12 shadow p-4 rounded">
                            <h3 class="py-3"><?=$data['wed_place']?></h3>
                            <?= $data['map_wed'] ? $data['map_wed'] : '<h2>No google map link found.</h2>' ?>
                        </div>
                        <div class="col-12 shadow p-4 rounded">
                            <h3 class="py-3"><?=$data['rep_place']?></h3>
                            <?= $data['map_rep'] ? $data['map_rep'] : '<h2>No google map link found.</h2>' ?>
                        </div>
                        <?php
                    } else {
                        ?>
                        <!-- default -->
                        <div class="col-12 shadow p-4 rounded">
                            <h3 class="py-3">Minor Basilica and Metropolitan Cathedral of the Immaculate Conception</h3>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15524.954940658718!2d120.96309234988378!3d14.591741974294786!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca17d22e6779%3A0x6a3a0ef7daa839d!2sMinor%20Basilica%20and%20Metropolitan%20Cathedral%20of%20the%20Immaculate%20Conception%20-%20Manila%20Cathedral!5e1!3m2!1sen!2sph!4v1735275137329!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="col-12 shadow p-4 rounded">
                            <h3 class="py-3">Shangri-La Plaza</h3>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15525.736858388596!2d121.04573074988036!3d14.580652874451237!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c83fcff01b47%3A0x62535c336afa2088!2sShangri-La%20Plaza!5e1!3m2!1sen!2sph!4v1735275186004!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <!-- default -->
                    <div class="col-12 shadow p-4 rounded">
                            <h3 class="py-3">Minor Basilica and Metropolitan Cathedral of the Immaculate Conception</h3>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15524.954940658718!2d120.96309234988378!3d14.591741974294786!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca17d22e6779%3A0x6a3a0ef7daa839d!2sMinor%20Basilica%20and%20Metropolitan%20Cathedral%20of%20the%20Immaculate%20Conception%20-%20Manila%20Cathedral!5e1!3m2!1sen!2sph!4v1735275137329!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="col-12 shadow p-4 rounded">
                            <h3 class="py-3">Shangri-La Plaza</h3>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15525.736858388596!2d121.04573074988036!3d14.580652874451237!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c83fcff01b47%3A0x62535c336afa2088!2sShangri-La%20Plaza!5e1!3m2!1sen!2sph!4v1735275186004!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    <?php
                }
            } else {
                ?>
                <!-- default -->
                <div class="col-12 shadow p-4 rounded">
                            <h3 class="py-3">Minor Basilica and Metropolitan Cathedral of the Immaculate Conception</h3>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15524.954940658718!2d120.96309234988378!3d14.591741974294786!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca17d22e6779%3A0x6a3a0ef7daa839d!2sMinor%20Basilica%20and%20Metropolitan%20Cathedral%20of%20the%20Immaculate%20Conception%20-%20Manila%20Cathedral!5e1!3m2!1sen!2sph!4v1735275137329!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="col-12 shadow p-4 rounded">
                            <h3 class="py-3">Shangri-La Plaza</h3>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15525.736858388596!2d121.04573074988036!3d14.580652874451237!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c83fcff01b47%3A0x62535c336afa2088!2sShangri-La%20Plaza!5e1!3m2!1sen!2sph!4v1735275186004!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                <?php
            }
            ?>
        </div>
    </section>
</body>
</html>
