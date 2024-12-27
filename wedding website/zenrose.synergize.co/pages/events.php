<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
</head>
<body>
    <section id="events" class="container-fluid p-5">
        <div class="row d-flex justify-content-center gap-lg-4 gap-4">
            <?php
            $getUsername = "SELECT * FROM users";
            $fetchData = mysqli_query($conn, $getUsername);
            $result = mysqli_fetch_assoc($fetchData);
            $username = isset($result['username']) ? $result['username'] : null;

            if ($username) {
                $event = "SELECT * FROM event WHERE username = '$username'";
                $fetchEvent = mysqli_query($conn, $event);
                $photosFound = false;

                while ($result = mysqli_fetch_assoc($fetchEvent)) {
                    $photos = unserialize($result['event_images']); // Unserialize the images
                    if (is_array($photos)) {
                        $photosFound = true;
                        foreach ($photos as $photo) {
                            ?>
                            <div class="col-md-4 shadow p-lg-5 p-4" id="cocktail-bar">
                                <h1><?=$result['event_title']?></h1>
                                <img src="../server/<?=$photo?>" alt="" class="img-fluid my-5">
                                <div class="corner-details">
                                    <p><?=$result['event_details']?></p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }

                if (!$photosFound) {
                    ?>
                    <!-- default photos -->
                    <div class="col-md-4 shadow p-lg-5 p-4" id="cocktail-bar">
                        <h1>Cocktail Bar</h1>
                        <img src="assets/p_7.jpg" alt="" class="img-fluid my-5">
                        <div class="corner-details">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum tellus quis sem sagittis, nec vestibulum ipsum pretium. Fusce aliquet sem id mi cursus cursus. Fusce rhoncus efficitur pellentesque. Curabitur congue at sapien ut egestas. Aliquam facilisis sapien dui. Curabitur at massa ante. Fusce quam magna, sagittis non pharetra sed, consequat non orci. Donec consectetur nisi vitae scelerisque scelerisque.

                            Curabitur vitae nunc venenatis, scelerisque dui eget, imperdiet sem. Nunc accumsan velit vel nulla iaculis feugiat. Proin eget sem a erat accumsan vehicula. Proin hendrerit lectus eu efficitur malesuada. Aliquam erat volutpat. Quisque id nulla nisl. Duis nunc augue, tristique eu nibh in, sodales sagittis erat. Nunc dapibus congue lorem at imperdiet. Mauris sed orci vitae velit aliquam fringilla.</p>
                        </div>
                    </div>
                    <div class="col-md-4 shadow p-lg-5 p-4" id="coffee-bar">
                        <h1>Coffee Bar</h1>
                        <img src="assets/p_5.jpg" alt="" class="img-fluid my-5">
                        <div class="corner-details">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum tellus quis sem sagittis, nec vestibulum ipsum pretium. Fusce aliquet sem id mi cursus cursus. Fusce rhoncus efficitur pellentesque. Curabitur congue at sapien ut egestas. Aliquam facilisis sapien dui. Curabitur at massa ante. Fusce quam magna, sagittis non pharetra sed, consequat non orci. Donec consectetur nisi vitae scelerisque scelerisque.

                            Curabitur vitae nunc venenatis, scelerisque dui eget, imperdiet sem. Nunc accumsan velit vel nulla iaculis feugiat. Proin eget sem a erat accumsan vehicula. Proin hendrerit lectus eu efficitur malesuada. Aliquam erat volutpat. Quisque id nulla nisl. Duis nunc augue, tristique eu nibh in, sodales sagittis erat. Nunc dapibus congue lorem at imperdiet. Mauris sed orci vitae velit aliquam fringilla.</p>
                        </div>
                    </div>
                    <div class="col-md-4 shadow p-lg-5 p-4" id="dessert-bar">
                        <h1>Dessert Treats</h1>
                        <img src="assets/p_6.jpg" alt="" class="img-fluid my-5">
                        <div class="corner-details">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum tellus quis sem sagittis, nec vestibulum ipsum pretium. Fusce aliquet sem id mi cursus cursus. Fusce rhoncus efficitur pellentesque. Curabitur congue at sapien ut egestas. Aliquam facilisis sapien dui. Curabitur at massa ante. Fusce quam magna, sagittis non pharetra sed, consequat non orci. Donec consectetur nisi vitae scelerisque scelerisque.

                            Curabitur vitae nunc venenatis, scelerisque dui eget, imperdiet sem. Nunc accumsan velit vel nulla iaculis feugiat. Proin eget sem a erat accumsan vehicula. Proin hendrerit lectus eu efficitur malesuada. Aliquam erat volutpat. Quisque id nulla nisl. Duis nunc augue, tristique eu nibh in, sodales sagittis erat. Nunc dapibus congue lorem at imperdiet. Mauris sed orci vitae velit aliquam fringilla.</p>
                        </div>
                    </div>
                    <div class="col-md-4 shadow p-lg-5 p-4" id="perfume-bar">
                        <h1>Perfume Bar</h1>
                        <img src="assets/p_8.jpg" alt="" class="img-fluid my-5">
                        <div class="corner-details">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum tellus quis sem sagittis, nec vestibulum ipsum pretium. Fusce aliquet sem id mi cursus cursus. Fusce rhoncus efficitur pellentesque. Curabitur congue at sapien ut egestas. Aliquam facilisis sapien dui. Curabitur at massa ante. Fusce quam magna, sagittis non pharetra sed, consequat non orci. Donec consectetur nisi vitae scelerisque scelerisque.

                            Curabitur vitae nunc venenatis, scelerisque dui eget, imperdiet sem. Nunc accumsan velit vel nulla iaculis feugiat. Proin eget sem a erat accumsan vehicula. Proin hendrerit lectus eu efficitur malesuada. Aliquam erat volutpat. Quisque id nulla nisl. Duis nunc augue, tristique eu nibh in, sodales sagittis erat. Nunc dapibus congue lorem at imperdiet. Mauris sed orci vitae velit aliquam fringilla.</p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <!-- default photos -->
                <div class="col-md-4 shadow p-lg-5 p-4" id="cocktail-bar">
                    <h1>Cocktail Bar</h1>
                    <img src="assets/p_7.jpg" alt="" class="img-fluid my-5">
                    <div class="corner-details">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum tellus quis sem sagittis, nec vestibulum ipsum pretium. Fusce aliquet sem id mi cursus cursus. Fusce rhoncus efficitur pellentesque. Curabitur congue at sapien ut egestas. Aliquam facilisis sapien dui. Curabitur at massa ante. Fusce quam magna, sagittis non pharetra sed, consequat non orci. Donec consectetur nisi vitae scelerisque scelerisque.

                        Curabitur vitae nunc venenatis, scelerisque dui eget, imperdiet sem. Nunc accumsan velit vel nulla iaculis feugiat. Proin eget sem a erat accumsan vehicula. Proin hendrerit lectus eu efficitur malesuada. Aliquam erat volutpat. Quisque id nulla nisl. Duis nunc augue, tristique eu nibh in, sodales sagittis erat. Nunc dapibus congue lorem at imperdiet. Mauris sed orci vitae velit aliquam fringilla.</p>
                    </div>
                </div>
                <div class="col-md-4 shadow p-lg-5 p-4" id="coffee-bar">
                    <h1>Coffee Bar</h1>
                    <img src="assets/p_5.jpg" alt="" class="img-fluid my-5">
                    <div class="corner-details">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum tellus quis sem sagittis, nec vestibulum ipsum pretium. Fusce aliquet sem id mi cursus cursus. Fusce rhoncus efficitur pellentesque. Curabitur congue at sapien ut egestas. Aliquam facilisis sapien dui. Curabitur at massa ante. Fusce quam magna, sagittis non pharetra sed, consequat non orci. Donec consectetur nisi vitae scelerisque scelerisque.

                        Curabitur vitae nunc venenatis, scelerisque dui eget, imperdiet sem. Nunc accumsan velit vel nulla iaculis feugiat. Proin eget sem a erat accumsan vehicula. Proin hendrerit lectus eu efficitur malesuada. Aliquam erat volutpat. Quisque id nulla nisl. Duis nunc augue, tristique eu nibh in, sodales sagittis erat. Nunc dapibus congue lorem at imperdiet. Mauris sed orci vitae velit aliquam fringilla.</p>
                    </div>
                </div>
                <div class="col-md-4 shadow p-lg-5 p-4" id="dessert-bar">
                    <h1>Dessert Treats</h1>
                    <img src="assets/p_6.jpg" alt="" class="img-fluid my-5">
                    <div class="corner-details">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum tellus quis sem sagittis, nec vestibulum ipsum pretium. Fusce aliquet sem id mi cursus cursus. Fusce rhoncus efficitur pellentesque. Curabitur congue at sapien ut egestas. Aliquam facilisis sapien dui. Curabitur at massa ante. Fusce quam magna, sagittis non pharetra sed, consequat non orci. Donec consectetur nisi vitae scelerisque scelerisque.

                        Curabitur vitae nunc venenatis, scelerisque dui eget, imperdiet sem. Nunc accumsan velit vel nulla iaculis feugiat. Proin eget sem a erat accumsan vehicula. Proin hendrerit lectus eu efficitur malesuada. Aliquam erat volutpat. Quisque id nulla nisl. Duis nunc augue, tristique eu nibh in, sodales sagittis erat. Nunc dapibus congue lorem at imperdiet. Mauris sed orci vitae velit aliquam fringilla.</p>
                    </div>
                </div>
                <div class="col-md-4 shadow p-lg-5 p-4" id="perfume-bar">
                    <h1>Perfume Bar</h1>
                    <img src="assets/p_8.jpg" alt="" class="img-fluid my-5">
                    <div class="corner-details">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum tellus quis sem sagittis, nec vestibulum ipsum pretium. Fusce aliquet sem id mi cursus cursus. Fusce rhoncus efficitur pellentesque. Curabitur congue at sapien ut egestas. Aliquam facilisis sapien dui. Curabitur at massa ante. Fusce quam magna, sagittis non pharetra sed, consequat non orci. Donec consectetur nisi vitae scelerisque scelerisque.

                        Curabitur vitae nunc venenatis, scelerisque dui eget, imperdiet sem. Nunc accumsan velit vel nulla iaculis feugiat. Proin eget sem a erat accumsan vehicula. Proin hendrerit lectus eu efficitur malesuada. Aliquam erat volutpat. Quisque id nulla nisl. Duis nunc augue, tristique eu nibh in, sodales sagittis erat. Nunc dapibus congue lorem at imperdiet. Mauris sed orci vitae velit aliquam fringilla.</p>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
</body>
</html>
