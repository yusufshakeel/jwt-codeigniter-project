<?php
/**
 * Author: Yusuf Shakeel
 * Date: 13-April-2018 Fri
 * Version: 1.0
 *
 * File: Profile.php
 * Description: This file contains the Profile controller class.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('profile');
    }
}
