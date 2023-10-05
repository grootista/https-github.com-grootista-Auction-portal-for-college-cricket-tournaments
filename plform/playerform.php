<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cricket Player Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Cricket Player Registration</h1>
        <form id="myForm"  action="formprocess.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="usn">USN:</label>
                <input type="text" name ="usn" id="usn" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="branch">Branch:</label>
                <select id="branch" name ="branch" class="form-control">
                    <option value="CSE">CSE</option>
                    <option value="ISE">ISE</option>
                    <option value="AIDS">AIDS</option>
                    <option value="AIML">AIML</option>
                    <option value="MCA">MCA</option>
                </select>
            </div>
            <div class="form-group">
                <label for="year">Year:</label>
                <select id="year" name="year" class="form-control">
                    <option value="1st">1</option>
                    <option value="2nd">2</option>
                    <option value="3rd">3</option>
                    <option value="4th">4</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" name ="phone" id="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role" class="form-control">
                    <option value="LeftHand Batsman">LeftHand Batsman</option>
                    <option value="RightHand Batsman">RightHand Batsman</option>
                    <option value="WicketKeeperBatsman">WicketKeeperBatsman</option>
                    <option value="Spinner">Spinner</option>
                    <option value="Seamer">Seamer</option>
                    <option value="AllRounder">AllRounder</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image:(use jpg or png only and make usn as the image name)</label>
                <input type="file" id="image" name="image" class="form-control-file" accept="image/*" required>
            </div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmationModal">Submit</button>
            
        </form>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel">Please Confirm Your Details</h5>
                </div>
                <div>
                    <h6 class="modal-title">Click on "Show Details" button to view details</h6>
                </div>
                <br>
                <br>
                <br>
                <button type="button" class="btn btn-primary" id="confirmSubmit">Show details</button>
            </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="confirmName"></span></p>
                    <p><strong>Branch:</strong> <span id="confirmBranch"></span></p>
                    <p><strong>Year:</strong> <span id="confirmYear"></span></p>
                    <p><strong>USN:</strong> <span id="confirmUSN"></span></p>
                    <p><strong>Phone:</strong> <span id="confirmPhone"></span></p>
                    <p><strong>Role:</strong> <span id="confirmRole"></span></p>
                    <p><strong>Image:</strong></p>
                    <img src="" id="confirmImage" alt="Image Preview" style="max-width: 100%; max-height: 300px;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="submitDetailsButton">Submit details</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- JavaScript to populate modal with form data and handle form submission -->
    <script>
  $(document).ready(function() {
    $("#confirmSubmit").click(function() {
      var name = $("#name").val();
      var image = $("#image")[0].files[0]; // Get the selected image file
      var branch = $("#branch").val();
      var year = $("#year").val();
      var usn = $("#usn").val();
      var phone = $("#phone").val();
      var role = $("#role").val();

      // Display the selected image in the modal
      if (image) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $("#confirmImage").attr("src", e.target.result);
        };
        reader.readAsDataURL(image);
      }
      if (name === "" || usn === "" || branch === "" || year === "" || phone === "" || role === "" || !image) {
        alert("Please fill in all fields and select an image.");
        return;
      }
      $("#confirmName").text(name);
      $("#confirmBranch").text(branch);
      $("#confirmYear").text(year);
      $("#confirmUSN").text(usn);
      $("#confirmPhone").text(phone);
      $("#confirmRole").text(role);
    });

    // Handle form submission
    $("#submitDetailsButton").click(function() {
      // Create a form element dynamically
    //   var form = document.createElement("form");
    //   form.method = "POST";
    //   form.enctype="multipart/form-data";
    //   form.action = "coord.php";

    //   // Create input fields for each data
    //   var nameInput = document.createElement("input");
    //   nameInput.type = "hidden";
    //   nameInput.name = "name";
    //   nameInput.value = $("#name").val();
    //   form.appendChild(nameInput);

    //   var branchInput = document.createElement("input");
    //   branchInput.type = "hidden";
    //   branchInput.name = "branch";
    //   branchInput.value = $("#branch").val();
    //   form.appendChild(branchInput);

    //   var yearInput = document.createElement("input");
    //   yearInput.type = "hidden";
    //   yearInput.name = "year";
    //   yearInput.value = $("#year").val();
    //   form.appendChild(yearInput);

    //   var usnInput = document.createElement("input");
    //   usnInput.type = "hidden";
    //   usnInput.name = "usn";
    //   usnInput.value = $("#usn").val();
    //   form.appendChild(usnInput);

    //   var phoneInput = document.createElement("input");
    //   phoneInput.type = "hidden";
    //   phoneInput.name = "phone";
    //   phoneInput.value = $("#phone").val();
    //   form.appendChild(phoneInput);

    //   var roleInput = document.createElement("input");
    //   roleInput.type = "hidden";
    //   roleInput.name = "role";
    //   roleInput.value = $("#role").val();
    //   form.appendChild(roleInput);

    //   // Handle image file
    //   var imageInput = document.createElement("input");
    //   imageInput.type = "file";
    //   imageInput.name = "image";
    //   form.appendChild(imageInput);

    //   // Submit the form
    //   document.body.appendChild(form);
     $("#myForm").submit();
    });
  });
</script>
