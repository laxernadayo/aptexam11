
<?php 
require_once('config/database.php');
?>
<!doctype html>
<html lang="en">
    <head>
        <title>APTITUDE EXAM NUMBER 11</title>
        <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.13.1/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="js/jquery-ui-1.13.1/jquery-ui.min.css"></style>
    </head>
    <body>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <p>
                <label for="name">Full Name:</label>
                <input type="text" name="name" id="name" pattern="[a-zA-Z .,-]+" required>
            </p>
            <p>
                <label for="email">Email Address:</label>
                <input type="email" name="email" id="email" required>
            </p>
            <p>
                <label for="contactno">Contact Number:</label>
                <input type="text" name="contactno"  id="contactno" pattern="[0-9]{11}" placeholder="09672138622" required>
            </p>
            <p>
                <label for="birthdate">Birth Date:</label>
                <input type="text" name="birthdate"  id="birthdate" autocomplete="off" required>
            </p>
            <p>
                <label for="age">Age:</label>
                <input type="text" name="age"  id="age" readonly>
            </p>
            <p>
                <label for="gender">Gender:</label>
                <select name="gender" id="gender">
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </p>
            <p><input type="submit" name="submit" value="Submit"></p>
        </form>
        <script>
            $(function() {
                $( "#birthdate" ).datepicker({
                    onSelect: function(value, ui) {
                        var today = new Date(), 
                            age = today.getFullYear() - ui.selectedYear;
                        $('#age').val(age);
                    },
                    dateFormat: 'yy-mm-dd',
                    maxDate: '+0d',
                    changeMonth: true,
                    changeYear: true,
                    defaultDate: '-30yr',
                });

                $('form').submit(function(e) {
                    e.preventDefault();
                    var form = $(this);

                    $.ajax({
                        type: "POST",
                        url: "process_data.php",
                        data: form.serialize(),
                        success: function(response) {
                            obj = JSON.parse(response);
                            if (obj.hasOwnProperty('noty')) {
                                alert(obj.noty.msg);
                                if (obj.noty.status == 'success') {
                                    window.location.replace('index.php');
                                }
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>