<?php
class Shared_User_Auth 
{
    /**
     * @param int $passwordLength desired password length
     * @return array Array containing password, password hash and password salt
     */
    
    public static function generatePasswordAndHashAndSalt($passwordLength = 15){
        
        $password = self::generateRandomPassword($passwordLength);
        $salt = self::generateSalt();
        $passwordHash = self::generatePasswordHash($password, $salt);

        return array(
            'password' => $password,
            'passwordHash' => $passwordHash,
            'salt' => $salt
        );

    }

    public static function generateSalt(){
        return Shared_Text_Random::alphanumeric(50);
    }
    /**
     * Generates a password hash with a randomly generated salt.
     * @param string $password
     * @return array
     */
    public static function generatePasswordHash($password, $salt) {

        return sha1($salt . $password);

    }

    /**
     *
     * @param int $passwordLength desired password length
     * @return string
     */
    public static function generateRandomPassword($passwordLength = 15){

        $newPassword = Shared_Text_Random::alphanumeric($passwordLength);

        return $newPassword;
    }		
		
}
