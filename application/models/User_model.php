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

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This will create user account.
     *
     * @param array $arrdata
     * @return mixed
     */
    public function createUser($arrdata)
    {
        /**
         * scrutinize data
         */
        foreach ($arrdata as $key => $value) {
            if (!in_array($key, array('email', 'password', 'firstname', 'lastname'))) {
                return array(
                    'code' => '0',
                    'status' => 'error',
                    'message' => 'Invalid parameter: ' . $key
                );
            }
        }

        //id
        $id = time() . rand(1000, 9999);
        $datetime = date('Y-m-d H:i:s');
        $arrdata['id'] = $id;
        $arrdata['lastmodified'] = $datetime;
        $arrdata['created'] = $datetime;

        if (isset($arrdata['password'])) {
            $arrdata['password'] = password_hash($arrdata['password'], PASSWORD_BCRYPT, ["cost" => 12]);
        }

        try {
            $result = $this->db->insert(DB_TBL_USER, $arrdata);
        } catch (\Exception $e) {
            return array(
                'code' => '0',
                'status' => 'error',
                'message' => 'DB Error: ' . $e
            );
        }

        $sql = $this->db->last_query();
        error_log('FILE: ' . __FILE__ . ' FUNCTION: ' . __FUNCTION__ . ' LINE: ' . __LINE__ . ' SQL: ' . $sql);

        if ($this->db->error()['code']) {
            error_log('FILE: ' . __FILE__ . ' FUNCTION: ' . __FUNCTION__ . ' LINE: ' . __LINE__ . ' SQL QUERY FAILED: ' . json_encode($this->db->error()));
            return array(
                'code' => $this->db->error()['code'],
                'status' => 'error',
                'message' => 'DB Error: ' . $this->db->error()
            );
        }

        if ($this->db->affected_rows() > 0) {
            $result = array(
                'code' => '200',
                'status' => 'success',
                'id' => $id,
                'message' => 'Account created successfully.'
            );
        } else {
            $result = array(
                'code' => $this->db->error()['code'],
                'status' => 'error',
                'message' => 'Failed to insert data in the table.'
            );
        }

        return $result;

    }

    /**
     * This will return user account detail.
     *
     * @param string $id
     * @return mixed
     */
    public function getUser($id)
    {
        $where_clause = array();

        if (isset($id)) {
            $where_clause['id'] = $id;
        }

        $this->db->select('id, firstname, lastname, email, created, lastmodified');
        $this->db->from(DB_TBL_USER);
        $this->db->where($where_clause);
        $query = $this->db->get();

        $sql = $this->db->last_query();
        error_log('FILE: ' . __FILE__ . ' FUNCTION: ' . __FUNCTION__ . ' LINE: ' . __LINE__ . ' SQL: ' . $sql);

        if ($this->db->error()['code']) {
            error_log('FILE: ' . __FILE__ . ' FUNCTION: ' . __FUNCTION__ . ' LINE: ' . __LINE__ . ' SQL QUERY FAILED: ' . json_encode($this->db->error()));
            return array(
                'code' => $this->db->error()['code'],
                'status' => 'error',
                'message' => 'DB Error: ' . $this->db->error()
            );
        }

        if ($query->num_rows() > 0) {
            $result = array(
                'code' => '200',
                'status' => 'success',
                'data' => $query->row_array()
            );
        } else {
            $result = array(
                'code' => '0',
                'status' => 'error',
                'message' => 'No match found'
            );
        }

        return $result;

    }

    /**
     * This will validate user login credential.
     *
     * @param string $email
     * @param string $password
     * @return mixed
     */
    public function validateUserLoginCredential($email = null, $password = null)
    {
        if (!isset($email)) {
            return array(
                'code' => '0',
                'status' => 'error',
                'message' => 'Email missing'
            );
        }

        if (!isset($password)) {
            return array(
                'code' => '0',
                'status' => 'error',
                'message' => 'Password missing'
            );
        }

        $where_clause = array(
            'email' => $email
        );

        $select = 'id, email, password';

        $this->db->select($select);
        $this->db->from(DB_TBL_USER);
        $this->db->where($where_clause);
        $query = $this->db->get();

        $sql = $this->db->last_query();
        error_log('FILE: ' . __FILE__ . ' FUNCTION: ' . __FUNCTION__ . ' LINE: ' . __LINE__ . ' SQL: ' . $sql);

        if ($this->db->error()['code']) {
            error_log('FILE: ' . __FILE__ . ' FUNCTION: ' . __FUNCTION__ . ' LINE: ' . __LINE__ . ' SQL QUERY FAILED: ' . json_encode($this->db->error()));
            return array(
                'code' => $this->db->error()['code'],
                'status' => 'error',
                'message' => 'DB Error: ' . $this->db->error()
            );
        }

        if ($query->num_rows() > 0) {
            $row = $query->row_array();

            error_log(json_encode($row));
            if (!password_verify($password, $row['password'])) {
                $result = array(
                    'code' => '401',
                    'status' => 'error',
                    'message' => 'Invalid login credentials.'
                );
            } else {
                $result = array(
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Valid login credentials.',
                    'id' => $row['id']
                );
            }
        } else {
            $result = array(
                'code' => '0',
                'status' => 'error',
                'message' => 'No match found'
            );
        }

        return $result;

    }

    public function __destruct()
    {
        $this->db->close();
    }

}