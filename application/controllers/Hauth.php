<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hauth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->auth->logged_in()) {
            redirect('profile');
        } else {
            redirect(site_url());
        }
    }

    public function login($provider, $option = "")
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
                    // echo $option.'test';die();
                    if ($option!="") {
                        if ($option=='logout') {
                            $token = $service->getAccessToken();
                            $service->logout();
                            $url = 'https://www.facebook.com/logout.php?next=' . base_url() .'&access_token='.$token['access_token'];

                            header("Location:".$url);die();
                        }
                    }

                    log_message('info', 'controllers.Connect.login: user profile:' . PHP_EOL . print_r($user_profile, TRUE));

                    if ($_SERVER['REQUEST_METHOD']=='POST' && $user_profile->emailVerified=='') {
                        if ($this->validateForm()) {
                            $post = purify($this->input->post());

                            $user_profile->displayName = $post['name'];
                            $user_profile->emailVerified = $post['email'];
                            $user_profile->phone = phoneFormat($post['phone']);
                        }
                    }
/*print_r($user_profile);die();*/
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

                            $cekRelationUsers = $this->auth->cek_usersRelation($arrUserProfile['identifier']);
                            if ($cekRelationUsers=="" || is_null($cekRelationUsers)) {
                            	$user_id = $userId;
                            	$this->createUserSocial($user_id, $user_profile, $provider);
                            }
                        }
                    } else {
                        if (!$this->auth->social_check($provider, $user_profile->identifier)) {
                            $this->createUserSocial(null, $user_profile, $provider);
                        }
                        // TODO: Show form to let user enter email and password or merge existing account
                        $arrUserProfile = (array) $user_profile;
                        $cekIdentifier = $this->auth->cek_usersRelation($arrUserProfile['identifier']);
                        if ($cekIdentifier=="" || is_null($cekIdentifier)) {
                            header("Location:".base_url().sprintf('hauth/additional/%s/%s/%s/%s', $provider, urlencode($arrUserProfile['displayName']), urlencode($arrUserProfile['emailVerified']), urlencode($arrUserProfile['phone'])));exit;
                        }
                        $userId = $this->auth->userId_socialCheck($provider, $user_profile->identifier);
                    }

                    $arrFb = (array) $user_profile;
                    $arrSession = $this->auth->getUser($userId);
                    // print_r($arrSession);die();
                    $this->session->set_userdata('userConnected', $arrSession);


                    redirect(base_url().'games');

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
            show_error('Error authenticating user.'. $error);
        }
    }

    public function status()
    {
        header("Location:".base_url().'hauth/facebook/status');
    }

    private function validateForm()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $error = array();
            $post = purify($this->input->post());
            $email = isset($post['email'])?$post['email']:"";

            if ($post['email'] == '') {
                $error['email'] = 'Please insert Email.<br/>';
            } else {
                if (!mycheck_email($post['email'])) {
                    $error['email'] = 'Please insert correct Email.<br/>';
                }
            }

            if ($post['phone']=='') {
                $error['phone'] = 'Please insert Phone Number';
            } else {
                if (!ctype_digit($post['phone']))  $error['phone'] = 'Please insert Correct Phone Number';
            }

            if (count($error) > 0) {
                $this->session->set_flashdata('error_msg', $error);
                header("Location:".base_url().'hauth/additional/');
            } else {
                return true;
            }
        }
    }

    public function additional($provider, $name = null, $email = null, $phone = null)
    {
        $data = array('error' => $this->session->flashdata('error_msg'),
                      'provider' => $provider,
                      'name' => !is_null($name)?urldecode($name):"",
                      'email' => !is_null($email)?urldecode($email):"",
                      'phone' => !is_null($phone)?urldecode($phone):"");
        $this->load->view('frontend/userdetail', $data);
    }

    public function facebook($redirect = "")
    {
        $this->login('Facebook', $redirect);
    }

    public function twitter()
    {
        $this->login('Twitter');
    }

    public function google()
    {
        $this->login('Google');
    }

    private function createUser($user_profile, $provider)
    {
        $filename = uniqid() . '.jpg';
        $avatar_path = FCPATH .'uploads/avatars/'. $filename;

        file_put_contents($avatar_path, file_get_contents($user_profile->photoURL));

        $data = [
            'group_id' => 3,
            'email' => !is_null($user_profile->emailVerified)?$user_profile->emailVerified:"",
            'username' => !is_null($user_profile->username)?$user_profile->username:"",
            'password' => '',
            'name' => !is_null($user_profile->displayName)?$user_profile->displayName:"",
            'avatar' => $filename,
            'phone' => !is_null($user_profile->phone)?$user_profile->phone:"", 
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $user_id = $this->auth->create($data);

        $this->auth->update_last_login($user_id);
        $this->auth->set_session($this->auth->user($user_id)->row());

        $this->createUserSocial($user_id, $user_profile, $provider);
        /*$cekTProviderUserid = $this->auth->cekTProviderUserid($user_id);
        var_dump($cekTProviderUserid);die();*/

        return $user_id;
    }

    private function createUserSocial($user_id, $user_profile, $provider)
    {
        $data = [
            'user_id' => $user_id,
            'provider' => $provider,
            'provider_uid' => $user_profile->identifier,
            'email' => $user_profile->emailVerified,
            'display_name' => $user_profile->displayName,
            'first_name' => $user_profile->firstName,
            'last_name' => $user_profile->lastName,
            'profile_url' => $user_profile->profileURL,
            'website_url' => $user_profile->webSiteURL,
            'photo_url' => $user_profile->photoURL,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $identifierExists = $this->auth->identifier_exist($user_profile->identifier);
        if (is_array($identifierExists) && count($identifierExists) > 0) {

        	$id = isset($identifierExists['id'])?$identifierExists['id']:"";
        	if ($id!="") {
        		$this->auth->updateSocial($id, $data);
        	}
        } else {
            $this->auth->createSocial($data);
        }
    }

    public function endpoint()
    {
        log_message('debug', 'controllers.Connect.endpoint called.');
        log_message('info', 'controllers.Connect.endpoint: $_REQUEST: ' . print_r($_REQUEST, TRUE));

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            log_message('debug', 'controllers.Connect.endpoint: the request method is GET, copying GET array into REQUEST array.');
            $_REQUEST = $_GET;
        }

        log_message('debug', 'controllers.Connect.endpoint: loading the original HybridAuth endpoint script.');

        // ------------------------------------------------------------------------
        //	HybridAuth End Point
        // ------------------------------------------------------------------------
        require_once(APPPATH . 'third_party/Hybridauth/Auth.php');
        require_once(APPPATH . 'third_party/Hybridauth/Endpoint.php');
        Hybrid_Endpoint::process();
    }
}

/* End of file connect.php */
/* Location: ./application/controllers/connect.php */