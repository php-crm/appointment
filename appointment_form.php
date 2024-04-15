<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="time"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        #message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 4px;
        }
        #message.success {
            background-color: #d4edda;
            color: #155724;
        }
        #message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Appointment Booking</h2>
        <form id="appointmentForm">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br>
            
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            
            <label for="phone">Phone:</label><br>
            <input type="tel" id="phone" name="phone" required><br>
            
            <label for="date">Date:</label><br>
            <input type="date" id="date" name="date" required><br>
            
            <label for="time">Time:</label><br>
            <input type="time" id="time" name="time" required><br>
            
            <label for="service">Service:</label><br>
            <select id="service" name="service" required>
                <option value="">Select Service</option>
                <option value="consultation">Consultation</option>
                <option value="checkup">Checkup</option>
                <option value="treatment">Treatment</option>
                <!-- Add more options as needed -->
            </select><br>
            
            <label for="comment">Comment:</label><br>
            <textarea id="comment" name="comment"></textarea><br>
            
            <input type="submit" value="Book Appointment">
        </form>
        <div id="message"></div> <!-- Display success or error message here -->
    </div>

    <script>
        document.getElementById("appointmentForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the form from submitting normally
            
            var formData = new FormData(this); // Get form data
            
            // Send form data via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "appointment_submit.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.messages && response.messages.success) {
                            // Display success message
                            document.getElementById("message").className = "success";
                            document.getElementById("message").innerHTML = response.messages.success;
                            // Clear the form
                            document.getElementById("appointmentForm").reset();
                        } else if (response.messages && response.messages.error) {
                            // Display error message
                            document.getElementById("message").className = "error";
                            document.getElementById("message").innerHTML = response.messages.error;
                        } else {
                            // Unknown error occurred
                            document.getElementById("message").className = "error";
                            document.getElementById("message").innerHTML = "Unknown error occurred.";
                        }
                    } else {
                        // Request failed
                        document.getElementById("message").className = "error";
                        document.getElementById("message").innerHTML = "Error: " + xhr.statusText;
                    }
                }
            };
            xhr.send(formData); // Send form data
        });
    </script>
</body>
</html>
