<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Login</title>
</head>
<body>
   
   <div class="position-absolute top-50 start-50 translate-middle">
     <div class="card" style="width: 18rem;">
       <div class="card-body">
         <form action="assets/php/login.php" method="post">
           <div class="mb-3">
             <label for="username" class="form-label">Username</label>
             <input type="username" class="form-control" name="username" placeholder="Username" required>
             <div id="emailHelp" class="form-text">gunakan username jangan gunakan email</div>
           </div>
           <div class="mb-3">
             <label for="password" class="form-label">Password</label>
             <input type="password" class="form-control" name="password" placeholder="Password" required>
           </div>
           <div class="mb-3 form-check">
             <input type="checkbox" class="form-check-input" name="remember" id="remember" onclick="rememberMe()">
             <label class="form-check-label" for="remember">Check me out</label>
           </div>
           <button type="submit" class="btn btn-primary w-100">Submit</button>
           <div class="py-3"></div>
           belum punya akun? <a href="register.php">register </a>
         </form>
       </div>
     </div>
   </div>
   
   <script>
     function rememberMe() {
       if (document.getElementById('remember').checked) {
         localStorage.setItem('remember', 'true');
       } else {
         localStorage.removeItem('remember');
       }
     }
   </script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>