<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toastr.js Example</title>
    <!-- Include Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<body>

<button onclick="showSuccess()">Show Success</button>
<button onclick="showError()">Show Error</button>
<button onclick="showWarning()">Show Warning</button>
<button onclick="showInfo()">Show Info</button>

<!-- Include jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Include Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    // Function to show success notification
    function showSuccess() {
        toastr.success('Success notification', 'Success');
    }

    // Function to show error notification
    function showError() {
        toastr.error('Error notification', 'Error');
    }

    // Function to show warning notification
    function showWarning() {
        toastr.warning('Warning notification', 'Warning');
    }

    // Function to show info notification
    function showInfo() {
        toastr.info('Info notification', 'Info');
    }
</script>

</body>
</html>
