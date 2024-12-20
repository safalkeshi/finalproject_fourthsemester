<center>
    <div id="banquetsection" class="container mt-5">
        <label for="">Our hotel offers a variety of banquet options for your events:</label>
        <form action="mainpage.php" method="post">
            <!-- Select Banquet Event Type -->
            <div class="form-group">
                <label for="event_type">Select Event Type:</label>
                <select class="form-control" name="event_type" id="event_type">
                    <option value="wedding">Wedding Receptions</option>
                    <option value="corporate">Corporate Meetings</option>
                    <option value="birthday">Birthday Parties</option>
                    <option value="conferences">Conferences</option>
                    <option value="other">Other Special Events</option>
                </select>
            </div>

            <!-- Number of Guests -->
            <div class="form-group">
                <label for="num_guests">Number of Guests:</label>
                <input type="number" class="form-control" name="num_guests" id="num_guests" required />
            </div>

            <!-- Event Date -->
            <div class="form-group">
                <label for="event_date">Event Date:</label>
                <input type="date" class="form-control" name="event_date" id="event_date" required />
            </div>

            <!-- Additional Request -->
            <div class="form-group">
                <label for="additional_request">Additional Request:</label>
                <textarea class="form-control" name="additional_request" id="additional_request" placeholder="Add any special request"></textarea>
            </div>

            <!-- User ID and Password -->
            <div class="form-group">
                <label for="user_id">User ID:</label>
                <input type="text" class="form-control" name="user_id" id="user_id" required />
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required />
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit Banquet Request</button>
        </form>
    </div>
</center>

<!-- Bootstrap CSS link for styling -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<style>
    /* Banquet Section Styling */
    #banquetsection {
        background-color: #ecf0f1;
        border-radius: 10px;
        padding: 30px;
        width: 80%;
        max-width: 500px;
        margin: 40px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        text-align: left;
    }

    #banquetsection label {
        font-size: 16px;
        color: #2c3e50;
        display: block;
        margin-top: 15px;
    }

    #banquetsection select,
    #banquetsection input[type="number"],
    #banquetsection input[type="date"],
    #banquetsection textarea {
        width: 100%;
        padding: 10px;
        margin-top: 8px;
        border: 1px solid #bdc3c7;
        border-radius: 5px;
        background-color: #fff;
        color: #2c3e50;
        font-size: 16px;
    }

    #banquetsection select:focus,
    #banquetsection input[type="number"]:focus,
    #banquetsection input[type="date"]:focus,
    #banquetsection textarea:focus {
        border-color: #3498db;
        outline: none;
    }

    #banquetsection textarea {
        height: 80px;
        resize: vertical;
    }

    #banquetsection button {
        width: 100%;
        padding: 12px;
        margin-top: 20px;
        background-color: #2c3e50;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #banquetsection button:hover {
        background-color: #34495e;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        #banquetsection {
            width: 90%;
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>