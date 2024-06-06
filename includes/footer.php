<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (isset($_SESSION["alert"]) && $_SESSION["alert"] != '') {
    ?>
        <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: '<?php echo $_SESSION["alert_code"];  ?>',
                    title: '<?php echo $_SESSION["alert"]; ?>',
                })
        </script>
    <?php
        unset($_SESSION["alert"]);
    }
    ?>
    <footer class="bg-success text-white text-center">
        <p class="p-0 m-0">
            &copy; 2023. Copyright: Burol Enrollment System
        </p>
    </footer>
    <script src="../sweetalert/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="../sweetalert/sweetalert2.all.js"></script>

</body>

</html>