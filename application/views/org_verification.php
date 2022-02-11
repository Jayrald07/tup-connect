<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Organization Verification</title>
    <link rel="stylesheet" href="<?php echo base_url() . "public/style.css" ?>">
</head>
<body>
    <nav>
        <ul>
            <li>
                <a href=<?php echo base_url() ?>>
                    <img src="<?php echo base_url() . "public/assets/logo.svg" ?>" />
                </a>
            </li>
            <?php if ($is_admin) {?>
            <li>
                <a href=<?php echo base_url() . "org_verification/0" ?> class="admin-lock">
                    <i class="fas fa-lock"></i>
                </a>
            </li>
            <?php }?>
            <li class="user-pic-container">
                <a href="#">
                    <?php
                        $val = explode(".",$user_photo);
                        $path = "uploads/";
                        if ($val[0] === "user-1") $path = "public/assets/";
                    ?>
                    <img src=<?php echo base_url(). $path . $user_photo ?> />
                </a>
                <div class="account-option">
                    <ul>
                        <li>
                            <a href="<?php echo base_url() . "account" ?>">
                                <i class="fas fa-user"></i>
                                Account
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . "signout" ?>">
                                <i class="fas fa-sign-out"></i>
                                Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
    <div class="flex-display">
        <main class="org-card-container">
            <ul>
                <li>
                    <a href="0">Verification Request</a>
                </li>
                <li>
                    <a href="1">Approved</a>
                </li>
                <li>
                    <a href="2">Declined</a>
                </li>
                <li>
                    <a href="3">Revoked</a>
                </li>
            </ul>
            <?php foreach($orgs as $org): ?>
            <div class="org-card">
                <p><b>Requester: </b><?php echo $org["first_name"] . " " . $org["middle_name"] . " " .  $org["last_name"] ?></p>
                <p><b>Organization Name: </b><?php echo $org["organization_name"] ?></p>
                <p><b>Type: </b>College Based</p>
                <p><b>College: </b>Computer Science</p>
                <p><b>Category: </b>Engineering</p>
                <?php if ($status == 0)  {?>
                    <a href="javascript:void(0)" class="org-approve org-validate" x-value=<?php echo $org["organization_id"] ?> x-type="approve">Approve</a>
                    <a href="javascript:void(0)" class="org-decline org-validate" x-value=<?php echo $org["organization_id"] ?> x-type="decline">Decline</a>
                <?php } else if ($status == 1){?>
                    <a href="javascript:void(0)" class="org-approve org-validate" x-value=<?php echo $org["organization_id"] ?> x-type="reval">Revalidate</a>
                    <a href="javascript:void(0)" class="org-decline org-validate" x-value=<?php echo $org["organization_id"] ?> x-type="revoke">Revoke</a>
                <?php } else if ($status == 2){?>
                    <a href="javascript:void(0)" class="org-approve org-validate" x-value=<?php echo $org["organization_id"] ?> x-type="reval">Revalidate</a>
                    <a href="javascript:void(0)" class="org-decline org-validate" x-value=<?php echo $org["organization_id"] ?> x-type="del">Delete</a>
                <?php } else if ($status == 3){?>
                    <a href="javascript:void(0)" class="org-approve org-validate" x-value=<?php echo $org["organization_id"] ?> x-type="del">Delete</a>
                    <a href="javascript:void(0)" class="org-decline org-validate" x-value=<?php echo $org["organization_id"] ?> x-type="reval">Revalidate</a>
                <?php } ?>
            </div>
            <?php endforeach; ?>
            
        </main>
    </div>
    <script>
        var base_url = "<?php echo base_url() ?>"
    </script>
    <script src=<?php echo base_url() . "public/script.js" ?>></script>
    <script>
        controller.org_admin();
    </script>
</body>
</html>