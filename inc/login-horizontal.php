<?php if(isset($_SESSION['valid'])): ?>
<div class="horizontal-login-form pull-right text-right">
<form class="form form-inline" action="?logout" method="post">
    <div class="input-group ">
        <i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['username']; ?>                              
    </div>
    <button type="submit" class="btn btn-default" name="logout">
        <i class="glyphicon glyphicon-log-out"></i></button>
</form>  
</div>
<div class="clearfix"></div>
<?php endif; ?>

<?php if(!isset($_SESSION['valid'])): ?>
<div class="horizontal-login-form">
<form class="form form-inline" action="?login" method="post">
    <div class="input-group col-xs-4">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input type="text" class="form-control" name="username" placeholder="Username">                                        
    </div>
    <div class="input-group col-xs-4">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input type="password" class="form-control" name="password" placeholder="Password">                                        
    </div>
    <button class="btn btn-default" type="submit" name="login">
        <i class="glyphicon glyphicon-log-in"></i></button>

</form>  
</div>
<div class="clearfix"></div>
<?php endif; ?>

