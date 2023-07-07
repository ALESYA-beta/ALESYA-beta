<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Register</title>
</head>
<body>
   
   <div class="position-absolute top-50 start-50 translate-middle">
     <div class="card" style="width: 18rem;">
       <div class="card-body">
         <form action="assets/php/register.php" method="post" enctype="multipart/form-data">
           <div class="mb-3">
             <label for="name" class="form-label">Name</label>
             <input type="text" class="form-control" name="name" placeholder="Name" required>
           </div>
           <div class="mb-3">
             <label for="username" class="form-label">Username</label>
             <input type="email" class="form-control" name="username" placeholder="Username" required>
             <div id="emailHelp" class="form-text">Jangan gunakan email</div>
           </div>
           <div class="mb-3">
             <label for="password" class="form-label">Password</label>
             <input type="password" class="form-control" name="password" placeholder="Password" required>
           </div>
           <div class="mb-3">
             <label for="exampleInputEmail1" class="form-label">Profile</label>
             <input type="file" class="form-control" name="profile_picture" accept="image/*" required>
           </div>
           <button type="submit" class="btn btn-primary w-100">Submit</button>
         </form>
       </div>
     </div>
   </div>
   
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>