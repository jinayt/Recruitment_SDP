<?php
include_once "header.php";
require_once "dbconnection.php";
$query = "select p.First_name,
  p.Last_name,
  CASE p.Gender WHEN 'M' THEN 'Male' WHEN 'F' THEN 'Female' WHEN 'O' THEN 'Other' else p.Gender end as Gender,
  p.Date_of_birth ,
  p.Mobile_no,
  p.Email,
  a.line1,
  a.line2,
  a.line3,
  a.city,
  a.pincode,
  a.stat,
  d.doc_path,
  f.first_name as  ff_name,
  f.last_name as fl_name,
  f.relationship,
  f.Date_of_birth as fbob
  
  
from person p, address a, document d, family_info f
where p.person_id = a.person_id
and p.person_id = d.person_id
and p.person_id = f.person_id
and d.doc_name = 'profile'
and p.person_id = :person_id";

//passing profile id from other page
if (isset($_GET['id'])) {
  $person_id = intval($_GET['id']);
} else {
  $person_id = $_SESSION['personid'];
}

$stmt = $conn->prepare($query);
$stmt->execute([":person_id" => $person_id]);
$result = $stmt->fetch();

$queryo = "select d.doc_path

from person p, document d
where p.person_id = d.person_id
and d.doc_name = 'other'
and p.person_id = :person_id";

$stmto = $conn->prepare($queryo);
$stmto->execute([":person_id" => $person_id]);
$resulto = $stmto->fetch();

$first_name = ucwords(strtolower($result['First_name']));
$last_name = ucwords(strtolower($result['Last_name']));
$gender = $result['Gender'];
$date_of_birth = new DateTime($result['Date_of_birth']);
$dob = $date_of_birth->format("d-m-Y");
$mobile_no = $result['Mobile_no'];
$email = $result['Email'];
$line1 = ucfirst(strtolower($result['line1']));
$line2 = ucfirst(strtolower($result['line2']));
$line3 = ucfirst(strtolower($result['line3']));
$city = ucwords(strtolower($result['city']));;
$stat = ucwords(strtolower($result['stat']));
$pincode = $result['pincode'];
$doc_path = $result['doc_path'];
$ff_name = ucwords(strtolower($result['ff_name']));
$fl_name = ucwords(strtolower($result['fl_name']));
$relationship = ucwords(strtolower($result['relationship']));
$fdb = new DateTime($result['fbob']);
$fdob = $fdb->format("d-m-Y");

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
</head>

<div class="min_wid">
  <div class="row mx-0 px-0 mt-0 me-0">
    <?php if ($_SESSION['role'] == "A") { ?>
      <div class="col-3 px-0" style="width: 20%;"><?php include_once "sidebar.php"; ?>
      </div>

      <div class="col-6 profile-name" style="width: 60%;">
        <h1 class="name"><?php echo strtoupper($first_name); ?></h1>
        <h1 class="name"><?php echo strtoupper($last_name); ?></h1>
      </div>
      <div class="col-3 profile" style="width: 20%">

        <img class="profile-pic" src="<?php echo $doc_path; ?>" alt="Image"><br>
        <!-- <button type="button" class="border-0 bg-transparent ms-2 hover" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      <i class="fa-regular fa-pen-to-square" style="color: black;font-size:2rem;"></i>
              </button> -->

      </div>
  </div>

<?php } else { ?>
  <div class="col-8 profile-name">
    <h1 class="name"><?php echo strtoupper($first_name); ?></h1>
    <h1 class="name"><?php echo strtoupper($last_name); ?></h1>
  </div>
  <div class="col-4 profile">

    <img class="profile-pic" src="<?php echo $doc_path; ?>" alt="Image"><br>
    <!-- <button type="button" class="border-0 bg-transparent ms-2 hover" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      <i class="fa-regular fa-pen-to-square" style="color: black;font-size:2rem;"></i>
              </button> -->

  </div>
<?php }; ?>

<div class="row mt-0 me-0">
  <?php if ($_SESSION['role'] == "A") { ?>
    <div class="col-3 px-0" style="width: 20%;">
    </div>
    <div class="col-9" style="width: 80%;">
    <?php } else { ?>
      <div><?php }; ?>

      <div>
        <h1 class="addre d-inline">Personal Details:</h1>
        <?php if ($_SESSION['personid'] == $person_id) { ?>
          <button type="button" class="d-inline border-0 bg-transparent ms-2 hover" data-bs-toggle="modal" data-bs-target="#personal_details">
            <i class="fa-regular fa-pen-to-square" style="color: black;font-size:1.5rem;"></i>
          </button>
        <?php }; ?>
        <hr class="hr-line">
        <table class="table-1">
          <tr>
            <td class="head"><span>First Name </span></td>
            <td class="data"><span>: <?php echo $first_name; ?></span></td>
          </tr>
          <tr>
            <td class="head"><span>Last Name</span></td>
            <td class="data"><span>: <?php echo $last_name; ?></span></td>
          </tr>
          <tr>
            <td class="head"><span>Date of Birth</span></td>
            <td class="data"><span>: <?php echo  $dob; ?></span></td>
          </tr>
          <tr>
            <td class="head"><span>Mobile No.</span></td>
            <td class="data"><span>: <?php echo  $mobile_no; ?></td>
          </tr>
          <tr>
            <td class="head"><span>Email Id</span></td>
            <td class="data"><span>: <?php echo  $email; ?></td>
          </tr>
          <tr>
            <td class="head"><span>Gender</span></td>
            <td class="data"><span>: <?php echo  $gender; ?></td>
          </tr>

        </table>

      </div>

      <!-- update details -->
      <div class="modal fade" id="personal_details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Personal Details:</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" onsubmit="return validateform();">
                <div class="input-text">
                  <label for="fname">Name:</label><br>
                  <input type="text" id="fname" name="fname" placeholder="Enter Fist Name" maxlength="20" value="<?php echo $first_name; ?>">
                  <span class="err" id="fnameError"></span>
                  <input type="text" id="lname" name="lname" placeholder="Enter Last Name" maxlength="20" value="<?php echo $last_name; ?>">
                  <span class="err" id="lnameError"></span>
                  <br>
                  <label for="dob">Date of Birth:</label><br>
                  <input type="date" id="dob" name="dob" placeholder="Date of Birth" value="<?php echo $result['Date_of_birth']; ?>">
                  <span class="err" id="dobError"></span>
                  <br>
                  <label for="mobile">Mobile NO:</label><br>
                  <input type="text" id="mobile" name="mobile" placeholder="Enter Mobile No" maxlength="10" value="<?php echo $mobile_no; ?>">
                  <span class="err" id="mobileError"></span>
                  <br>
                  <label for="email">Email Id:</label><br>
                  <input type="email" id="email" name="email" placeholder="Enter Email ID" maxlength="40" value="<?php echo $email; ?>">
                  <span class="err" id="emailError"></span>
                </div>

                <div class="input-btn">
                  <label>Gender:</label><br>
                  <input type="radio" id="male" name="gender" value="M" <?php echo $gender == 'Male' ? 'checked' : ''; ?>>
                  <label for="male">Male</label>
                  <input type="radio" id="female" name="gender" value="F" <?php echo $gender == 'Female' ? 'checked' : ''; ?>>
                  <label for="female">Female</label>
                  <input type="radio" id="other" name="gender" value="O" <?php echo $gender == 'Other' ? 'checked' : ''; ?>>
                  <label for="other">Other</label>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="update" value="update1">Save changes</button>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>


      <br>
      <div>
        <h1 class="addre d-inline">Family details:</h1>
        <?php if ($_SESSION['personid'] == $person_id) { ?>
          <button type="button" class="d-inline border-0 bg-transparent ms-2 hover" data-bs-toggle="modal" data-bs-target="#Family_Details">
            <i class="fa-regular fa-pen-to-square" style="color: black;font-size:1.5rem;"></i>
          </button>
        <?php }; ?>
        <hr class="hr-line">
        <table class="table-1">
          <tr>
            <td class="head"><span>First Name: </span></td>
            <td class="data"><span><?php echo  $ff_name; ?></span></td>
          </tr>
          <tr>
            <td class="head"><span>Last Name:</span></td>
            <td class="data"><span><?php echo  $fl_name; ?></span></td>
          </tr>
          <tr>
            <td class="head"><span>Relationship:</span></td>
            <td class="data"><span><?php echo  $relationship; ?></span></td>
          </tr>
          <tr>
            <td class="head"><span>Date of Birth:</span></td>
            <td class="data"><span><?php echo  $fdob; ?></span></td>
          </tr>

        </table>
        <br>
      </div>

      <!-- update details -->
      <div class="modal fade" id="Family_Details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Family Details:</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" onsubmit=" return validateform2();">
                <div class="input-text">
                  <label for="ffname">Name:</label><br>
                  <input type="text" id="ffname" name="ffname" placeholder="Enter Fist Name" maxlength="20" value="<?php echo $ff_name; ?>">
                  <span class="err" id="ffnameError"></span><br>

                  <input type="text" id="fflname" name="fflname" placeholder="Enter Last Name" maxlength="20" value="<?php echo $fl_name; ?>">
                  <span class="err" id="flnameError"></span>
                  <br>
                  <label for="frel">Relation:</label><br>
                  <select class="select-op" id="frel" name="frel" value="<?php echo $retionship; ?>">
                    <option value="">Please Select relationship</option>
                    <option value="Father" <?php if ($relationship == 'Father') echo 'selected'; ?>>Father</option>
                    <option value="Mother" <?php if ($relationship == 'Mother') echo 'selected'; ?>>Mother</option>
                    <option value="Brother" <?php if ($relationship == 'Brother') echo 'selected'; ?>>Brother</option>
                    <option value="Sister" <?php if ($relationship == 'Sister') echo 'selected'; ?>>Sister</option>
                    <option value="Son" <?php if ($relationship == 'Son') echo 'selected'; ?>>Son</option>
                    <option value="Daughter" <?php if ($relationship == 'Daughter') echo 'selected'; ?>>Daughter</option>
                  </select>
                  <span class="err" id="frelError"></span>
                  <br>
                  <label for="fage">Date of birth:</label><br>
                  <input type="date" id="fage" name="fage" placeholder="Enter Date of birth" value="<?php echo $result['fbob']; ?>">
                  <span class="err" id="fageError"></span>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="update" value="update2">Save changes</button>
                </div>
              </form>

            </div>

          </div>
        </div>
      </div>



      <div>
        <h1 class="addre d-inline">Address:</h1>
        <?php if ($_SESSION['personid'] == $person_id) { ?>
          <button type="button" class="d-inline border-0 bg-transparent ms-2 hover" data-bs-toggle="modal" data-bs-target="#Address">
            <i class="fa-regular fa-pen-to-square" style="color: black;font-size:1.5rem;"></i>
          </button>
        <?php }; ?>
        <hr class="hr-line">

        <p class="addre"><?php echo  $line1; ?></p>
        <p class="addre"><?php echo  $line2; ?></p>
        <p class="addre"><?php echo  $line3; ?></p>
        <p class="addre"><?php echo  $city . ', ' . $stat . '-' . $pincode . '.' ?></p>


      </div>


      <div class="modal fade" id="Address" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Address:</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" onsubmit="return validateform3()">
                <div class="input-text">
                  <label for="aline1">Address line1:</label><br>
                  <input type="text" id="aline1" name="aline1" placeholder="Enter Address" maxlength="25" value="<?php echo $line1; ?>">
                  <span class="err" id="aline1Error"></span>
                  <br>
                  <label for="aline2">Address line2:</label><br>
                  <input type="text" id="aline2" name="aline2" placeholder="Enter Address" maxlength="25" value="<?php echo $line2; ?>">
                  <br>
                  <label for="aline3">Address line3:</label><br>
                  <input type="text" id="aline3" name="aline3" placeholder="Enter Address" maxlength="25" value="<?php echo $line3; ?>">
                  <br>
                  <label for="city">City:</label><br>
                  <input type="text" id="city" name="city" placeholder="Enter city name" maxlength="15" value="<?php echo $city; ?>">
                  <span class="err" id="cityError"></span>
                  <br>
                  <label for="pincode">Pincode:</label><br>
                  <input type="text" id="pincode" name="pincode" placeholder="Enter city name" maxlength="6" value="<?php echo $pincode; ?>">
                  <span class="err" id="pincodeError"></span>
                  <br>
                  <label for="state">State:</label><br>
                  <select class="select-op" id="state" name="state">
                    <option value="">Please Select state</option>
                    <option value="Andhra Pradesh" <?php if ($stat == 'Andhra Pradesh') echo 'selected'; ?>>Andhra Pradesh</option>
                    <option value="Arunachal Pradesh" <?php if ($stat == 'Arunachal Pradesh') echo 'selected'; ?>>Arunachal Pradesh</option>
                    <option value="Assam" <?php if ($stat == 'Assam') echo 'selected'; ?>>Assam</option>
                    <option value="Bihar" <?php if ($stat == 'Bihar') echo 'selected'; ?>>Bihar</option>
                    <option value="Chhattisgarh" <?php if ($stat == 'Chhattisgarh') echo 'selected'; ?>>Chhattisgarh</option>
                    <option value="Goa" <?php if ($stat == 'Goa') echo 'selected'; ?>>Goa</option>
                    <option value="Gujarat" <?php if ($stat == 'Gujarat') echo 'selected'; ?>>Gujarat</option>
                    <option value="Haryana" <?php if ($stat == 'Haryana') echo 'selected'; ?>>Haryana</option>
                    <option value="Himachal Pradesh" <?php if ($stat == 'Himachal Pradesh') echo 'selected'; ?>>Himachal Pradesh</option>
                    <option value="Jharkhand" <?php if ($stat == 'Jharkhand') echo 'selected'; ?>>Jharkhand</option>
                    <option value="Karnataka" <?php if ($stat == 'Karnataka') echo 'selected'; ?>>Karnataka</option>
                    <option value="Kerala" <?php if ($stat == 'Kerala') echo 'selected'; ?>>Kerala</option>
                    <option value="Madhya Pradesh" <?php if ($stat == 'Madhya Pradesh') echo 'selected'; ?>>Madhya Pradesh</option>
                    <option value="Maharashtra" <?php if ($stat == 'Maharashtra') echo 'selected'; ?>>Maharashtra</option>
                    <option value="Manipur" <?php if ($stat == 'Manipur') echo 'selected'; ?>>Manipur</option>
                    <option value="Meghalaya" <?php if ($stat == 'Meghalaya') echo 'selected'; ?>>Meghalaya</option>
                    <option value="Mizoram" <?php if ($stat == 'Mizoram') echo 'selected'; ?>>Mizoram</option>
                    <option value="Nagaland" <?php if ($stat == 'Nagaland') echo 'selected'; ?>>Nagaland</option>
                    <option value="Odisha" <?php if ($stat == 'Odisha') echo 'selected'; ?>>Odisha</option>
                    <option value="Punjab" <?php if ($stat == 'Punjab') echo 'selected'; ?>>Punjab</option>
                    <option value="Rajasthan" <?php if ($stat == 'Rajasthan') echo 'selected'; ?>>Rajasthan</option>
                    <option value="Sikkim" <?php if ($stat == 'Sikkim') echo 'selected'; ?>>Sikkim</option>
                    <option value="Tamil Nadu" <?php if ($stat == 'Tamil Nadu') echo 'selected'; ?>>Tamil Nadu</option>
                    <option value="Telangana" <?php if ($stat == 'Telangana') echo 'selected'; ?>>Telangana</option>
                    <option value="Tripura" <?php if ($stat == 'Tripura') echo 'selected'; ?>>Tripura</option>
                    <option value="Uttar Pradesh" <?php if ($stat == 'Uttar Pradesh') echo 'selected'; ?>>Uttar Pradesh</option>
                    <option value="Uttarakhand" <?php if ($stat == 'Uttarakhand') echo 'selected'; ?>>Uttarakhand</option>
                    <option value="West Bengal" <?php if ($stat == 'West Bengal') echo 'selected'; ?>>West Bengal</option>
                  </select>
                  <span class="err" id="stateError"></span>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="update" value="update3">Save changes</button>
                </div>

              </form>
            </div>

          </div>
        </div>
      </div>

      <div>
        <h1 class="addre d-inline">Other Details:</h1>
        <hr class="hr-line">
        <p class="addre d-inline">Resume file:</p>
        <button type="button" class="btn btn-primary mr-2 d-inline" data-bs-toggle="modal" data-bs-target="#Resume_file">
          View
        </button>

        <div class="modal fade" id="Resume_file" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Resume file:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <iframe src="<?php echo $resulto['doc_path']; ?>" style="width: 100%; height: 500px; border: none;"></iframe>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

              </div>

            </div>
          </div>
        </div>

        </div>
      </div>
      
    </div>
</div>
<?php include_once "footer.php"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['update'];

  switch ($action) {
    case 'update1':
      $fname = $_POST['fname'];
      $lname = $_POST['lname'];
      $dob = $_POST['dob'];
      $mobile = $_POST['mobile'];
      $email = $_POST['email'];
      $gender = $_POST['gender'];

      $query1 = "update Person
          set first_name = :fname, 
          last_name = :lname, 
          gender =  :gender,
          date_of_birth = :dob,
          mobile_no = :mobile,
          email = :email
          where person_id = :personid";

      $stmt1 = $conn->prepare($query1);
      $stmt1->execute([
        ':fname' => $fname,
        ':lname' => $lname,
        ':dob' => $dob,
        ':mobile' => $mobile,
        ':email' => $email,
        ':gender' => $gender,
        ':personid' => $person_id
      ]);
      echo "<script>alert('Record updated successfully.');window.location.href='profile.php?id=" . $person_id . "';</script>";
      break;

    case 'update2':
      $f_fname = $_POST['ffname'];
      $f_lname = $_POST['fflname'];
      $f_rel = $_POST['frel'];
      $f_age = $_POST['fage'];

      $query2 = "update family_info
          set first_name = :ffname,
          last_name = :flname,
          relationship = :frel,
          Date_of_birth = :fage
          where person_id = :personid";

      $stmtf = $conn->prepare($query2);
      $stmtf->execute([
        ':ffname' => $f_fname,
        ':flname' => $f_lname,
        ':frel' => $f_rel,
        ':fage' => $f_age,
        ':personid' => $person_id

      ]);
      echo "<script>alert('Record updated successfully.');window.location.href='profile.php?id=" . $person_id . "';</script>";
      break;

    case 'update3':
      $line1 = $_POST['aline1'];
      $line2 = $_POST['aline2'];
      $line3 = $_POST['aline3'];
      $city = $_POST['city'];
      $pincode = $_POST['pincode'];
      $state = $_POST['state'];

      $query3 = "update address
          set line1 = :line1,
          line2 = :line2,
          line3 = :line3,
          city = :city,
          pincode = :pincode,
          stat = :stat
          where person_id = :personid";

      $stmta = $conn->prepare($query3);
      $stmta->execute([
        ':line1' => $line1,
        ':line2' => $line2,
        ':line3' => $line3,
        ':city' => $city,
        ':pincode' => $pincode,
        ':stat' => $state,
        ':personid' => $person_id

      ]);
      echo "<script>alert('Record updated successfully.');window.location.href='profile.php?id=" . $person_id . "';</script>";
      break;

    default:
      echo "No valid action detected.";
      break;
  }
}
?>

<script src="<?php echo getSiteURL(); ?>/javascript/profile_edit.js?<?php echo time(); ?>"></script>