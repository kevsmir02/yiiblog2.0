<?php
class WebUser extends CWebUser
{
    // This method checks if the current user is an admin
    public function isAdmin()
    {
        return $this->name === 'admin'; // Assuming 'admin' is the username for the admin account
    }
}
