<?php
include '../auth/auth-security.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Clients</title>
</head>
<body id="clients">
    
<?php
// session_start();
if (isset($_SESSION['status'])) {
    if ($_SESSION['status'] === 'success') {
        ?>
                    <div class="renzo-alert renzo-bg-warning alert-dismissible fade show" role="alert" id="alertSuccess">
                        <strong><?php echo $_SESSION['success']; ?></strong>
                        <button type="button" class="renzo-btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                    </div>
                    <script>
                        setTimeout(function () {
                            const alertElement = document.getElementById('alertSuccess');
                            if (alertElement) {
                                alertElement.remove();
                            }
                        }, 3000);

                        const closeButton = document.querySelector('.renzo-btn-close');
                        if (closeButton) {
                            closeButton.addEventListener('click', function () {
                                const alertElement = document.getElementById('alertSuccess');
                                if (alertElement) {
                                    alertElement.remove();
                                }
                            });
                        }
                    </script>
                    <?php
                    unset($_SESSION['status']);
    } elseif ($_SESSION['status'] === 'failed') {
        ?>
                    <div class="renzo-alert renzo-bg-danger alert-dismissible fade show" role="alert" id="alertFailed">
                        <strong><?php echo $_SESSION['failed']; ?></strong>
                        <button type="button" class="renzo-btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                    </div>
                    <script>
                        setTimeout(function () {
                            const alertElement = document.getElementById('alertFailed');
                            if (alertElement) {
                                alertElement.remove();
                            }
                        }, 3000);

                        const closeButton = document.querySelector('.renzo-btn-close');
                        if (closeButton) {
                            closeButton.addEventListener('click', function () {
                                const alertElement = document.getElementById('alertFailed');
                                if (alertElement) {
                                    alertElement.remove();
                                }
                            });
                        }
                    </script>
                    <?php
                    unset($_SESSION['status']); // Clear the session variable
    }
}
?>
    <?php
    include '../server/fetch-users.php';
    ?>
    <table class="renzo-table">
        <tr>
            <td class="renzo-table-header">Username</td>
            <td class="renzo-table-header">Email</td>
            <td class="renzo-table-header">Actions</td>
        </tr>
        <?php
        $found_clients = false;
        foreach ($clients as $user) {
            $userId = $user['userId'];
            if($user['type'] == '0') {
                $found_clients = true;
        ?>
        <tr>
            <td class="renzo-table-data"><?= $user['username']; ?></td>
            <td class="renzo-table-data"><?= $user['email']; ?></td>
            <td class="renzo-table-data">
            <?php
            if($user['status'] == '0'){
            ?>
                <a href="../server/approve-user.php?username=<?= $user['username']; ?>"><button class="renzo-primary-btn">Approve</button></a>
                <?php } ?>
                <?php
                if($user['status'] == '1'){
                    echo '<p class="renzo-approved"> Approved </p>';
                }
                ?>
                <a href="../server/delete-user.php?userId=<?= $userId; ?>">
                    <button type="button" class="renzo-delete-btn" onclick="return confirm('Are you sure you want to delete <?= $userId; ?>?')" name="delete-account">Delete</button>
                </a>
            </td>
        </tr>
        <?php }
        } 
        if(!$found_clients){
            echo '<tr><td colspan="3" class="renzo-table-data" style="padding: 5em; text-transform: uppercase;"><strong>No clients found</strong></td></tr>';
        } ?>
    </table>
</body>
</html>
