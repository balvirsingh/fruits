
const checkboxes = document.querySelectorAll('.favorite-checkbox');
checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', function () {
        const fruitId = this.dataset.id;
        const isFavorite = this.checked;
        // Make an AJAX request to add/remove the fruit from favorites
        const xhr = new XMLHttpRequest();
        var divElement = document.getElementById("mark_favorite_route");
        var url = divElement.innerHTML.replace("/0/", "/"+fruitId+"/");
        xhr.open('POST', url+"?isFavorite="+isFavorite);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Handle success
                const response = JSON.parse(xhr.responseText);
                
                alert(response.msg);
                if (!response.status) {
                  checkbox.checked = !isFavorite;
                }
            } else {
                // Handle error
                alert('An error occurred while marking the fruit as favorite.');
            }
        };
        
        const payload = JSON.stringify({
            isFavorite: isFavorite
        });
        xhr.send(payload);
    });
});