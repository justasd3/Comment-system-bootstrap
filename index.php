<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Stylish Reply System</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <!-- Simple line icons-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/custom.css" rel="stylesheet" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

</head>

<body id="page-top">
    <!-- Navigation-->
    <a class="menu-toggle rounded" href="#"><i class="fas fa-bars"></i></a>
    <nav id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand"><a href="#page-top">Start Bootstrap</a></li>
            <li class="sidebar-nav-item"><a href="#page-top">Home</a></li>
            <li class="sidebar-nav-item"><a href="#about">About</a></li>
            <li class="sidebar-nav-item"><a href="#services">Services</a></li>
            <li class="sidebar-nav-item"><a href="#portfolio">Portfolio</a></li>
            <li class="sidebar-nav-item"><a href="#contact">Contact</a></li>
        </ul>
    </nav>
    <!-- Header-->
    <header class="masthead d-flex align-items-center">
        <div class="container px-4 px-lg-5 text-center">
            <h1 class="mb-1">Stylish Reply System</h1>
            <h3 class="mb-5"><em>A Free Bootstrap Theme by Start Bootstrap</em></h3>
            <a class="btn btn-primary btn-xl" href="#about">Find Out More</a>
        </div>
    </header>
    <!-- About-->
    <section class="create_comment" id="about">
        <h1 class="title">Write a comment!</h1>
            <div class="container mt-5">
                <form id="input_form" method="POST">
                    <div class="contact-form row">
                        <div class="form-field col-sm-6">
                            <input type="text" class="input-text" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" name="email" id="Email" required>
                        </div>
                        <div class="form-field col-sm-6">
                            <input type="text" class="input-text" placeholder="Name" name="name" id="Name" required>
                        </div>
                        <div class="form-field col-sm-12">
                            <input class="input-text-comment" type="text" placeholder="Comment" id="Comment" name="comment_data" required>
                        </div>
                        <div class="form-field col-sm-12">
                            <input type="hidden" name="id" id="id" value="0" />
                            <input type="submit" name="Submit" id="Submit" class="btn btn-secondary" value="Submit" />
                        </div>
                    </div>
                </form>
            </div>
            <span id="comment_message"></span>
            <br />
            <div id="display_comment"></div>
            </div>
    </section>

   


</body>

</html>

<script>
    $(document).ready(function() {
        $('#input_form').on('submit', function(event) {
            event.preventDefault();

            var form_data = $('#input_form').serialize();
            $.post("insert_comment.php", form_data, function(data) {
                if (data.error != '') {
                    $('#input_form')[0].reset();
                    $('#comment_message').html(data.error);
                    $('#id').val('0');
                    load_comment();
                }
            })
            // $.ajax({
            //     url: "insert_comment.php",
            //     method: "POST",
            //     data: form_data,
            //     dataType: "json",
            //     success: function(data) {
            //         alert(form_data);
            //         if (data.error != '') {
            //             $('#input_form')[0].reset();
            //             $('#comment_message').html(data.error);
            //             $('#id').val('0');
            //             // load_comment();
            //         }
            //     }
            // })
        });
        load_comment();

        $(document).on('click', '.reply', function() {
            var id = $(this).attr("id");
            $('#id').val(id);
            $('#comment_name').focus();
        });

    });

    function load_comment() {
        $.ajax({
            url: "fetch_comment.php",
            method: "POST",
            success: function(data) {
                $('#display_comment').html(data);
            }
        })
    }

    function showform(id) {
        var x = document.getElementById("form-" + id);
        if (x.style.display == "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }


    function insertfunc(id) {
        event.preventDefault();
        var form_data = $('#input_form-' + id).serialize();
        // var form_data = $(this).serialize();

        $.post("insert_comment.php", form_data, function(data) {
            // alert(form_data);
            if (data.error != '') {
                $('#input_form')[0].reset();
                $('#comment_message').html(data.error);
                $('#id').val('0');
                load_comment();
            }
        })

        // $.ajax({
        //     url: "insert_comment.php",
        //     method: "POST",
        //     data: form_data,
        //     dataType: "JSON",
        //     success: function(data) {
        //         if (data.error != '') {
        //             $('#input_form')[0].reset();
        //             $('#comment_message').html(data.error);
        //             $('#id').val('0');
        //         }
        //     }
        // })
        load_comment();



    }
</script>