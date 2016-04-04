<header>
    <form>
        <div class="form-group">
            <input type="text" placeholder="search games..">
            <a class="btn" href="#">
                <i class="fa fa-search"></i>
            </a>
        </div>
    </form>
<!--    <div id="account-panel">
        <i class="fa fa-user"></i>
        <a href="#">
            Sign In
        </a>       
        <p>/</p>
        <a href="#">
            Join Us
        </a>
    </div>-->
</header>

<nav>
    <ul id="menu">
        <li class="<?php echo $page==='home' ? 'active' : ''?>">
            <a href="#" >
                home
            </a>
        </li>
        <li class="<?php echo $page==='reviews' ? 'active' : ''?>">
            <a href="#">
                reviews
            </a>
        </li>
        <li class="<?php echo $page==='video' ? 'active' : ''?>">
            <a href="#">
                video
            </a>
        </li>
        <li class="<?php echo $page==='donate' ? 'active' : ''?>">
            <a href="#">
                donate
            </a>
        </li>
        <li class="<?php echo $page==='account' ? 'active' : ''?>">
            <a href="#">
                account
            </a>
        </li>
        <li class="<?php echo $page==='contact' ? 'active' : ''?>">
            <a href="#">
                contact
            </a>
        </li>        
    </ul>
</nav>    
