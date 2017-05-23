<?php

    if(secCheckMethod('POST')) {
        $post = secGetInputArray(INPUT_POST);
        $error = [];
        if(secValidateToken($post['_once'], 300)) {
            $email = validEmail($post['email']) ? $post['email'] : $error['email'] = 'Fejl i email.';
            $password = validMixedBetween($post['password']) ? $post['password'] : $error['password'] = 'Fejl i adgangskode';

            if(sizeof($error) === 0) {
                $stmt = $conn->prepare("SELECT brugere.id AS brugerId, brugere.password, brugere.email, profil.id AS profilId
                                        FROM brugere
                                        INNER JOIN profil 
                                        ON profil.id = brugere.fk_profil
                                        WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                if($stmt->execute() && ($stmt->rowCount() === 1)) {
                    $result = $stmt->fetch(PDO::FETCH_OBJ);
                    if(!password_verify($password, $result->password)) {
                        $error['password'] = 'Forkert adgangskode';
                    } else {
                        $_SESSION['profilid'] = $result->profilId;
                        $_SESSION['userid'] = $result->brugerId;
                        $_SESSION['username'] = $result->email;
                        header('Location: ?p=profil');
                    }
                }
            }
        }
    }

?>

<div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3" style="margin-top:250px;"> 
        
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="panel-title text-center">Log ind</div>
            </div>     

            <div class="panel-body" >

                <form action="" name="form" id="form" class="form-horizontal" enctype="multipart/form-data" method="POST">
                       <?=secCreateTokenInput()?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input id="email" type="text" class="form-control" name="email" placeholder="Email">                                        
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Adgangskode">
                    </div>                                                                  

                    <div class="form-group">
                        <!-- Button -->
                        <div class="col-sm-12 controls">
                            <button type="submit" href="#" name="login" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-log-in"></i> Log ind</button>                       
                        </div>
                    </div>

                </form>     

            </div>                     
        </div>  
    </div>