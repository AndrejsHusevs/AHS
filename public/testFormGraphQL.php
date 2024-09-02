<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GraphQL TESTING PAGE</title>
</head>
<body>
    <h1>GraphQL TESTING PAGE</h1>
   
    <form id="graphqlForm">
        <textarea id="queryInput" name="query" rows="10" cols="80">{ echo(message: "Hello World") }</textarea><br />
        <input type="submit" value="Send Query" />
    </form>

    <script>
        document.getElementById('graphqlForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            var query = document.getElementById('queryInput').value;
            var jsonQuery = JSON.stringify({ query: query });

            fetch('/ahs/graphql', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: jsonQuery
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                document.body.insertAdjacentHTML('beforeend', '<pre>' + JSON.stringify(data, null, 2) + '</pre>');
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        });
    </script>

    <hr>



</body>
</html>