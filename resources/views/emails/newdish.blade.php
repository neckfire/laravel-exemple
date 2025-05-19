<body>
<h1>Dish Created Successfully</h1>
<p>We are pleased to inform you that your dish has been created successfully.</p>
<p>Here is the image of your dish:</p>
<img height="200" width="300" src="{{ "storage/" . $dish->image }}">
<p>You can view your dish and manage your menu on our <a href="{{ env("app_url") }}">Laravel application</a>.</p>
<p>Thank you for using our service.</p>
<p>Best regards,</p>
<p>The Team</p>
</body>
