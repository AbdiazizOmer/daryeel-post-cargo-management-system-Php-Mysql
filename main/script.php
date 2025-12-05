<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/app.js"></script>
    
<!-- Need: Apexcharts -->
<script src="assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="assets/js/pages/simple-datatables.js"></script>
<script src="assets/js/jquary/jquery-3.7.0.min.js"></script>

<link rel="stylesheet" href="assets/css/pages/fontawesome.css">
<link rel="stylesheet" href="assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">

<script src="assets/js/sweet/sweetalert2@11.js"></script>
<script src="../../daryeel1/js/sidebar.js"></script>
<script src="assets/js/iziToast-master/dist/js/iziToast.min.js"></script>
<!-- DataTables  & Plugins -->




 <script>
    $(document).ready(function() {
        $(function() {
        // Get the input field
        var input = $(".validate");

        // Create a regular expression to match only letters and spaces
        var regex = /^[a-zA-Z\s]+$/;

        // Add a listener to the input field
        input.on("keyup blur", function() {
            // Check if the value of the input field matches the regular expression
            if (!regex.test(input.val())) {
            // Set the input field's value to an empty string
            input.val("");
            }
        });
        });
    });
 </script>
 <script>
    $(document).ready(function() {
        $(function() {
            // Get the input fields with multiple classes
            var input = $(".numvalidate");

            // Add a listener to the input fields
            input.on("keyup blur", function() {
                // Check if the input contains any non-letter characters
                if (!/^[0-9]+$/.test($(this).val())) {
                    // Clear the input field
                    $(this).val("");
                }
            });
        });
    });
 </script>