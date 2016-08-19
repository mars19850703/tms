<div class="page-header-menu">
    <div class="container">
        <!-- BEGIN MEGA MENU -->
        <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
        <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
        <div class="hor-menu  hor-menu-light">
            <ul class="nav navbar-nav">
                <?php foreach($website["menu"] as $menu): ?>
                    <li class="<?php echo (isset($menu["item"]) ? "menu-dropdown classic-menu-dropdown":""); ?>">
                        <a href="<?php echo (isset($menu["link"]) ? $menu["link"]:"javascript:;"); ?>">
                            <?php if(isset($menu["icon_class"])): ?>
                                <i class="<?php echo $menu["icon_class"]; ?>"></i>
                            <?php endif; ?>
                            <?php echo $menu["title"]; ?>
                        </a>
                        <?php if(isset($menu["item"])): ?>
                            <ul class="dropdown-menu pull-left">
                                <?php foreach($menu["item"] as $subMenu): ?>
                                    <li>
                                        <a href="<?php echo $subMenu["link"]; ?>">
                                            <?php if(isset($subMenu["icon_class"])): ?>
                                                <i class="<?php echo $subMenu["icon_class"]; ?>"></i>
                                            <?php endif; ?>
                                            <?php echo $subMenu["title"]; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- END MEGA MENU -->
    </div>
</div>