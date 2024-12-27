<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenrose Wedding</title>
</head>
<body>
    <section id="gallery">
        <div class="gallery-container">
            <?php
            $getUsername = "SELECT * FROM users";
            $fetchData = mysqli_query($conn, $getUsername);
            $result = mysqli_fetch_assoc($fetchData);
            $username = isset($result['username']) ? $result['username'] : null;

            if ($username) {
                $album = "SELECT * FROM album WHERE username = '$username'";
                $fetchPhotos = mysqli_query($conn, $album);
                $photosFound = false;

                while ($result = mysqli_fetch_assoc($fetchPhotos)) {
                    $photos = unserialize($result['carousel_images']); // Unserialize the images
                    if (is_array($photos)) {
                        $photosFound = true;
                        foreach ($photos as $photo) {
                            ?>
                            <img src="../server/<?=$photo?>" alt="">
                            <?php
                        }
                    }
                }

                if (!$photosFound) {
                    ?>
                    <!-- default photos -->
                    <img src="assets/default_1.png" alt="photo-2">
                    <img src="assets/default_2.webp" alt="photo-3">
                    <img src="assets/default_3.webp" alt="photo-4">
                    <?php
                }
            } else {
                ?>
                <!-- default photos -->
                    <img src="assets/default_1.png" alt="photo-2">
                    <img src="assets/default_2.webp" alt="photo-3">
                    <img src="assets/default_3.webp" alt="photo-4">
                <?php
            }
            ?>
        </div>
        <div class="arrows">
            <button id="prev"><</button>
            <button id="next">></button>
        </div>
    </section>

    <main id="hero">
        <div class="overlay-timer" id="overlay">
            <div class="timer">
                <?php
                $getUsername = "SELECT * FROM users";
                $fetchData = mysqli_query($conn, $getUsername);
                $result = mysqli_fetch_assoc($fetchData);
                $username = isset($result['username']) ? $result['username'] : null;

                if ($username) {
                    $timer = "SELECT * FROM partner WHERE username = '$username'";
                    $fetchTimer = mysqli_query($conn, $timer);
                    $timer = mysqli_fetch_assoc($fetchTimer);
                    $getTimer = false;
                    if (mysqli_num_rows($fetchTimer) > 0) {
                        $getTimer = true;
                        $targetDate = new DateTime($timer['date']);
                        ?>
                        <div id="celebration">
                            <div class="icon left">🎊</div>
                            <div class="icon right">🎊</div>
                        </div>
                        <h1 id="countdown"></h1>
                        <script>
                            function updateCountdown() {
                                const targetDate = new Date("<?= $timer['date'] ?>").getTime();
                                const now = new Date().getTime();
                                const distance = targetDate - now;
                                const popper = document.getElementById('celebration');

                                popper.style.display ='none';

                                if (distance > 0) {
                                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                    document.getElementById("countdown").innerHTML =
                                        (hours < 10 ? "0" + hours : hours) + ":" +
                                        (minutes < 10 ? "0" + minutes : minutes) + ":" +
                                        (seconds < 10 ? "0" + seconds : seconds);
                                } else {
                                    document.getElementById("countdown").innerHTML = "It's Wedding Day!";
                                    popper.style.display = 'block';
                                }
                            }

                            setInterval(updateCountdown, 1000);
                        </script>
                        <?php
                    }
                    if (!$getTimer) {
                        ?>
                        <h1>00:00:00</h1>
                        <?php
                    }
                } else {
                    ?>
                    <h1>00:00:00</h1>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="hero-container">
            <?php
            $getUsername = "SELECT * FROM users";
            $fetchData = mysqli_query($conn, $getUsername);
            $result = mysqli_fetch_assoc($fetchData);
            $username = isset($result['username']) ? $result['username'] : null;

            if ($username) {
                $album = "SELECT * FROM album WHERE username = '$username'";
                $fetchPhotos = mysqli_query($conn, $album);
                $photosFound = false;

                while ($result = mysqli_fetch_assoc($fetchPhotos)) {
                    $photos = unserialize($result['overlay_images']); // Unserialize the images
                    if (is_array($photos)) {
                        $photosFound = true;
                        foreach ($photos as $photo) {
                            ?>
                            <img src="../server/<?=$photo?>" alt="">
                            <?php
                        }
                    }
                }

                if (!$photosFound) {
                    ?>
                    <!-- default photos -->
                    <img src="../assets/p_1.png" alt="welcome" loading="lazy">
                    <?php
                }
            } else {
                ?>
                <!-- default photos -->
                <img src="../assets/p_1.png" alt="welcome" loading="lazy">
                <?php
            }
            ?>
        </div>
    </main>

    <section class="card-group gap-3 p-lg-5 p-3">
        <?php
        $getUsername = "SELECT * FROM users";
        $fetchData = mysqli_query($conn, $getUsername);
        $result = mysqli_fetch_assoc($fetchData);
        $username = isset($result['username']) ? $result['username'] : null;

        if ($username) {
            $album = "SELECT * FROM album WHERE username = '$username'";
            $fetchPhotos = mysqli_query($conn, $album);
            $photosFound = false;

            $count = 0; // Initialize a counter
            while ($result = mysqli_fetch_assoc($fetchPhotos)) {
                $photos = unserialize($result['details_images']); // Unserialize the images
                if (is_array($photos)) {
                    $photosFound = true;
                    foreach ($photos as $photo) {
                        if ($count < 3) { // Check if the count is less than 3
                            ?>
                            <div class="card border-0 p-2 shadow">
                                <img src="../server/<?=$photo?>" class="card-img" alt="...">
                            </div>
                            <?php
                            $count++; // Increment the counter
                        } else {
                            break; // Exit the loop after displaying 3 photos
                        }
                    }
                }
            }

            if (!$photosFound) {
                ?>
                <!-- default photos -->
                <div class="card border-0 p-2 shadow">
                    <img src="assets/default_4.jpg" class="card-img" alt="...">
                </div>
                <div class="card border-0 p-2 shadow">
                    <img src="assets/default_5.png" class="card-img" alt="...">
                </div>
                <div class="card border-0 p-2 shadow">
                    <img src="assets/default_6.webp" class="card-img" alt="...">
                </div>
                <?php
            }
        } else {
            ?>
            <!-- default photos -->
                <div class="card border-0 p-2 shadow">
                    <img src="assets/default_4.jpg" class="card-img" alt="...">
                </div>
                <div class="card border-0 p-2 shadow">
                    <img src="assets/default_5.png" class="card-img" alt="...">
                </div>
                <div class="card border-0 p-2 shadow">
                    <img src="assets/default_6.webp" class="card-img" alt="...">
                </div>
            <?php
        }
        ?>
    </section>

    <section id="story" class="py-5 p-lg-5 p-3">
        <div class="container-fluid text-center p-3 shadow rounded">
            <?php
            $getUsername = "SELECT * FROM users";
            $fetchData = mysqli_query($conn, $getUsername);
            $result = mysqli_fetch_assoc($fetchData);
            $username = isset($result['username']) ? $result['username'] : null;

            if ($username) {
                $fetchDetails = "SELECT d.id, d.story, u.fname, p.fname as firstName FROM details d JOIN partner p ON d.username = p.username JOIN users u ON u.username = '$username'";
                $fetchQuery = mysqli_query($conn, $fetchDetails);
                $result = mysqli_fetch_assoc($fetchQuery);
                if ($result === false || !is_array($result) || $result["id"] == null) {
                    ?>
                    <h1>Lorem & Ipsum</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum tellus quis sem sagittis, nec vestibulum ipsum pretium. Fusce aliquet sem id mi cursus cursus. Fusce rhoncus efficitur pellentesque. Curabitur congue at sapien ut egestas. Aliquam facilisis sapien dui. Curabitur at massa ante. Fusce quam magna, sagittis non pharetra sed, consequat non orci. Donec consectetur nisi vitae scelerisque scelerisque.
                    Curabitur vitae nunc venenatis, scelerisque dui eget, imperdiet sem. Nunc accumsan velit vel nulla iaculis feugiat. Proin eget sem a erat accumsan vehicula. Proin hendrerit lectus eu efficitur malesuada. Aliquam erat volutpat. Quisque id nulla nisl. Duis nunc augue, tristique eu nibh in, sodales sagittis erat. Nunc dapibus congue lorem at imperdiet. Mauris sed orci vitae velit aliquam fringilla.</p>
                    <?php
                } else {
                    ?>
                    <h1><?=$result['firstName'] .' & ' . $result['fname']?></h1>
                    <p><?=$result['story']?></p>
                    <?php
                }
            } else {
                ?>
                <h1>Lorem & Ipsum</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum tellus quis sem sagittis, nec vestibulum ipsum pretium. Fusce aliquet sem id mi cursus cursus. Fusce rhoncus efficitur pellentesque. Curabitur congue at sapien ut egestas. Aliquam facilisis sapien dui. Curabitur at massa ante. Fusce quam magna, sagittis non pharetra sed, consequat non orci. Donec consectetur nisi vitae scelerisque scelerisque.
                Curabitur vitae nunc venenatis, scelerisque dui eget, imperdiet sem. Nunc accumsan velit vel nulla iaculis feugiat. Proin eget sem a erat accumsan vehicula. Proin hendrerit lectus eu efficitur malesuada. Aliquam erat volutpat. Quisque id nulla nisl. Duis nunc augue, tristique eu nibh in, sodales sagittis erat. Nunc dapibus congue lorem at imperdiet. Mauris sed orci vitae velit aliquam fringilla.</p>
                <?php
            }
            ?>
        </div>
    </section>
</body>
</html>
