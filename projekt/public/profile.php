<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #fbf9f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .profile-display {
            background: #f6d2e7;
            border-radius: 15px;
            padding: 30px;
            box-shadow: inset -30px -20px 60px 15px rgb(246, 242, 244);


        }
        .profile-img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 4px solid #f4eaed;
            object-fit: cover;
        }
        .text{
            color: #d31262;
        }
        .profile-edit {
            background: #fbfbfb;
            border-radius: 15px;
            padding: 30px;
            box-shadow: inset 0 0 0 0 rgb(251, 239, 245);
            border: 2px solid #f6daea;


        }
        .btn-pink {
            background-color: #ed4582;
            border: none;
        }
        .btn-pink:hover {
            background-color: #ff6d9c;
        }
        .btn-gray{
            background-color: #c8ccd3;
        }
        .btn-gray:hover{
            background-color: #e4e5ea;
        }
        .form-control:focus {
            border-color: #ed0c5d;
            box-shadow: 0 0 0 0.2rem rgba(255, 138, 180, 0.4);
        }
        .title-text {
            color: #7a0744;
            font-weight: 600;
        }
        .form-label{
            color: #d31262;
        }

        #edit {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
</head>

<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Profile Display Card -->
        <div class="col-md-9 mb-5">
            <div class="profile-card profile-display text-center">
                <img src="https://i.pravatar.cc/200" class="profile-img mb-3" alt="Profile">
                <h4 class="title-text mb-0">John Doe</h4>
                <p class="text">Beauty Enthusiast✨</p>
            </div>
        </div>

        <!-- Edit Form Card -->
        <div class="col-md-9">
            <div class="profile-card profile-edit">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="title-text mb-0">Personal Information</h5>
                    <button type="button" class="btn btn-pink text-white fw-semibold" id="editBtn">
                        Edit Profile
                    </button>
                    <form>
                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" placeholder="Enter last name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" placeholder="Enter email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Profile Photo</label>
                        <input type="file" class="form-control">
                    </div>
                    <div class="d-flex gap-3">
                    <button type="button" class="btn btn-pink text-white w-100 fw-semibold">
                        Save Changes
                    </button>
                    <button type="button" class=" btn btn-gray text-black w-100 fw-semibold">
                        Cancel
                    </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
