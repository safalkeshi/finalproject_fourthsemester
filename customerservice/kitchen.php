<center>
    <div id="kitchenformsection">
        <form action="">
            <label for="">Enjoy our kitchen service with a variety of delicious options:</label>
            <ul class="list-group">
                <li class="list-group-item" data-meal="breakfast">Breakfast</li>
                <li class="list-group-item" data-meal="lunch">Lunch</li>
                <li class="list-group-item" data-meal="dinner">Dinner</li>
                <li class="list-group-item" data-meal="snacks">Snacks and Beverages</li>
                <li class="list-group-item" data-meal="special">Special Dietary Meals</li>
            </ul>

            <!-- Select Meal Type Dropdown -->
            <div id="hide" class="mt-3" style="display: none;">
                <div class="form-group">
                    <label for="meal_type">Select Meal Type:</label>
                    <select class="form-control" name="meal_type" id="meal_type" required>
                        <option value="breakfast">Breakfast</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                        <option value="snacks">Snacks and Beverages</option>
                        <option value="special">Special Dietary Meals</option>
                    </select>
                </div>

                <!-- Additional Fields -->
                <div class="form-group">
                    <label for="num_guests">Number of Guests:</label>
                    <input type="number" class="form-control" name="num_guests" id="num_guests" required />
                </div>

                <div class="form-group">
                    <label for="event_date">Event Date:</label>
                    <input type="date" class="form-control" name="event_date" id="event_date" required />
                </div>

                <div class="form-group">
                    <label for="additional_request">Additional Request:</label>
                    <textarea class="form-control" name="additional_request" id="additional_request" placeholder="Add any special request"></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Submit Kitchen Request</button>
            </div>
        </form>
    </div>
</center>

<!-- External Bootstrap CSS link (for full functionality) -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<style>
    /* Kitchen Form Section Styling */
    #kitchenformsection {
        background-color: #ecf0f1;
        border-radius: 10px;
        padding: 30px;
        width: 80%;
        max-width: 500px;
        margin: 40px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        text-align: left;
    }

    #kitchenformsection label {
        font-size: 16px;
        color: #2c3e50;
        display: block;
        margin-bottom: 15px;
    }

    #kitchenformsection .list-group-item {
        cursor: pointer;
    }

    #kitchenformsection .list-group-item:hover {
        background-color: #3498db;
        color: white;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        #kitchenformsection {
            width: 90%;
        }
    }

    #hide {
        display: none;
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Kitchen Form Logic for toggling
    let kitchenli = document.querySelectorAll('#kitchenformsection .list-group-item');
    const hide = document.getElementById('hide');
    for (let k = 0; k < kitchenli.length; k++) {
        kitchenli[k].addEventListener('click', () => {
            if (hide.style.display === 'none' || hide.style.display === '') {
                hide.style.display = 'block';
            } else {
                hide.style.display = 'none';
            }
        });
    }
</script>