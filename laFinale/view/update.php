<?php

if(!empty($user)){

    $output = '<hr>
                 
                    <form action="index.php?page=app/update" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="' . $user->id . '">
                        <label for="uu-password">Mot de passe</label>
                        <input type="password" id="uu-password" name="password" class="form-control" value="' . $user->password . '">
                        <label for="uu-email">Email</label>
                        <input type="email" id="uu-email" name="email" class="form-control" value="' . $user->email . '">
                        <input type="submit" class="btn btn-primary">
                    </form>
                 </div>';
    echo $output;
}
