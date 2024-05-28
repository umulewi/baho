<button id="loadMoreProviders">More</button>
<script>

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("loadMoreProviders").addEventListener("click", function() {
        console.log("Load more button clicked");
        let currentCount = document.querySelectorAll("#providerTableBody tr").length;
        console.log("Current count:", currentCount);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "load_more_providers.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                console.log("Response received:", this.responseText);
                const newRows = document.createElement("tbody");
                newRows.innerHTML = this.responseText;
                const rows = newRows.querySelectorAll("tr");
                rows.forEach(row => {
                    document.getElementById("providerTableBody").appendChild(row);
                });
            } else if (this.readyState === XMLHttpRequest.DONE) {
                console.error("Failed to load more providers:", this.status, this.statusText);
            }
        };

        xhr.send("offset=" + currentCount);
    });
});

</script>