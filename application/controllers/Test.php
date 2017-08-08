<?php 
/**
* 
*/
class Test extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function connect($provider = "facebook", $redirect = "")
	{
		$userId = 0;
        log_message('debug', "controllers.Connect.login($provider) called");

        try {
            log_message('debug', 'controllers.Connect.login: loading HybridAuthLib');

            if ($this->hybridauthlib->providerEnabled($provider)) {
                log_message('debug', "controllers.Connect.login: service $provider enabled, trying to authenticate.");
                $service = $this->hybridauthlib->authenticate($provider);

                if ($service->isUserConnected()) {
                    log_message('debug', 'controller.Connect.login: user authenticated.');

                    $user_profile = $service->getUserProfile();
                    /*var_dump((array)$user_profile);die();*/

                    log_message('info', 'controllers.Connect.login: user profile:' . PHP_EOL . print_r($user_profile, TRUE));

                    if ($_SERVER['REQUEST_METHOD']=='POST' && $user_profile->emailVerified=='') {
                        if ($this->validateForm()) {
                            $post = purify($this->input->post());

                            $user_profile->displayName = $post['name'];
                            $user_profile->emailVerified = $post['email'];
                            $user_profile->phone = phoneFormat($post['phone']);
                        }
                    }



                    if ($user_profile->emailVerified != '') {
                        if ($this->auth->email_check($user_profile->emailVerified)) {
                            $this->auth->social_login($user_profile->emailVerified);
                            $userId = $this->auth->getUserId($user_profile->emailVerified);
                            $user_id = $this->auth->user()->row()->id;
                            if (!$this->auth->social_check($provider, $user_profile->identifier)) {
                                $this->createUserSocial($user_id, $user_profile, $provider);
                            }
                        } else {
                            $userId = $this->createUser($user_profile, $provider);
                        }
                    } else {
                        $arrUserProfile = (array) $user_profile;
                        header("Location:".base_url().sprintf('hauth/additional/%s/%s/%s/%s', $provider, urlencode($arrUserProfile['displayName']), urlencode($arrUserProfile['emailVerified']), urlencode($arrUserProfile['phone'])));exit;

                        if (!$this->auth->social_check($provider, $user_profile->identifier)) {
                            $this->createUserSocial(null, $user_profile, $provider);
                        }
                        // TODO: Show form to let user enter email and password or merge existing account
                    }

                    $arrFb = (array) $user_profile;
                    $arrSession = $this->auth->getUser($userId);
                    $this->session->set_userdata('userConnected', $arrSession);

                    if ($redirect) {
                        if ($redirect=='joinnow') {
                            redirect(base_url().$redirect);
                        } else {
                            redirect(base_url().'#'.$redirect);
                        }
                    } else {
                        redirect(base_url().'games');
                    }

                } else // Cannot authenticate user
                {
                    show_error('Cannot authenticate user');
                }
            }
            else // This service is not enabled.
            {
                log_message('error', 'controllers.Connect.login: This provider is not enabled (' . $provider . ')');
                dd('controllers.Connect.login: This provider is not enabled (' . $provider . ')');
            }
        } catch (Exception $e) {
            $error = 'Unexpected error';
            switch ($e->getCode()) {
                case 0 :
                    $error = 'Unspecified error.';
                    break;
                case 1 :
                    $error = 'Hybriauth configuration error.';
                    break;
                case 2 :
                    $error = 'Provider not properly configured.';
                    break;
                case 3 :
                    $error = 'Unknown or disabled provider.';
                    break;
                case 4 :
                    $error = 'Missing provider application credentials.';
                    break;
                case 5 :
                    log_message('debug', 'controllers.Connect.login: Authentification failed. The user has canceled the authentication or the provider refused the connection.');
                    //redirect();
                    if (isset($service)) {
                        log_message('debug', 'controllers.Connect.login: logging out from service.');
                        $service->logout();
                    }
                    show_error('User has cancelled the authentication or the provider refused the connection.');
                    break;
                case 6 :
                    $error = 'User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.';
                    break;
                case 7 :
                    $error = 'User not connected to the provider.';
                    break;
            }

            if (isset($service)) {
                $service->logout();
            }

            log_message('error', 'controllers.Connect.login: ' . $error);
            show_error('Error authenticating user.');
        }
	}
}
?>