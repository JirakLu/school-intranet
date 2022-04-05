<?php

namespace App;

use Error;

class Session
{
    /**
     * Session Age.
     *
     * @var int
     */
    protected static int $SESSION_AGE = 1800;

    /**
     * Writes a value to the current session data.
     *
     * @param string $key String identifier.
     * @param mixed $value Single value or array of values to be written.
     * @return mixed Value or array of values written.
     */
    public static function set(string $key, mixed $value): mixed
    {
        self::_init();
        $_SESSION[$key] = $value;
        self::_age();
        return $value;
    }

    /**
     * Reads a specific value from the current session data.
     *
     * @param string $key String identifier.
     * @param mixed $child Optional child identifier for accessing array elements.
     * @return mixed Returns a string value upon success.  Returns false upon failure.
     */
    public static function get(string $key, mixed $child = false): mixed
    {
        self::_init();
        if (isset($_SESSION[$key])) {
            self::_age();

            if (false == $child)
            {
                return $_SESSION[$key];
            }
            else
            {
                if (isset($_SESSION[$key][$child]))
                {
                    return $_SESSION[$key][$child];
                }
            }
        }
        return false;
    }


    /**
     * Deletes a value from the current session data.
     *
     * @param string $key String identifying the array key to delete.
     * @return void
     */
    public static function delete(string $key)
    {
        self::_init();
        unset($_SESSION[$key]);
        self::_age();
    }

    /**
     * Echos current session data.
     *
     * @return void
     */
    public static function dump()
    {
        self::_init();
        echo nl2br(print_r($_SESSION));
    }

    /**
     * Starts or resumes a session by calling {@link Session::_init()}.
     *
     * @see Session::_init()
     * @return boolean Returns true upon success and false upon failure.
     */
    public static function start(): bool
    {
        // this function is extraneous
        return self::_init();
    }

    /**
     * Expires a session if it has been inactive for a specified amount of time.
     *
     * @return void
     * @throws Error Throws exception when read or write is attempted on an expired session.
     */
    private static function _age()
    {
        $last = $_SESSION['LAST_ACTIVE'] ?? false;

        if (false !== $last && (time() - $last > self::$SESSION_AGE))
        {
            self::destroy();
            throw new Error("Session have expired.");
        }
        $_SESSION['LAST_ACTIVE'] = time();
    }

    /**
     * Returns current session cookie parameters or an empty array.
     *
     * @return array Associative array of session cookie parameters.
     */
    public static function params(): array
    {
        $r = array();
        if ( '' !== session_id() )
        {
            $r = session_get_cookie_params();
        }
        return $r;
    }

    /**
     * Closes the current session and releases session file lock.
     *
     * @return boolean Returns true upon success and false upon failure.
     */
    public static function close(): bool
    {
        if ( '' !== session_id() )
        {
            return session_write_close();
        }
        return true;
    }


    /**
     * Removes session data and destroys the current session.
     *
     * @return void
     */
    public static function destroy()
    {
        if ( '' !== session_id() )
        {
            $_SESSION = array();

            // If it's desired to kill the session, also delete the session cookie.
            // Note: This will destroy the session, and not just the session data!
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            session_destroy();
        }
    }

    /**
     * Initializes a new secure session or resumes an existing session.
     *
     * @return boolean Returns true upon success and false upon failure.
     * @throws Error Sessions are disabled.
     */
    private static function _init(): bool
    {
        if (function_exists('session_status'))
        {
            // PHP 5.4.0+
            if (session_status() == PHP_SESSION_DISABLED)
                throw new Error("Session is disabled.");
        }

        if ( '' === session_id() )
        {
            $secure = true;
            $httponly = true;

            ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_httponly', 1);


            $params = session_get_cookie_params();

            session_set_cookie_params($params['lifetime'],
                $params['path'], $params['domain'],
                $secure, $httponly
            );

            return session_start();
        }

        return session_regenerate_id(true);
    }

}