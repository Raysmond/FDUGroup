<?php
/**
 * User login view
 * @author: Raysmond
 */
?>
<?php
    if(isset($username)){
        echo "username: ".$username." <br/>password: ".$password;
    }
?>
<form id="singin-form" class="form-signin" method="post" action="#">
    <h2 class="form-signin-heading">Please sign in</h2>
    <input name="username" type="text" class="form-control" placeholder="User name" autofocus>
    <input name="password" type="password" class="form-control" placeholder="Password">
    <label class="checkbox">
        <input name="rememberMe" type="checkbox" value="remember-me"> Remember me
    </label>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>