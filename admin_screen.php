<!-- Source tab -->
<div id="sourceDiv">
    TEST
</div>

<button onclick="reflectContent()">Reflect Content</button>

<script>
function reflectContent() {
    var sourceDiv = document.getElementById('sourceDiv');
    var clonedContent = sourceDiv.cloneNode(true);

    // Assuming you have another tab with an element with id 'destinationTab'
    var destinationTab = window.open('cs_screen.php'); // Open the destination tab
    destinationTab.onload = function() {
        var destinationDiv = destinationTab.document.getElementById('destinationDiv');
        destinationDiv.innerHTML = '';
        destinationDiv.appendChild(clonedContent);
    };
}
</script>
