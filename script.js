document.getElementById('fitness-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const age = document.getElementById('age').value;
    const weight = document.getElementById('weight').value;
    const height = document.getElementById('height').value;
    const goal = document.getElementById('goal').value;
    
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'process.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            document.getElementById('result').innerHTML = this.responseText;
        } else {
            document.getElementById('result').innerHTML = 'An error occurred. Please try again.';
        }
    };
    xhr.send('age=' + age + '&weight=' + weight + '&height=' + height + '&goal=' + goal);
});
