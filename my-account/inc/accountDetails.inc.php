
<?php
$user = User::getProfileById(Session::get('user_id'));
?>
<h3><?php echo Text::get('LABEL_ACCOUNT_DETAILS'); ?></h3>
            <table class="table table-striped table-condensed">
                <tr>
                    <th width="20%"><?php echo Text::get('LABEL_USER_ID'); ?></th><td><?php
                    echo Session::get('user_id');
                    ?></td>
                </tr>
                <tr>
                    <th width="20%"><?php echo Text::get('LABEL_USER_NAME'); ?></th><td><?php
                    echo Session::get('user_name');
                    ?></td>
                </tr>
                <tr>
                    <th width="20%"><?php echo Text::get('LABEL_USER_EMAIL'); ?></th><td><?php
                    echo Session::get('user_email');
                    ?></td>
                </tr>
                                <tr>
                    <th width="20%"><?php echo Text::get('LABEL_USER_LAST_LOGIN_TIMESTAMP'); ?></th><td><?php
                    echo $user['user_last_login_timestamp'];
                    ?></td>
                </tr>

                <!-- <tr>
                    <th width="20%"><?php //echo Text::get('LABEL_USER_ACCOUNT_TYPE'); ?></th><td><?php
                    //echo Session::get('user_account_type');
                    ?></td>
                </tr> -->
                <tr>
                    <th width="20%"><?php echo Text::get('LABEL_USER_PROVIDER_TYPE'); ?></th><td><?php
                    echo Session::get('user_provider_type');
                    ?></td>
                </tr>
                <tr>
                    <th width="20%"><?php echo Text::get('LABEL_USER_FBID'); ?></th><td><?php
                    if (!empty(Session::get('user_fbid'))) {
                        echo Session::get('user_fbid').' ';
                        echo '<form method="post"><input type="submit" name="clearUserFbid" class="btn btn-outline-success user_registered-login" value="';
                        echo Text::get('LABEL_USER_CLEAR_FBID');
                        echo '"/></form>';
                    } else {
                        echo '<a href="'.$loginUrl.'">Connect with Facebook!</a>';
                    }
                    ?></td>
                </tr>
                <!-- <tr>
                    <th width="20%">Rol</th><td> -->
                    <?php
                    //$role_id = $u->getRoleIDByUserID($userData['id']);
                    //$role_name = $u->getRoleNameByRoleID($role_id);
                    //echo $role_name;
                    ?>
                    <!-- </td>
                </tr> -->
                <!-- <tr>
                    <th width="20%">Geregistreerd op</th>
                    <td> -->
                    <?php //echo $userData['CreationDate']; ?>
                    <!-- </td>
                </tr> -->
                <!-- <tr>
                    <th width="20%">Laatst gewijzigd</th><td> -->
                    <?php //echo $userData['ModificationDate']; ?>
                    <!-- </td>
                </tr> -->
            </table>