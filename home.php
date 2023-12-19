<!DOCTYPE html>
<html>
<head>
    <title>Request Evaluation</title>
</head>
<body>
    <h1>Request Evaluation</h1>
    <form action="submit_request.php" method="post" enctype="multipart/form-data">
        <label for="comment">Comment Box:</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50"></textarea><br><br>
        
        <label for="file">Upload Image (PNG or JPEG only):</label><br>
        <input type="file" id="file" name="file"><br><br>
        
        <label for="contact">Preferred Contact Method:</label>
        <select id="contact" name="contact">
            <option value="phone">Phone</option>
            <option value="email">Email</option>
        </select><br><br>
        
        <input type="submit" value="Submit Request">
    </form>
</body>
</html>
