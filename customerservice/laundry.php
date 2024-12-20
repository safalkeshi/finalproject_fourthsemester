<center>
    <div id="laundrysection" class="container mt-5">
        <form action="">
            <label for="">We offer a variety of laundry services to meet your needs:</label>
            <ul class="list-group">
                <li class="list-group-item" data-service="dry_cleaning">Dry Cleaning</li>
                <li class="list-group-item" data-service="regular_laundry">Regular Laundry</li>
                <li class="list-group-item" data-service="ironing">Ironing Services</li>
                <li class="list-group-item" data-service="special_fabric">Special Fabric Care</li>
            </ul>

            <!-- Select Laundry Service Type Dropdown -->
            <div id="hide2" class="mt-3" style="display: none;">
                <div class="form-group">
                    <label for="laundry_service">Select Laundry Service:</label>
                    <select class="form-control" name="laundry_service" id="laundry_service" required>
                        <option value="dry_cleaning">Dry Cleaning</option>
                        <option value="regular_laundry">Regular Laundry</option>
                        <option value="ironing">Ironing Services</option>
                        <option value="special_fabric">Special Fabric Care</option>
                    </select>
                </div>

                <!-- Additional Fields for Laundry Request -->
                <div class="form-group">
                    <label for="num_cloth">Number of Clothes:</label>
                    <input type="number" class="form-control" name="num_cloth" id="num_cloth" required />
                </div>

                <div class="form-group">
                    <label for="event_date">Event Date:</label>
                    <input type="date" class="form-control" name="event_date" id="event_date" required />
                </div>

                <div class="form-group">
                    <label for="additional_request">Additional Request:</label>
                    <textarea class="form-control" name="additional_request" id="additional_request" placeholder="Add any special request"></textarea>
                </div>

                <!-- Username and Password Fields -->
                <div class="form-group">
                    <label for="user_id">User ID:</label>
                    <input type="text" class="form-control" name="user_id" id="user_id" required />
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" required />
                </div>

                <button type="submit" class="btn btn-primary btn-block">Submit Laundry Request</button>
            </div>
        </form>
    </div>
</center>

<!-- Bootstrap CSS link for styling -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<style>
    /* Laundry Section Styling */
    #laundrysection {
        background-color: #ecf0f1;
        border-radius: 10px;
        padding: 30px;
        width: 80%;
        max-width: 500px;
        margin: 40px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        text-align: left;
    }

    #laundrysection label {
        font-size: 16px;
        color: #2c3e50;
        display: block;
        margin-bottom: 15px;
    }

    #laundrysection .list-group-item {
        cursor: pointer;
    }

    #laundrysection .list-group-item:hover {
        background-color: #3498db;
        color: white;
    }

    #laundrysection .form-group {
        margin-bottom: 15px;
    }

    #laundrysection button {
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

    #laundrysection button:hover {
        background-color: #34495e;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        #laundrysection {
            width: 90%;
        }
    }

    #hide2 {
        display: none;
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Laundry Section toggle logic
    let laundryLi = document.querySelectorAll('#laundrysection .list-group-item');
    const hide2 = document.getElementById('hide2');
    for (let l = 0; l < laundryLi.length; l++) {
        laundryLi[l].addEventListener('click', () => {
            if (hide2.style.display === 'none' || hide2.style.display === '') {
                hide2.style.display = 'block';
            } else {
                hide2.style.display = 'none';
            }
        });
    }
</script>