

<div class="row my-2">
    <style>

        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>

    <div class="col px-5 col-12 col-md-4 col-lg-4">
        <h2 class="text-dark">About Us</h2>
        <p>
            Eagles saving group is  a dedicated youth group  aimed at saving money
            and providing affordable loans to their members we also are looking forward to
            providing loans to others members whom will be able to join us and save their money with us.
            This is a future plan that we a have for Eagle.

        </p>
       <div class=" mt-3">
            <h5>Contact us</h5>
            <p>Phone : 0701713296</p>
            <p>Phone : 0728548760</p>
            <p>Email : abukbt13@gmail.com</p>
        </div>

    </div>
    <div class="col px-5 col-12  col-md-4 col-lg-4">
        <h3>Motto</h3>
        <p>Soaring to greater height</p>

        <h4>Mission:</h4>
        <p>
            "To empower the dreams of young individuals and foster financial independence by providing accessible and innovative savings and borrowing solutions,
            helping them achieve their short-term goals and long-term aspirations."
        </p>
       <h4> Vision:</h4>
       <p>
           "To become the preferred financial partner for the young generation,
           recognized for our commitment to financial education, personalized services,
           and inclusive opportunities, leading them towards a secure and prosperous future."
       </p>
    </div>
    <div class="col col-12 px-5 col-md-4 col-lg-4">
        <h2>Contact Us</h2>

        <form action="../processor.php" method="post">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="email">Phone:</label>
            <input type="number" id="phone" name="phone" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <button type="submit" name="inquire" class="float-end">Send</button>
        </form>
    </div>
</div>

<hr>
<div class="mb-3 px-2 d-flex align-items-center justify-content-center">
    <p class="text-center">
        Designed and developed by <span class="ms-2 text-primary">Eagles developers</span> Email: <span class=" mx-2 text-primary">abukbt13@gmail.com</span> phone: <span class="text-primary">0728548760</span>

    </p>

</div>
