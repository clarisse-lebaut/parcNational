<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Example</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <form method="post" action="/parcNational/registerForm">
      <div class="row g-3">
        <!-- Lastname -->
        <div class="col-md-6">
          <label for="inputLastname" class="form-label">Lastname</label>
          <input type="text" name="lastname" class="form-control" id="inputLastname" placeholder="Your lastname" required>
        </div>

        <!-- Firstname -->
        <div class="col-md-6">
          <label for="inputFirstname" class="form-label">Firstname</label>
          <input type="text" name="firstname" class="form-control" id="inputFirstname" placeholder="Your firstname" required>
        </div>

        <!-- Email -->
        <div class="col-md-6">
          <label for="inputEmail" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Your email" required>
        </div>

        <!-- Password -->
        <div class="col-md-6">
          <label for="inputPassword" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required>
        </div>

        <!-- Repeat Password -->
        <div class="col-md-6">
          <label for="inputRepeatPassword" class="form-label">Repeat Password</label>
          <input type="password" name="repeatpassword" class="form-control" id="inputRepeatPassword" placeholder="Repeat password" required>
        </div>

        <!-- Phone -->
        <div class="col-md-6">
          <label for="inputPhone" class="form-label">Phone</label>
          <input type="tel" name="phone" class="form-control" id="inputPhone" placeholder="Your phone number" required>
        </div>

        <!-- Address -->
        <div class="col-12">
          <label for="inputAddress"  class="form-label">Address</label>
          <input type="text" name="adress" class="form-control" id="inputAddress" placeholder="1234 Main St" required>
        </div>

        <!-- City -->
        <div class="col-md-6">
          <label for="inputCity" class="form-label">City</label>
          <input type="text" name="city" class="form-control" id="inputCity" placeholder="City" required>
        </div>

        <!-- Zipcode -->
        <div class="col-md-6">
          <label for="inputZipcode"  class="form-label">Zipcode</label>
          <input type="text" name="zipcode" class="form-control" id="inputZipcode" placeholder="Zipcode" required>
        </div>

        <!-- Submit Button -->
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
  </div>

</body>
</html>
