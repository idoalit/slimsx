<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 25/07/2022 22:24
 * @File name           : AdminLogon.php
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

namespace SLiMS;


use SLiMS\Models\Default\Holiday;
use SLiMS\Models\Default\User;
use SLiMS\Models\Default\UserGroup;

class AdminLogon
{
    private string $username;
    private string $password;
    private string $auth_method;
    private User $user;
    private $error = '';
    public ?string $real_name = '';
    public bool $ip_check = false;
    public array $ip_allowed = [];

    /**
     * Class Constructor
     *
     * @param string $str_username
     * @param string $str_password
     * @param string $str_auth_method
     * @return  void
     */
    public function __construct(string $str_username, string $str_password, string $str_auth_method = 'native') {
        $this->username = trim($str_username);
        $this->password = trim($str_password);
        $this->auth_method = $str_auth_method;
    }

    /**
     * Method to check user validity
     *
     * @return  boolean
     */
    public function adminValid(): bool
    {
        # check login dependent with auth method
        $check_login = call_user_func([$this, $this->auth_method . 'Login']);
        if (!$check_login) return false;

        # ip checking
        if ($this->ip_check && in_array($_SERVER['REMOTE_ADDR'], $this->ip_allowed)) {
            $this->error = __('IP not allowed to login');
            return false;
        }

        $this->real_name = $this->user->realname;
        # fill all sessions var
        $_SESSION['uid'] = $this->user->user_id;
        $_SESSION['uname'] = $this->user->username;
        $_SESSION['realname'] = $this->user->realname;
        $_SESSION['upict'] = $this->user->user_image ?? 'person.png';

        $_SESSION['groups'] = null;
        if ($this->user->groups) {
            $_SESSION['groups'] = unserialize($this->user->groups);
            # fetch group privileges
            foreach ($_SESSION['groups'] as $group_id) {
                $group = UserGroup::find($group_id);
                foreach ($group->access as $access) {
                    $module = $access->module;
                    $tmp = $_SESSION['priv'][$module->module_path] ?? [];
                    if ($access->r) $tmp['r'] = true;
                    if ($access->w) $tmp['w'] = true;
                    if ($access->menus) {
                        $menu = json_decode($access->menus, true);
                        if (isset($_SESSION['priv'][$module->module_path]['menus'])) {
                            $tmp['menus'] = array_unique(array_merge($menu, $tmp['menus']));
                        } else {
                            $tmp['menus'] = $menu;
                        }
                    }
                    $_SESSION['priv'][$module->module_path] = $tmp;
                }
            }
        }

        # session vars needed by some application modules
        $_SESSION['logintime'] = time();
        $_SESSION['temp_loan'] = array();
        $_SESSION['biblioAuthor'] = array();
        $_SESSION['biblioTopic'] = array();
        $_SESSION['biblioAttach'] = array();

        if (!defined('UCS_VERSION')) {
            $holidays = Holiday::whereNull('holiday_date')->get(['holiday_dayname']);
            $_SESSION['holiday_dayname'] = $holidays->map(fn($h) => $h->holiday_dayname)->toArray();

            $_SESSION['holiday_date'] = [];
            Holiday::whereNotNull('holiday_date')->get(['holiday_date'])->each(function ($h) {
                $_SESSION['holiday_date'][$h->holiday_date] = $h->holiday_date;
            });
        }

        # save md5sum of current application path
        if (config('load_balanced_env')) {
            $server_addr = $_SERVER['REMOTE_ADDR'];
        } else {
            $server_addr = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : (isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']));
        }
        $_SESSION['checksum'] = defined('UCS_BASE_DIR')?md5($server_addr.UCS_BASE_DIR.'admin'):md5($server_addr.SB.'admin');

        return true;
    }

    /**
     * Native database checking login method
     *
     * @return  boolean
     */
    protected function nativeLogin(): bool
    {
        # get user model base on username
        $user = User::where('username', $this->username)->first();
        $this->user = $user;
        if (is_null($user)) {
            $this->error = __('Username not exists in database!');
            return false;
        }

        # verify password
        if (password_verify($this->password, $user->passwd)) {
            # update the last login time
            $user->last_login = date("Y-m-d H:i:s");
            $user->last_login_ip = $_SERVER['REMOTE_ADDR'];
            $user->save();
            return true;
        }

        $this->error = __('Password does not match!');
        return false;
    }
}