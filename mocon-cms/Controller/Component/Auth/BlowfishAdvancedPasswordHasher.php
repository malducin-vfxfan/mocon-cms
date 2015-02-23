<?php
/**
 * Custom Blowfish password hasher.
 *
 * Hashes passwords using Blowfish encryption. It contains several
 * more features than the standard CakePHP implementation:
 *
 * - Can be configured via the project configuration file
 *   (cost and salt prefix).
 * - Salt generation is more secure using mcrypt_create_iv to get
 *   more entropy.
 * - Check the returned hash lenghth.
 *
 * We need at least PHP 5.3, preferably 5.3.7 or higher.
 *
 * References:
 *
 * http://blog.ircmaxell.com/2012/12/seven-ways-to-screw-up-bcrypt.html
 * http://stackoverflow.com/questions/10676542/bcrypt-and-random-salts-together-in-database
 * http://www.php.net/manual/en/function.crypt.php
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.Controller.Component.Auth
 */
App::uses('AbstractPasswordHasher', 'Controller/Component/Auth');

class BlowfishAdvancedPasswordHasher extends AbstractPasswordHasher {

/**
 * One way encryption using the PHP crypt() function.
 *
 * @param string $password The string to be encrypted.
 * @param mixed $salt false to generate a new salt or an existing salt.
 * @return string The hashed string or an empty string on error.
 */
    public function hash($password = null, $salt = false) {
        $cost = Configure::read('Security.BlowfishAdvanced.cost');
        if (!$cost) $cost = 10;
        if ($cost < 4 || $cost > 31) {
            throw new Exception('Invalid value, cost must be between 4 and 31');
        }

        if ($salt === false) {
            $salt = self::_salt(22);
            $salt = vsprintf('$%s$%02d$%s', array(Configure::read('Security.BlowfishAdvanced.salt_prefix'), $cost, $salt));
        }
        if (!strlen($salt) == 29) {
            throw new Exception('Error generating the salt.');
        }

        $hash = crypt($password, $salt);
        if (strlen($hash) != 60) {
            throw new Exception('Error hashing the password.');
        }

        return $hash;
    }

    public function check($password = null, $hashedPassword = null) {
        if (!$password || !$hashedPassword) return false;
        else return $hashedPassword === $this->hash($password, $hashedPassword);
    }

/**
 * Generates a pseudo random salt suitable for use with the PHP crypt() function.
 * The salt length should not exceed 27. The salt will be composed of
 * [./0-9A-Za-z]{$length}.
 *
 * @param integer $length The length of the returned salt
 * @return string The generated salt
 */
    private static function _salt($length = 22) {
        if (defined('MCRYPT_DEV_URANDOM')) {
            return substr(strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.'), 0, $length);
        } else {
            throw new Exception('The MCRYPT_DEV_URANDOM source is required (PHP 5.3+).');
        }
    }

}
