    <nav class="<?php echo $CLASS_NAVBAR; ?>">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./">
                    <i class="fa fa-windows"></i> <strong>LOGO</strong>
                </a>
            </div>

            <div id="navbar" class="collapse navbar-collapse">
                <ul class="<?php echo $CLASS_NAV; ?>">
                    <li <?php if (isset($_GET['home'])) {echo 'class="active"';} ?>>
                        <a href="./?home"><i class="glyphicon glyphicon-home"></i> Home</a>
                   </li>
                    <li <?php if (isset($_GET['help'])) {echo 'class="active"';} ?>>
                        <a href="./?help"><i class="glyphicon glyphicon-education"></i> Help</a>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                            <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-lr login" style="padding: 15px; padding-bottom: 15px;">

                        <?php if (!isset($_SESSION['valid'])): ?>
                            <form class="form-horizontal" action="?login" method="post" accept-charset="UTF-8">
                            <div class="input-group login">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" class="form-control " name="username" placeholder="Username">
                            </div>
                            <div class="input-group login">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password" class="form-control " name="password" placeholder="Password">
                            </div>
                                <button class="btn btn-default btn-block" type="submit" name="login">
                                    <i class="glyphicon glyphicon-log-in"></i> Login
                                </button>
                            </form>
                        <?php else: ?>
                            <form class="form-horizontal" action="?logout" method="post" accept-charset="UTF-8">
                            <div class="input-group login">
                                <p>Welcome <i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['username']; ?></p>
                            </div>
                                <button class="btn btn-default btn-block" type="submit" name="logout">
                                    <i class="glyphicon glyphicon-log-out"></i> Logout
                                </button>
                            </form>
                        <?php endif; ?>
                        </div>
                    </li>
                </ul>
                <form class="navbar-form navbar-right" role="search" action="?search" enctype="multipart/form-data" method="POST">
                <div class="input-group">
                    <input type="text" class="form-control" name="searchword" id="search" placeholder="Search" >
                    <div class="input-group-btn">
                        <button class="btn btn-default" name="search" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </nav>
