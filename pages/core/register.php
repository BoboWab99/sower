<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
   <link rel="stylesheet" href="../../css/app.css">
</head>

<body>

   <!-- https://stackoverflow.com/questions/18022809/how-to-solve-error-mysql-shutdown-unexpectedly -->
   <!-- https://stackoverflow.com/questions/768431/how-do-i-make-a-redirect-in-php -->

   <div class="py-5">
      <div class="col-10 col-md-7 col-lg-5 col-xl-4 mx-auto">
         <h3 class="mb-4">Register</h3>

         <form class="d-grid gap-3" action="../../logic/register.php" method="POST" id="form">
            <div class="form-field">
               <label for="username">Username:</label>
               <input class="form-control" type="text" name="username" id="username" pattern="[a-zA-Z0-9_]{4,}" placeholder="Enter Your Username" required autofocus>
            </div>

            <div class="d-flex flex-wrap gap-2">
               <div class="form-field flex-grow-1">
                  <label for="username">First name:</label>
                  <input class="form-control" type="text" name="firstName" id="firstName" pattern="[a-z,A-Z,\s,'-,]{2,}" placeholder="Enter Your first name" required>
               </div>
               <div class="form-field flex-grow-1">
                  <label for="username">Last name:</label>
                  <input class="form-control" type="text" name="lastName" id="lastName" pattern="[a-z,A-Z,\s,'-,]{2,}" placeholder="Enter Your last name" required>
               </div>
            </div>

            <div class="form-field">
               <label for="email">Email:</label>
               <input class="form-control" type="email" name="email" id="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" placeholder="Enter Your Email" required>
            </div>

            <div class="form-field">
               <label for="phoneNumber">Phone number:</label>
               <input class="form-control" type="number" name="phoneNumber" id="phoneNumber" min="10" placeholder="Enter Your Number" required>
            </div>

            <div class="form-field">
               <label for="password">Password:</label>
               <input class="form-control" type="password" name="password1" id="password1" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}" placeholder="Enter the password" required>
            </div>

            <div class="form-field">
               <label for="password">Confirm Password:</label>
               <input class="form-control" type="password" name="password2" id="password2" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}" placeholder="Enter the password" required>
            </div>

            <div class="d-flex gap-2">
               <button class="btn btn-primary" type="submit">Submit</button>
               <button class="btn btn-outline-primary" type="reset">Reset</button>
            </div>
         </form>
      </div>
   </div>


   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

   <script>
      // some form validation
      const form = document.getElementById('form')
      const password1 = document.getElementById('password1')
      const password2 = document.getElementById('password2')

      form.addEventListener('submit', (e) => {
         e.preventDefault()

         if (password1.value != password2.value) {
            password2.setCustomValidity('Passwords do not match!')
            password2.reportValidity()
            return
         } else {
            password2.setCustomValidity('')
         }

         form.submit()
      })
   </script>

</body>

</html>