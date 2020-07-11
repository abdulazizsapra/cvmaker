<?php

require_once('db.class.php');

class User extends Database
{
    private $_user_id;
    private $_username;
    private $_user_password;
    private $_user_email;
    private $_user_type;
    private $_user_status;


    public function __construct(
        $user_id = 0,
        $username = "",
        $user_mail = "",
        $user_password = "",
        $user_type = "",
        $user_status = ""
    ) {
        parent::__construct();
        $this->_user_id         = $user_id;
        $this->_username        = $username;
        $this->_user_password   = $user_password;
        $this->_user_email      = $user_mail;
        $this->_user_type       = $user_type;
        $this->_user_status = $user_status;
    }
    public function insert_user()
    {
        $this->query("INSERT INTO `users`
                                    (`username`,
                                    `user_email`,
                                    `user_type`,
                                    `user_status`,
                                    `user_password`)
                                        VALUES (
                                            :username,
                                            :user_email,
                                            :user_type,
                                            :user_status,
                                            :user_password
                                            )");

        $this->bind(":username", $this->_username);
        $this->bind(":user_password", $this->_user_password);
        $this->bind(":user_email", $this->_user_email);
        $this->bind(":user_type", $this->_user_type);
        $this->bind(":user_status", $this->_user_status);

        return $this->run();
    }

    public function login_user($user_email, $password)
    {

        $this->query("SELECT * FROM `users` WHERE  user_email=:user_mail and  user_password=:user_pass");
        $this->bind(":user_mail", $user_email);
        $this->bind(":user_pass", $password);

        return $this->single();
    }

    public function get_by_email($user_email)
    {

        $this->query("Select * from users where user_email=:user_email");
        $this->bind(":user_email", $user_email);
        return $this->single();
    }
    public function get_all()
    {
        $this->query("Select * from users where user_type='user'");
        return $this->all();
    }
    public function get_single_by_userid($user_id)
    {

        $this->query("Select * from users where user_id=:user_id");
        $this->bind("user_id", $user_id);
        return $this->all();
    }
    public function delete($user_id)
    {

        $this->query("DELETE FROM `users` WHERE user_id=:user_id");
        $this->bind(":user_id", $user_id);
        return $this->run();
    }
    public function edit_users()
    {
        $this->query("UPDATE `users` SET
                            `user_name`      =:username,
                            `user_email`     =:user_email,
                            `user_password`   =:user_password,
                             WHERE
                             `user_id`=:userid
                             ");
        $this->bind(":userid", $this->_user_id);
        $this->bind(":username", $this->_username);
        $this->bind(":user_email", $this->_user_email);
        $this->bind(":user_password", $this->_user_password);
        return $this->run();
    }

    public function change_status($user_id,$status)
    {
        $this->query("UPDATE users SET
                            user_status = :user_status
                             WHERE
                             user_id = :user_id
                             ");
        $this->bind(":user_id", $user_id);
        $this->bind(":user_status", $status);

        return $this->run();
    }
}
