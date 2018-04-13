<?php
/**
 * Author: Yusuf Shakeel
 * Date: 13-April-2018 Fri
 * Version: 1.0
 *
 * File: User.php
 * Description: This file contains the User controller class.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

header('Content-Type: application/json');

require_once __DIR__ . '/../helpers/php-jwt-5.0.0/src/JWT.php';
require_once __DIR__ . '/../helpers/php-jwt-5.0.0/src/BeforeValidException.php';
require_once __DIR__ . '/../helpers/php-jwt-5.0.0/src/ExpiredException.php';
require_once __DIR__ . '/../helpers/php-jwt-5.0.0/src/SignatureInvalidException.php';

use \Firebase\JWT\JWT;

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user_model');
    }

    public function signup()
    {
        // get the request method
        if (!isset($_SERVER['REQUEST_METHOD']) || !isset($_SERVER['REQUEST_URI'])) {
            echo json_encode(array(
                'code' => 400,
                'status' => 'error',
                'message' => 'Bad Request'
            ));
        }

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST') {

            //get json
            $data = json_decode(file_get_contents("php://input"), true);

            if (empty($data)) {
                $result = array(
                    'code' => 0,
                    'status' => 'error',
                    'message' => 'Data missing'
                );
            } else {
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]');
                if (!$this->form_validation->run() == FALSE) {
                    $result = $this->user_model->createUser($data);
                } else {
                    $result = array(
                        'code' => 0,
                        'status' => 'error',
                        'message' => 'Email already taken'
                    );
                }
            }

        } else {
            $result = array(
                'code' => 405,
                'status' => 'error',
                'message' => 'Method Not Allowed'
            );
        }

        echo json_encode($result);
    }

    public function login()
    {
        // get the request method
        if (!isset($_SERVER['REQUEST_METHOD']) || !isset($_SERVER['REQUEST_URI'])) {
            echo json_encode(array(
                'code' => 400,
                'status' => 'error',
                'message' => 'Bad Request'
            ));
        }

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST') {

            //get json
            $data = json_decode(file_get_contents("php://input"), true);

            if (empty($data)) {
                $result = array(
                    'code' => 0,
                    'status' => 'error',
                    'message' => 'Data missing'
                );
            } else {

                if (isset($data['email'])) {
                    $email = $data['email'];
                } else {
                    $email = null;
                }

                if (isset($data['password'])) {
                    $password = $data['password'];
                } else {
                    $password = null;
                }

                $result = $this->user_model->validateUserLoginCredential($email, $password);

                // on success generate jwt
                if (isset($result['status']) && $result['status'] === 'success') {
                    $payload = array(
                        'id' => $result['id'],
                        't' => time()
                    );
                    $key = WEBSITE_JWT_SECRET;
                    $alg = 'HS256';
                    $jwt = JWT::encode($payload, $key, $alg);
                    $result['jwt'] = $jwt;
                }
            }

        } else {
            $result = array(
                'code' => 405,
                'status' => 'error',
                'message' => 'Method Not Allowed'
            );
        }

        echo json_encode($result);
    }

    public function get()
    {
        // get the request method
        if (!isset($_SERVER['REQUEST_METHOD']) || !isset($_SERVER['REQUEST_URI'])) {
            echo json_encode(array(
                'code' => 400,
                'status' => 'error',
                'message' => 'Bad Request'
            ));
        }

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {

            // get the jwt from url
            $jwt = isset($_GET['jwt']) ? $_GET['jwt'] : null;

            if (isset($jwt)) {
                // validate jwt
                $key = WEBSITE_JWT_SECRET;
                try {
                    $decoded = JWT::decode($jwt, $key, array('HS256'));
                    $decoded_array = (array)$decoded;

                    $result = $this->user_model->getUser($decoded_array['id']);

                } catch (\Exception $e) {
                    $result = array(
                        'code' => 0,
                        'status' => 'error',
                        'message' => 'Invalid JWT - Authentication failed!'
                    );
                }
            } else {
                $result = array(
                    'code' => 0,
                    'status' => 'error',
                    'message' => 'JWT missing!'
                );
            }
        } else {
            $result = array(
                'code' => 405,
                'status' => 'error',
                'message' => 'Method Not Allowed'
            );
        }

        echo json_encode($result);
    }
}
