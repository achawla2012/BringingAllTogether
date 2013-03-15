<?php
include_once 'functions.php';
echo '<h3>Setting up </h3>';
CreateTable('members', 'user VARCHAR(16), pass VARCHAR(16), INDEX(user(6))');
CreateTable('friends', 'user VARCHAR(16), friend VARCHAR(16), INDEX(user(6)), INDEX(friend(6))');
CreateTable('profiles','user VARCHAR(16), text VARCHAR(4096), INDEX(user(6))');
CreateTable('messages','id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, auth VARCHAR(16), recip VARCHAR(16),
             pm CHAR(1), time INT UNSIGNED, message VARCHAR(4096), INDEX(auth(6)), INDEX(recip(6))');
?>